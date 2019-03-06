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

class Jifen extends Common
{
    protected $table='jifen';
    protected $pk='jid';

    /**
     * 1元积分比例
     * @return float|int
     */
    public function getBili(){
        $res=$this->find(1)->toArray();
        $bi=1000/$res['jname'];
        return $bi;
    }
}