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

class Cate extends Common
{
    public function initialize()
    {
        parent ::initialize();
        $this->model=new \app\admin\model\Cate();
        $this->modelTwo=new \app\admin\model\Recommend();
        $this->url=url('admin/cate/index');
    }

    public function index(){
        $cateData=$this->model->order('csort desc,cid')->select();
        $this->assign('cateData',$cateData);
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

    public function recommend(Request $request){
        $cid=$request->param('cid');
        $reData=$this->modelTwo->where('typecid',$cid)->order('rsort')->select();
        $this->assign('reData',$reData);
        return view();
    }

    public function addrecommend(Request $request){
        $cid=$request->param('cid');
        if($request->isPost()){
            $data=$request->param();
            $data['typecid']=$cid;
            $urls=url('admin/cate/recommend',['cid'=>$cid]);
            $this->return_res($this->modelTwo->store($data),$urls);
        }
        return view();
    }

    public function editrecommend(Request $request){
        $data=$request->param();
        $oldData=$this->modelTwo->get($data['rid']);
        if($request->isPost()){
            $res=$request->param();
            $res['typecid']=$data['cid'];
            $urls=url('admin/cate/recommend',['cid'=>$data['cid']]);
            $this->return_res($this->modelTwo->store($data),$urls);
        }
        $this->assign('oldData',$oldData);
        return view();
    }

    public function delrecommend(Request $request){
        $data=$request->param();
        $num=$this->modelTwo->destroy($data['id']);
        $urls=url('admin/cate/recommend',['cid'=>$data['cid']]);
        $this->delmess($num,$urls);
    }

    public function ajaxReEditSort(Request $request){
        if($request->isAjax()){
            $data=$request->param();
            return $this ->modelTwo -> editsort($data);
        }
    }
}