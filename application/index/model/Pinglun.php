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

class Pinglun extends Model
{
    protected $table='pinglun';
    protected $pk='ping_id';
    public function add($data){
        return $this->allowField(true)->save($data);
    }
    public function getping($gid){
        return $this->with('regis')->where('gid',$gid)->order('ping_id desc')->limit(3)->select()->toArray();
    }
    public function getallping($gid){
        return $this->with('regis')->where('gid',$gid)->order('ping_id desc')->select()->toArray();
    }
    public function regis(){
        return $this->hasOne('Regis','user_id','user_id')->bind('user_img,user_name');
    }
}