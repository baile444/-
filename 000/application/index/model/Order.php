<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/7/18
 * Time : 15:04
 * Email: 417780879@qq.com
 */
namespace app\index\model;
use app\admin\model\Jifen;
use app\admin\model\Level;
use think\Db;
use think\facade\Log;
use think\Model;
use think\Request;

class Order extends Model
{
    protected $table='order';
    protected $pk='orid';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;
    public function store($data){
        $this->allowField('order_id,user_id,fen,money,aid')->save($data);
        return $this->orid;
    }
    public function successstore($data){
        return $this->allowField('oldprice,moneyvalue,fenvalue')->save($data,[$this->pk=>$data[$this->pk]]);
    }

    public function orderMessage($user_id,$orid){
        return $this->where('user_id',$user_id)->where('orid',$orid)->find();
    }

    /**
     * 分类统计订单数量
     * @param $user_id
     *
     * @return array
     */
    public function ordercounts($user_id){
        $time=time()-1800;
        $map1=[
            ['user_id','=',$user_id],
            ['ordersta','=',0],
            ['sta','>',0]
        ];
        $map2=[
            ['user_id','=',$user_id],
            ['sta','=',0],
            ['ordersta','=',0],
            ['create_time','>',$time]
        ];
        $res=$this->field('sta,count(sta) as counts')->group('sta')->whereOr([$map1,$map2])->select();
        $old=[0,0,0,0,0,0,0,0];
        $all=0;
        foreach($res as $k=>$v){
            $old[$v['sta']]=$v['counts'];
            $all+=$v['counts'];
        }
        $old[8]=$all;
        return $old;
    }

    /**获取订单需支付费用
     * @param $orid
     * @param $user_id
     *
     * @return array
     */
    public function getOrder($orid,$user_id){
        $res=$this->with('ordermess')->where('orid',$orid)->find()->toArray();
        if($res['sta']!='0'){
            return ['valid'=>0,'msg'=>'订单已支付'];
        }
        $time=strtotime($res['create_time'])+1800;
        if($time<time()||count($res['ordermess'])<1){
            return ['valid'=>0,'msg'=>'订单已过期或不存在'];
        }
        $userdata=Regis::get($user_id);
        $endpay=0;
        $body='';
        foreach($res['ordermess'] as $k=>$v){
            $endpay+=$v['counts']*$v['lprice'];
            if($k>0){
                $body.=','.$v['gname'];
            }else{
                $body.=$v['gname'];
            }
        }
        if($userdata['money']>0&&$res['money']==1){
            if($userdata['money']>$endpay){
                $endpay=0.01;
            }else{
                $endpay-=$userdata['money'];
            }
        }
        return ['valid'=>1,'money'=>$endpay,'order_id'=>$res['order_id'],'time'=>$time-time(),'body'=>$body];
    }
    public function ordermess(){
        return $this->hasMany('Ordermess','orid','orid');
    }

