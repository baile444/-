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

class Messages extends Base
{
    public function index(Request $request){}

    public function addmess(Request $request,\app\validate\Messages $messages,\app\index\model\Messages $messagesmodel){
        $data=$request->param();
        $messages->goCheck($data);
        $res=$messagesmodel::create($data);
        return $res;
    }
}