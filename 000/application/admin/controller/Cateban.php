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

class Cateban extends Common
{
    public function initialize()
    {
        parent ::initialize();
        $this->model=new \app\admin\model\Cateban();
        $this->url=url('admin/cateban/index');
    }

    public function index(Request $request)
    {
        $cid=$request->param('cid');
        $banaerData=$this->model->where('cid',$cid)->order('sort desc')->select()->toArray();
        $this->assign('bannerData',$banaerData);
        return view();
    }

    public function addbanner(Request $request)
    {
        if($request->isPost()){
            $data=$request->param();
            $url=url('admin/cateban/index',['cid'=>$data['cid']]);
            $this->return_res($this->model->store($data),$url);
        }
        return view();
    }

    public function editbanner(Request $request)
    {
        $id=$request->param('baid');
        $oldData=\app\admin\model\Cateban::get($id);
        if($request->isPost()){
            $data=$request->param();
            $url=url('admin/cateban/index',['cid'=>$data['cid']]);
            $this->return_res($this->model->store($data),$url);
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
            $data=$this->model->get($id);
            $num=$this->model->destroy($id);
            $url=url('admin/cateban/index',['cid'=>$data['cid']]);
            $this->return_del($num,$url);
        }
    }
}