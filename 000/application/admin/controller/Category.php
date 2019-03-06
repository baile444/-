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
use app\common\Predis;
use think\Request;

class Category extends Common
{
    protected $urltwo;
    public function initialize()
    {
        parent ::initialize();
        $this->model=new \app\admin\model\Category();
        $this->modelTwo=new \app\admin\model\Logos();
        $this->url=url('admin/category/index');
        $this->urltwo=url('admin/category/pic');
    }

    public function index(){
        $categoryData=$this->model->order('sort desc')->select()->toArray();
        $this->assign('categoryData',$categoryData);
        return view();
    }


    public function addindex(Request $request){
        if($request->isPost()){
            $data=$request->param();
            Predis::getInstance()->del('api_category');
            $data['cpic']=$data['pic'];
            $this->return_res($this->model->store($data),$this->url);
        }
        return view();
    }

    public function editindex(Request $request){
        $oldData=$this->model->get($request->param('cid'));
        if($request->isPost()){
            Predis::getInstance()->del('api_category');
            $data=$request->param();
            $data['cpic']=isset($data['pic'])?$data['pic']:$oldData['cpic'];
            $this->return_res($this->model->store($data),$this->url);
        }
        $this->assign('oldData',$oldData);
        return view();
    }

    public function delcategory(Request $request){
        if($request->isGet()){
            Predis::getInstance()->del('api_category');
            $id=$request->param('id');
            $num=$this->model->destroy($id);
            $this->return_del($num,$this->url);
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