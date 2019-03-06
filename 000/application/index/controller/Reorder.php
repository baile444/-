<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/20
 * Time : 11:29
 * Email: 417780879@qq.com
 */
namespace app\index\controller;
use app\admin\model\Jifen;
use app\common\controller\Base;
use app\common\Predis;
use think\Request;

class Reorder extends Base
{
    protected $middleware = ['Hearders'];

    public function addreorder(Request $request){}
}