    /**
     * 获取支付成功订单
     * @param $orid
     * @param $user_id
     *
     * @return array
     */
    public function getHadPayOrder($orid,$user_id){
        $res=$this->with('ordermess')->where('sta',1)->where('orid',$orid)->find()->toArray();
        $userdata=Regis::get($user_id);
        $oldprice=0;
        $endpay=0;
        $body='';
        foreach($res['ordermess'] as $k=>$v){
            $endpay+=$v['counts']*$v['lprice'];
            $oldprice+=$v['counts']*$v['lprice'];
            if($k>0){
                $body.=','.$v['gname'];
            }else{
                $body.=$v['gname'];
            }
        }
        $usersuccess=[];
        $getmess=[];
        if($userdata['jifen']>0&&$res['fen']==1){
            $ji_bi=(new Jifen())->find(1);
            $jifen_money=$userdata['jifen']*$ji_bi['jname']/1000;
            if($jifen_money<$endpay){
                $usersuccess['jifen']=0;
                $res['fenvalue']=$jifen_money;
                $payjifen=0;
            }else{
                $res['fenvalue']=$endpay;
                $payjifen=$endpay/($ji_bi['jname']/1000);
                $usersuccess['jifen']=$userdata['jifen']-$payjifen;
            }
            $getmess[]=[
                'user_id'=>$user_id,
                'can_content'=>'购物积分抵扣',
                'can_fen'=>$payjifen,
                'can_sta'=>1
            ];
        }
        if($userdata['money']>0&&$res['money']==1){
            if($userdata['money']>$endpay){
                $usersuccess['money']=$userdata['money']-$endpay;
                $res['moneyvalue']=$endpay;
                $endpay=0;
            }else{
                $endpay-=$userdata['money'];
                $res['moneyvalue']=$userdata['money'];
                $usersuccess['money']=0;
            }
            $getmess[]=[
                'user_id'=>$user_id,
                'can_content'=>'购物余额抵扣',
                'can_money'=>$res['moneyvalue'],
                'can_sta'=>1
            ];
        }
        $res['oldprice']=$oldprice;
        $result=$this->getbeforeFenMoney($orid);
        if($userdata['onebelongto']||$userdata['belongto']){
            $useridbelongto=$userdata['onebelongto']?$userdata['onebelongto']:$userdata['belongto'];
            $userData2=(new Regis())->getUserMessage($useridbelongto);
            $getmess[]=[
                'user_id'=>$userdata['user_id'],
                'can_fen'    =>$result['fen'],
                'can_content'=>'购物反积分',
                'can_orid'   =>$res['orid']
            ];
            $getmess[]=[
                'user_id'    =>$userData2['user_id'],
                'can_money'  =>$result['money'],
                'can_content'=>'用户购物反利',
                'other_id'   =>$userdata['user_id'],
                'can_orid'   =>$res['orid']
            ];
        }
        //改变订单表内容
        $orderEditData=[
            'orid'=>$res['orid'],
            'oldprice'=>$res['oldprice'],
            'moneyvalue'=>$res['moneyvalue'],
            'fenvalue'=>$res['fenvalue']
        ];
        $result2=$this->successstore($orderEditData);
        if(!$result2){
            Log::write($res,'order');
        }
        // 使用积分余额的情况改变
        if(count($usersuccess)>0){
            $usersuccess['user_id']=$user_id;
            $useRes=(new Regis())->store($usersuccess);
            if(!$useRes){
                Log::write($usersuccess,'order');
            }
        }
        // 记录积分余额流水
        if(count($getmess)>0){
            $getsta=(new Getmess())->saveAll($getmess);
            if(!$getsta){
                Log::write($getmess,'order');
            }
        }
        return $res;
    }

    /**
     * 下单后记录返利积分
     * @param $user_id
     * @param $orid
     *
     * @return array
     */
    public function getbeforeFenMoney($orid){
        $data=Db::name('ordermess')->alias('o')
            ->join('level l','o.lid=l.lid')
            ->where('o.orid',$orid)
            ->select();
        $mess=[];
        foreach($data as $k=>$v){
            $mess['fen']=$v['fen']*$v['counts'];
            $mess['money']=$v['getmoney']*$v['counts'];
        }
        return $mess;
    }

    /**
     * 获取退款订单
     * @param $user_id
     * @param $orid
     *
     * @return array
     */
    public function getReOrder($user_id,$orid){
        $res=$this->alias('o')->join('ordermess or','o.orid=or.orid')->join('goodspic g','or.gid=g.gid')->where('o.user_id',$user_id)->where('o.orid',$orid)->select()->toArray();
        $data=[];
        foreach($res as $k=>$v){
            if(isset($data[$v['orid']])){
                if(isset($data[$v['orid']]['_data'][$v['gid']])){
                    $data[$v['orid']]['_data'][$v['gid']]['pic'][]=$v['pic'];
                }else{
                    $data[$v['orid']]['_data'][$v['gid']]=$v;
                    $data[$v['orid']]['_data'][$v['gid']]['pic']=[];
                    $data[$v['orid']]['_data'][$v['gid']]['pic'][]=$v['pic'];
                }
            }else{
                $data[$v['orid']]=$v;
                $data[$v['orid']]['_data'][$v['gid']]=$v;
                $data[$v['orid']]['_data'][$v['gid']]['pic']=[];
                $data[$v['orid']]['_data'][$v['gid']]['pic'][]=$v['pic'];
            }
        }
        $data=current($data);
        return $data;
    }

