<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/20
 * Time : 11:29
 * Email: 417780879@qq.com
 */
namespace app\index\controller;
use app\admin\model\Jifen;
use app\common\controller\Base;
use app\common\Ordercode;
use app\common\Predis;
use app\common\snowFlake\Idcreate;
use app\index\model\Getmess;
use app\index\model\Ordermess;
use app\wechat\controller\Wxpay;
use think\Db;
use think\Request;

class Order extends Base
{
    protected $middleware = ['Hearders'];

    /**
     * 订单详情
     * @param Request                $request
     * @param \app\index\model\Order $orders
     *
     * @return \think\response\Json
     */
    public function ordermessage(Request $request,\app\index\model\Order $orders){
        $orid=$request->param('orid');
        $data=$orders->alias('o')
            ->join('addresss a','o.aid=a.aid')
            ->where('o.orid',$orid)
            ->find();
        $data['send_time']=date("Y-m-d H:i:m",$data['send_time']);
        $data['address_before']=json_decode($data['address_before'],256);
        $data['address_before']=$data['address_before']['province'].$data['address_before']['city'].$data['address_before']['area'];
        return json($data);
    }

    /**
     * pc付款二维码
     * @param Request                $request
     * @param \app\index\model\Order $orders
     * @param Wxpay                  $wxpay
     *
     * @return \think\response\Json
     */
    public function pcpaycode(Request $request,\app\index\model\Order $orders,Wxpay $wxpay){
        $orid=$request->param('orid');
//        $res=$orders->orderMessage(self::UserMess()['user_id'],$orid);
        $res=$orders->getOrder($orid,self::UserMess()['user_id']);
        if($res['valid']==0){
            return json(['valid'=>'0','msg'=>'订单不存在或已支付']);
        }
        Predis::getInstance()->set($res['order_id'], json_encode($res,256));
        Predis::getInstance()->expire($res['order_id'],1800);
        $codeurl=$wxpay->pcQrCodeUrl($res);
        $res['codeurl']=$codeurl;
        $res['valid']=1;
        return json($res);
    }

    /**
     * 是否付款请求状态api
     * @param Request                $request
     * @param \app\index\model\Order $orders
     * @param Wxpay                  $wxpay
     *
     * @return \think\response\Json
     */
    public function pcHadPay(Request $request,\app\index\model\Order $orders,Wxpay $wxpay){
        $orid=$request->param('orid');
        $res=$orders->orderMessage(self::UserMess()['user_id'],$orid);
        if(!$res){
            return json(['valid'=>'0']);
        }
        if($res['sta']==0){
            return json(['valid'=>'0']);
        }
        return json(['valid'=>'1']);
    }

    /**
     * pc付款成功后查看订单
     * @param Request                $request
     * @param \app\validate\Order    $valiorder
     * @param \app\index\model\Order $orders
     *
     * @return \think\response\Json
     */
    public function ordersuccess(Request $request,\app\validate\Order $valiorder,\app\index\model\Order $orders){
        $orid=$request->param('orid');
        $res=$orders->orderMessage(self::UserMess()['user_id'],$orid);
        if(!$res){
            return json(['valid'=>'0']);
        }
        if($res['sta']==1){
            $res['valid']=1;
            $phone=\app\admin\model\Logos::where('id',1)->value('message');
            (new Ordercode())->getCode($phone);
            return json($res);
        }
        return json(['valid'=>'0']);
    }

    /**提交预订单
     * @param Request                   $request
     * @param \app\validate\Order       $vorder
     * @param \app\index\model\Shopping $shopping
     *
     * @return array|\PDOStatement|string|\think\Collection
     */
    public function beforeorder(Request $request,\app\validate\Order $vorder,\app\index\model\Shopping $shopping){
        $data=$request->param();
        if(gettype($data['spid'])== 'string'){
            $data['spid']=[$data['spid']];
        }
        $vorder->goCheck($data,'beforeorder');
        return json($shopping->resorder(self::UserMess()['user_id'],$data['spid']));
    }

