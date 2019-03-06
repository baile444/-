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

class Smess extends Common
{
    protected $table='smess';
    protected $pk='smid';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;
}