<?php
namespace app\admin\model;
use app\common\model\Common;

class Level extends Common
{
    protected $table='level';
    protected $pk='lid';
    protected $sort='lsort';
    public function goods(){
        return $this->belongsTo('Goods');
    }
}