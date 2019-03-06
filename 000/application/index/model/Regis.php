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

class Regis extends Model
{
    protected $table='user';
    protected $pk='user_id';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;
    public function regis($data){
        return $this->allowField(true)->save($data);
    }
    public function editMess($data){
        return $this->allowField(true)->save($data,[$this->pk=>$data[$this->pk]]);
    }
    public function getUserMessage($user_id){
        return $this->where('user_id',$user_id)->field('user_id,jifen,money,belongto,onebelongto,lv,apayname,apay,wechat')->find();
    }
    public function store($data){
        return $this->allowField('money,jifen')->save($data,[$this->pk=>$data[$this->pk]]);
    }
    public function editall($data){
        return $this->saveAll($data);
    }

    public function editname($data){
        return $this->allowField('user_name,apayname,apay')->save($data,[$this->pk=>$data[$this->pk]]);
    }

    public function editpassword($data){
        return $this->allowField('password')->save($data,[$this->pk=>$data[$this->pk]]);
    }

    public function editwechat($data){
        return $this->allowField('wechat')->save($data,[$this->pk=>$data[$this->pk]]);
    }

    /**
     * 推广用户，已购买用户
     * @param $user_id
     *
     * @return float|string
     */
    public function getCounts($user_id){
        $allcounts=$this->where('pid',$user_id)->count();
        $hadcounts=$this->where('pid',$user_id)->where('onebelongto',0)->count();
        $res=[
            'allcounts'=>$allcounts,
            'hadcounts'=>$hadcounts
        ];
        return $res;
    }
}