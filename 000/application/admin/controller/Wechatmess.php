<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/1/3
 * Time : 10:03
 * Email: 417780879@qq.com
 */
namespace app\admin\controller;
use app\common\controller\Common;
use think\Request;

class Wechatmess extends Common
{
    protected $urltwo;
    public function initialize()
    {
        parent ::initialize();
        $this->model=new \app\admin\model\Wechatmess();
        $this->url=url('admin/wechatmess/index');
    }

    public function index(){
        $messData=$this->model->select()->toArray();
        $this->assign('messData',$messData);
        return view();
    }

    public function addwechatmess(Request $request){
        if($request->isPost()){
            $data=$request->param();
            $this->return_res($this->model->store($data),$this->url);
        }
        return view();
    }


    public function editwechatmess(Request $request){
        $oldData=$this->model->get($request->param('id'))->toArray();
        if($request->isPost()){
            $data=$request->param();
            $this->return_res($this->model->store($data),$this->url);
        }
        $this->assign('oldData',$oldData);
        return view();
    }

    public function delwechatmess(Request $request){
        if($request->isGet()){
            $id=$request->param('id');
            $num=$this->model->destroy($id);
            $this->return_del($num,$this->url);
        }
    }

}