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

class Ordermess extends Model
{
    protected $table='ordermess';
    protected $pk='oid';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;
    public function store($data){
        return $this->allowField(true)->saveAll($data);
    }
}