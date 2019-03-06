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

class Messages extends Model
{
    protected $table='messages';
    protected $pk='id';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    public function store($data){
        return $this->allowField(true)->save($data);
    }
    public function del($aid){
        return $this->where($this->pk,$aid)->delete();
    }
}