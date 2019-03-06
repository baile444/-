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

class Firendship extends Common
{
    protected $urltwo;
    public function initialize()
    {
        parent ::initialize();
        $this->model=new \app\admin\model\Firendship();
        $this->url=url('admin/firendship/index');
    }

    public function index(){
        $categoryData=$this->model->order('sort desc')->select()->toArray();
        $this->assign('categoryData',$categoryData);
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
        $oldData=$this->model->get($request->param('id'));
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
            $data=$this->model->get($id);
            $num=$this->model->destroy($id);
            unlink(APP_PATH.'/uploads/'.$data['pic']);
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