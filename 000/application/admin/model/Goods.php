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

class Goods extends Common
{
    protected $table='goods';
    protected $pk='gid';
    protected $sort='gsort';
    protected $autoWriteTimestamp = true;
    public function level(){
        return $this->hasMany('Level','gid');
    }
    public function goodspic(){
        return $this->hasMany('Goodspic','gid');
    }
    public function recommend(){
        return $this->hasOne('Recommend','gid');
    }
    public function cate(){
        return $this->belongsTo('Cate','cid');
    }
}