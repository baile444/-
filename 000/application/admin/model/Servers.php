<?php
namespace app\admin\model;
use app\common\model\Common;

class Servers extends Common
{
    protected $table='servers';
    protected $pk='id';
    protected $sort='sort';
}