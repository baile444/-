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

class Goodspic extends Common
{
    protected $table='goodspic';
    protected $pk='bid';
    protected $sort='bsort';
    public function goods(){
        return $this->belongsTo('Goods');
    }
}