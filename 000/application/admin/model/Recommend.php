<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/1/3
 * Time : 10:08
 * Email: 417780879@qq.com
 */
namespace app\admin\model;
use app\common\model\Common;

class Recommend extends Common
{
    protected $table='recommend';
    protected $pk='rid';
    protected $sort='rsort';
    public function belongsTo($model,$foreignKey = '',$localKey = '')
    {
        return $this->belongsTo('Goods');
    }
}