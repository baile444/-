<?php
namespace app\admin\model;
use app\common\model\Common;

class Newscate extends Common
{
    protected $table='newscate';
    protected $pk='cid';
    protected $sort='csort';
}