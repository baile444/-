<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/2/2
 * Time : 13:43
 * Email: 417780879@qq.com
 */
namespace app\admin\controller;
use app\common\controller\Common;
use think\Request;

class Jifen extends Common
{
    public function initialize()
    {
        parent ::initialize();
        $this->model=new \app\admin\model\Jifen();
        $this->url=url('admin/jifen/index');
    }

    public function index(Request $request)
    {
        $oldData=$this->model->get(1);
        if($request->isPost()){
            $data=$request->param();
            $data['jid']=1;
            $this->return_res($this->model->store($data),$this->url);
        }
        $this->assign('oldData',$oldData);
        return view();
    }
}