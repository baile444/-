<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/7/18
 * Time : 15:04
 * Email: 417780879@qq.com
 */
namespace app\index\model;
use think\Model;

class Getmess extends Model
{
    protected $table='getmess';
    protected $pk='can_id';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    protected $pagenum = 7;
    /**
     * 积分 返利流水
     * @param $data
     *
     * @return \think\Collection
     */
    public function addall($data){
        return $this->saveAll($data);
    }

    public function add($data){
        return $this->save($data);
    }

    public function editsta($can_id){
        return $this->allowField('can_sta')->save(['can_sta'=>1],[$this->pk=>$can_id]);
    }

    /**
     * 获取用户返利流水
     * @param $user_id
     *
     * @return array
     */
    public function getjifenmess($user_id){
//        $res=$this->with('regis')->where('user_id',$user_id)->where('can_money','>','0')->select();
        $res=$this->alias('g')
            ->join('user r','g.other_id=r.user_id')
            ->where('g.user_id',$user_id)
            ->where('g.can_money','>',0)
            ->order('g.create_time desc')
            ->field('g.can_id,g.can_content,g.can_fen,g.can_money,g.create_time,r.phone,g.can_sta')
            ->select();
        foreach($res as $k=>$v){
            $res[$k]['phone']=substr($v['phone'],0,3).'****'.substr($v['phone'],-4);
        }
        return $res;
    }

    /**
     * 获取用户返利流水pc分页
     * @param $user_id
     *
     * @return array
     */
    public function getjifenmesspage($user_id,$page){
        //        $res=$this->with('regis')->where('user_id',$user_id)->where('can_money','>','0')->select();
        $res=$this->alias('g')
            ->join('user r','g.other_id=r.user_id')
            ->where('g.user_id',$user_id)
            ->where('g.can_money','>',0)
            ->order('g.create_time desc')
            ->field('g.can_id,g.can_content,g.can_fen,g.can_money,g.create_time,r.phone,g.can_sta')
            ->page($page,10)
            ->select();
        foreach($res as $k=>$v){
            $res[$k]['phone']=substr($v['phone'],0,3).'****'.substr($v['phone'],-4);
        }
        $counts=$this->where('user_id',$user_id)->where('can_money','>',0)->where('other_id','>',1)->count();
        $counts=ceil($counts/10);
        $data=[
            'counts'=>$counts,
            'data'=>$res
        ];
        return $data;
    }

    /**
     * 余额流水
     * @param $user_id
     *
     * @return array|\PDOStatement|string|\think\Collection
     */
    public function getmoneymess($user_id){
        $res=$this->alias('g')
            ->join('user r','g.user_id=r.user_id')
            ->where('g.user_id',$user_id)
            ->where('g.can_money>0 or g.can_money<0')
            ->order('g.create_time desc')
            ->field('g.can_id,g.can_content,g.can_fen,g.can_money,g.create_time,r.phone,g.can_sta')
            ->select();
        foreach($res as $k=>$v){
            $res[$k]['phone']=substr($v['phone'],0,3).'****'.substr($v['phone'],-4);
        }
        return $res;
    }

    /**
     * 积分流水
     * @param $user_id
     *
     * @return array
     */
    public function getjifen($user_id){
        return $this->where('user_id',$user_id)->where('can_fen','>','0.01')->whereOr('can_fen','<',0)->order('create_time desc')->select()->toArray();
    }

    /**
     * 积分流水pc分页
     * @param $user_id
     *
     * @return array
     */
    public function getjifenpage($user_id,$data){
        if($data['can_sta'] == 0) {
            $res = $this->where('user_id',$user_id)->where('can_fen','>',-9999999)->order('create_time desc')->page($data['page'],$this->pagenum)->select()->toArray();
            $oldcounts=$this->where('user_id',$user_id)->where('can_fen','>','-9999999')->count();
            $counts=ceil($oldcounts/$this->pagenum);
        } elseif ($data['can_sta'] == 1) {
            $res = $this->where('user_id',$user_id)->where('can_fen','>',0)->order('create_time desc')->page($data['page'],$this->pagenum)->select()->toArray();
            $oldcounts=$this->where('user_id',$user_id)->where('can_fen','>',0)->count();
            $counts=ceil($oldcounts/$this->pagenum);
        } else{
            $res = $this->where('user_id',$user_id)->where('can_fen','<',0)->order('create_time desc')->page($data['page'],$this->pagenum)->select()->toArray();
            $oldcounts=$this->where('user_id',$user_id)->where('can_fen','<',0)->count();
            $counts=ceil($oldcounts/$this->pagenum);
        }
        $result=[
            'counts'=>$counts,
            'data'=>$res
        ];
        return $result;
    }

    /**
     * 积分余额pc分页
     * @param $user_id
     *
     * @return array
     */
    public function getmoneypage($user_id,$data){
        if($data['can_sta'] == 0) {
            $res = $this->where('user_id',$user_id)->where('can_money',['>', 0],['<', 0],'or')->order('create_time desc')->page($data['page'],$this->pagenum)->select()->toArray();
            $oldcounts=$this->where('user_id',$user_id)->where('can_money','>','-9999999')->count();
            $counts=ceil($oldcounts/$this->pagenum);
        } elseif ($data['can_sta'] == 1) {
            $res = $this->where('user_id',$user_id)->where('can_money','>',0)->order('create_time desc')->page($data['page'],$this->pagenum)->select()->toArray();
            $oldcounts=$this->where('user_id',$user_id)->where('can_money','>',0)->count();
            $counts=ceil($oldcounts/$this->pagenum);
        } else{
            $res = $this->where('user_id',$user_id)->where('can_money','<',0)->order('create_time desc')->page($data['page'],$this->pagenum)->select()->toArray();
            $oldcounts=$this->where('user_id',$user_id)->where('can_money','<',0)->count();
            $counts=ceil($oldcounts/$this->pagenum);
        }
        $result=[
            'old'=>$oldcounts,
            'counts'=>$counts,
            'data'=>$res
        ];
        return $result;
    }

    public function order(){
        return $this->belongsTo('Order','can_orid');
    }

    public function regis(){
        return $this->hasOne('Regis','user_id','user_id')->bind('phone');
    }
}