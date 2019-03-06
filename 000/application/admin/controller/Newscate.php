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

class Newscate extends Common
{
    protected $urltwo;
    public function initialize()
    {
        parent ::initialize();
        $this->model=new \app\admin\model\Newscate();
        $this->url=url('admin/newscate/index');
    }

    public function index(){
        $newscateData=$this->model->order('csort desc')->select()->toArray();
        $this->assign('newscateData',$newscateData);
        return view();
    }


    public function add(Request $request){
        if($request->isPost()){
            $data=$request->param();
            $this->return_res($this->model->store($data),$this->url);
        }
        return view();
    }

    public function edit(Request $request){
        $oldData=$this->model->get($request->param('cid'));
        if($request->isPost()){
            $data=$request->param();
            $this->return_res($this->model->store($data),$this->url);
        }
        $this->assign('oldData',$oldData);
        return view();
    }

    public function del(Request $request){
        if($request->isGet()){
            $id=$request->param('id');
            $num=$this->model->destroy($id);
            $this->delmess($num,$this->url);
        }
    }

    public function ajaxEditSort(Request $request)
    {
        if($request->isAjax()){
            $data=$request->param();
            return $this ->model -> editsort($data);
        }
    }
}