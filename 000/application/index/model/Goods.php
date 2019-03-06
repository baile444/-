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

class Goods extends Model
{
    protected $table='goods';
    protected $pk='gid';
    public function shopping(){
        return $this->hasMany('Shopping','gid');
    }
}