    /**获取积分余额
     * @param \app\index\model\Regis $model
     *
     * @return \think\response\Json
     */
    public function getjifen(\app\index\model\Regis $model,Jifen $jifen){
        $data = $model->getUserMessage(self::UserMess()['user_id']);
        $ji_bi=$jifen->find(1);
        $data['oldjifen']=$data['jifen'];
        $data['jifenbi']=$ji_bi['jname']/1000;
        $data['jifen']=$data['jifen']*$ji_bi['jname']/1000;
        return json($data);
    }

    /**正式提交订单
     * @param Request                   $request
     * @param \app\index\model\Shopping $shopping
     * @param \app\index\model\Order    $orders
     * @param Ordermess                 $ordermessmodel
     *
     * @return int|mixed
     */
    public function suborder(Request $request,\app\index\model\Shopping $shopping,\app\index\model\Order $orders,Ordermess $ordermessmodel){
        $data=$request->param();
        $mess=$shopping->toorder(self::UserMess()['user_id'],$data['spid']);
        $orderid=date('Ymd',time()).Idcreate::createOnlyId();
        $ord=[
            'order_id' =>$orderid,
            'user_id'  =>self::UserMess()['user_id'],
            'aid'      =>$data['aid'],
            'fen'      =>$data['fen']=='true'?1:0,
            'money'      =>$data['money']=='true'?1:0,
        ];
        Db::startTrans();
        try {
            $res=$orders->store($ord);
            $ordermess=[];
            foreach($mess as $k=>$v){
                $v['orid']=$res;
                $ordermess[]=$v;
            }
            $ordermessmodel->store($ordermess);
            $shopping->del($data['spid']);
            // 提交事务
            Db::commit();
            return $res;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return 0;
        }
    }

    /**获取支付订单
     * @param Request                $request
     * @param \app\index\model\Order $orders
     * @param \app\validate\Order    $valiorder
     *
     * @return \think\response\Json
     */
    public function ordermoney(Request $request,\app\index\model\Order $orders,\app\validate\Order $valiorder,Wxpay $wxpay){
        $data=$request->param();
        $valiorder->goCheck($data,'payorder');
        $oriddata=$orders->getOrder($data['orid'],self::UserMess()['user_id']);
        if($oriddata['valid']!=1){
            return json($oriddata);
        }
        $openid=Predis::getInstance()->get('openid'.$data['orid']);
        $res=$wxpay->payforwechat($openid,$oriddata['order_id'],$oriddata['money'],$oriddata['body']);
        $websign=$wxpay->getwebsing($res);
        $oriddata=array_merge($oriddata,$res,['websign'=>$websign]);
        return json($oriddata);
    }

    /**获取网页静默授权openid
     * @param Request $request
     * @param Wxpay   $wxpay
     *
     * @return \think\response\Json
     */
    public function getopenid(Request $request,Wxpay $wxpay){
        $data=$request->param();
        return $wxpay->payopenid($data);
    }

    /**
     * 付款成功回调详情
     * @param Request                $request
     * @param \app\validate\Order    $valiorder
     * @param \app\index\model\Order $orders
     *
     * @return \think\response\Json
     */
    public function hadsuccess(Request $request,\app\validate\Order $valiorder,\app\index\model\Order $orders){
        $data=$request->param();
        $valiorder->goCheck($data,'payorder');
        $res=$orders->getHadPayOrder($data['orid'],self::UserMess()['user_id']);
        $phone=\app\admin\model\Logos::where('id',1)->value('message');
        (new Ordercode())->getCode($phone);
        return json($res);
    }

    /**
     * 订单分类统计
     * @param Request                $request
     * @param \app\index\model\Order $orders
     *
     * @return \think\response\Json
     */
    public function ordercounts(Request $request,\app\index\model\Order $orders){
        $res=$orders->ordercounts(self::UserMess()['user_id']);
        return json($res);
    }

