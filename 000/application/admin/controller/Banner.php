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

class Banner extends Common
{
    public function initialize()
    {
        parent ::initialize();
        $this->model=new \app\admin\model\Banner();
        $this->url=url('admin/banner/index');
    }

    public function index()
    {
        $banaerData=$this->model->order('sort desc')->select()->toArray();
        $this->assign('bannerData',$banaerData);
        return view();
    }

    public function addbanner(Request $request)
    {
        if($request->isPost()){
            $data=$request->param();
            $this->return_res($this->model->store($data),$this->url);
        }
        return view();
    }

    public function editbanner(Request $request)
    {
        $id=$request->param('id');
        $oldData=\app\admin\model\Banner::get($id);
        if($request->isPost()){
            $data=$request->param();
            $this->return_res($this->model->store($data),$this->url);
        }
        $this->assign('oldData',$oldData);
        return view();
    }

    public function ajaxEditSort(Request $request)
    {
        if($request->isAjax()){
            return $this ->model -> editsort($request -> param());
        }
    }

    public function delbanner(Request $request)
    {
        if($request->isGet()){
            $id=$request->param('id');
            $num=$this->model->destroy($id);
            $this->return_del($num,$this->url);
        }
    }
}