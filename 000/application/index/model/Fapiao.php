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

class Fapiao extends Model
{
    protected $table='fapiao';
    protected $pk='fpid';

    public function add($data){
        return $this->allowField(true)->save($data);
    }
    public function edit($data){
        return $this->allowField(true)->save($data,[$this->pk=>$data[$this->pk]]);
    }
}