    /**
     * 获取所有有效订单
     * @param Request                $request 分类订单sta标识
     * @param \app\index\model\Order $orders
     *
     * @return \think\response\Json
     */
    public function allorder(Request $request,\app\index\model\Order $orders){
        $res=$orders->getAll(self::UserMess()['user_id']);
        $sta=$request->param('sta');
        if(!is_numeric($sta)){
            $data=[];
            foreach($res as $k=>$v){
                $data[]=$v;
            }
            return json($data);
        }
        if($sta>-1){
            $data=[];
            foreach($res as $k=>$v){
                if($v['sta'] == $sta){
                    $data[]=$v;
                }
            }
            return json($data);
        }
    }

    /**
     * 确认收货,得积分，返利
     * @param Request                $request
     * @param \app\index\model\Order $orders
     *
     * @return mixed
     */
    public function truegoods(Request $request,\app\index\model\Order $orders,\app\index\model\Regis $regis,Getmess $getmess){
        $orid=$request->param('orid');
        if($orid<1){
            return 0;
        }
        $userid=$regis->getUserMessage(self::UserMess()['user_id']);
        $result=$orders->getFenMoney(self::UserMess()['user_id'],$orid);
        if($userid['onebelongto']||$userid['belongto']){
            $useridbelongto=$userid['onebelongto']?$userid['onebelongto']:$userid['belongto'];
            $userData2=$regis->getUserMessage($useridbelongto);
            $data1=[
                'user_id'    =>self::UserMess()['user_id'],
                'jifen'      =>$userid['jifen']+$result['fen'],
                'onebelongto'=>0
            ];
            $data2=[
                'user_id'=> $userData2['user_id'],
                'money'  => $userData2['money']+$result['money']
            ];
            $regis->editall([$data1,$data2]);
        }else{
            $data1=[
                'user_id'=>self::UserMess()['user_id'],
                'jifen'    =>$userid['jifen']+$result['fen'],
                'onebelongto'=>0
            ];
            $regis->editall([$data1]);
        }
        Db::name('getmess')->where('can_orid',$orid)->data(['can_sta'=>1])->update();
        $res=$orders->staEdit(self::UserMess()['user_id'],$orid,3);
        if(!$res){
            return 0;
        }
        return 1;
    }

    /**
     * 用户删除订单
     * @param Request                $request
     * @param \app\index\model\Order $orders
     *
     * @return mixed
     */
    public function delorder(Request $request,\app\index\model\Order $orders){
        $orid=$request->param('orid');
        if($orid<1){
            return 0;
        }
        $res=$orders->orderstaEdit(self::UserMess()['user_id'],$orid,1);
        if(!$res){
            return 0;
        }
        return 1;
    }

    /**
     * 获取要退款的订单
     * @param Request                $request
     * @param \app\index\model\Order $orders
     *
     * @return \think\response\Json
     */
    public function getreorder(Request $request,\app\index\model\Order $orders){
        $orid=$request->param('orid');
        $res=$orders->getReOrder(self::UserMess()['user_id'],$orid);
        return json($res);
    }

    /**
     * 提交退款理由，修改订单状态
     * @param Request                  $request
     * @param \app\validate\Reorder    $valid
     * @param \app\index\model\Reorder $reorder
     * @param \app\index\model\Order   $order
     *
     * @return \think\response\Json
     */
    public function addreorder(Request $request,\app\validate\Reorder $valid,\app\index\model\Reorder $reorder,\app\index\model\Order $order){
        $data=$request->param();
        $valid->goCheck($data);
        $data['user_id']=self::UserMess()['user_id'];
        Db::startTrans();
        try {
            $reorder->add($data);
            $order->staEdit(self::UserMess()['user_id'],$data['orid'],4);
            // 提交事务
            Db::commit();
            return json(['valid'=>1,'msg'=>'提交成功']);
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return json(['valid'=>0,'msg'=>'提交失败']);
        }
    }
}