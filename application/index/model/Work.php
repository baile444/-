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

class Work extends Model
{
    protected $table='res_work';
    protected $pk='id';
    public function store($data){
        $this->allowField(true)->save($data);
        return $this->id;
    }
    public function editMess($data){
        return $this->allowField(true)->save($data,[$this->pk=>$data[$this->pk]]);
    }
}