    /**
     * 获取所有订单
     * @param $user_id
     *
     * @return array
     */
    public function getAll($user_id){
        $time=time()-1800;
        $map1=[
            ['o.user_id','=',$user_id],
            ['o.ordersta','=',0],
            ['o.sta','>',0]
        ];
        $map2=[
            ['o.user_id','=',$user_id],
            ['o.sta','=',0],
            ['o.ordersta','=',0],
            ['o.create_time','>',$time]
        ];
        $res=$this->alias('o')->join('ordermess or','o.orid=or.orid')->join('goodspic g','or.gid=g.gid')->whereOr([$map1,$map2])->order('o.create_time desc')->select()->toArray();
        $data=[];
        foreach($res as $k=>$v){
            if(isset($data[$v['orid']])){
                if(isset($data[$v['orid']]['_data'][$v['gid']])){
                    $data[$v['orid']]['_data'][$v['gid']]['pic'][]=$v['pic'];
                }else{
                    $data[$v['orid']]['_data'][$v['gid']]=$v;
                    $data[$v['orid']]['_data'][$v['gid']]['pic']=[];
                    $data[$v['orid']]['_data'][$v['gid']]['pic'][]=$v['pic'];
                }
            }else{
                $data[$v['orid']]=$v;
                $data[$v['orid']]['_data'][$v['gid']]=$v;
                $data[$v['orid']]['_data'][$v['gid']]['pic']=[];
                $data[$v['orid']]['_data'][$v['gid']]['pic'][]=$v['pic'];
            }
        }
        return $data;
    }

    /**
     * 修改订单状态
     * @param $user_id 用户id
     * @param $orid 订单id
     * @param $sta 状态标识
     *
     * @return bool
     */
    public function staEdit($user_id,$orid,$sta){
        $res=$this->where('user_id',$user_id)->find($orid);
        if(!$res){
            return $res;
        }
        return $this->allowField('sta')->save(['sta'=>$sta],[$this->pk=>$orid]);
    }

    /**
     * 修改订单状态admin
     * @param $user_id 用户id
     * @param $orid 订单id
     * @param $sta 状态标识
     *
     * @return bool
     */
    public function adminStaEdit($orid,$sta){
        return $this->allowField('sta')->save(['sta'=>$sta],[$this->pk=>$orid]);
    }

    /**
     * 修改发货单号admin
     * @param $orid 订单id
     * @param $code 发货单号
     *
     * @return bool
     */
    public function adminCodeEdit($orid,$code){
        return $this->allowField('code,send_time')->save(['code'=>$code,'send_time'=>time()],[$this->pk=>$orid]);
    }

    /**
     * 用户软删除订单
     * @param $user_id
     * @param $orid
     * @param $sta
     *
     * @return array|bool|null|\PDOStatement|string|Model
     */
    public function orderstaEdit($user_id,$orid,$sta){
        $res=$this->where('user_id',$user_id)->find($orid);
        if(!$res){
            return $res;
        }
        return $this->allowField('ordersta')->save(['ordersta'=>$sta],[$this->pk=>$orid]);
    }

    /**
     * 获取该订单可返利积分和钱
     * @param $user_id
     * @param $orid
     *
     * @return array
     */
    public function getFenMoney($user_id,$orid){
        $res=$this->where('user_id',$user_id)->where('orid',$orid)->find();
        if(!$res){return ['valid'=>0,'msg'=>'订单不存在'];}
        $data=Db::name('ordermess')->alias('o')
            ->join('level l','o.lid=l.lid')
            ->where('o.orid',$orid)
            ->select();
        $mess=[];
        foreach($data as $k=>$v){
            $mess['fen']=$v['fen']*$v['counts'];
            $mess['money']=$v['getmoney']*$v['counts'];
        }
        return $mess;
    }
}