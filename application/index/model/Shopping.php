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

class Shopping extends Model
{
    protected $table='shopping';
    protected $pk='spid';
    protected $readonly = ['user_id','gid'];

    /**添加购物车
     * @param $data
     *
     * @return bool
     */
    public function add($data){
        $res=$this->where('gid',$data['gid'])->where('lid',$data['lid'])->where('user_id',$data['user_id'])->select()->toArray();
        if(count($res)<1){
            $this->allowField(true)->save($data);
            return $this->spid;
        }else{
            $res=$res[0];
            $res['counts']=$res['counts']+$data['counts'];
            $this->edit($res);
            return $res['spid'];
        }
    }

    /**
     * 删除购物车
     * @param $user_id
     * @param $spid
     *
     * @return bool
     */
    public function delcart($user_id,$spid){
        return $this->where('user_id',$user_id)->where('spid',$spid)->delete();
    }

    /**
     * 清空购物车
     * @param $user_id
     *
     * @return bool
     */
    public function delallcart($user_id){
        return $this->where('user_id',$user_id)->delete();
    }
    public function edit($data){
        return $this->allowField(true)->save($data,[$this->pk=>$data[$this->pk]]);
    }
    public function del($spid){
        return $this->where($this->pk,'in',$spid)->delete();
    }
    //返回所有购物车商品
    public function resources($userid){
        $res=$this->with('goods,level,goodspic')->where('user_id',$userid)->order('spid desc')->select();
        $data=[];
        foreach($res as $k=>$v){
            if($v['gname']&&$v['lprice']&&count($v['goodspic'])>0&&$v['gsta']==1){
                $data[]=$v;
            }
        }
        return $data;
    }
    //预订单商品
    public function resorder($userid,$spid){
        $res=$this->with('goods,level,goodspic')->where('user_id',$userid)->where('spid','in',$spid)->order('spid desc')->select();
        $data=[];
        foreach($res as $k=>$v){
            if($v['gsta']==1){
                $data[]=$v;
            }
        }
        return $data;
    }
    public function toorder($userid,$spid){
        return $this->with('goods,level')->where('user_id',$userid)->where('spid','in',$spid)->order('spid desc')->select()->toArray();
    }
    //修改购物车
    public function editall($data){
        return $this->saveAll($data);
    }
    public function goods(){
        return $this->hasOne('Goods','gid','gid')->bind('gname,ed,gsta');
    }
    public function level(){
        return $this->hasOne('app\admin\model\Level','lid','lid')->bind('lname,lprice,inventory,fen');
    }
    public function goodspic(){
        return $this->hasMany('app\admin\model\Goodspic','gid','gid');
    }
}