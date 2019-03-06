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
use think\Db;
use think\Request;

class Shops extends Common
{
    protected $urltwo;
    protected $modelthree;
    public function initialize()
    {
        parent ::initialize();
        $this->model=new \app\admin\model\Shops();
        $this->modelTwo=new \app\admin\model\Category();
        $this->modelthree=new \app\admin\model\Works();
        $this->url=url('admin/shops/index');
    }

    public function index(){
//        $shopsData=$this->model->order('ssort desc')->select()->toArray();
        $shopsData=Db::name('shops')->alias('s')
            ->join('category c','s.cid=c.cid')
            ->select();
        $this->assign('shopsData',$shopsData);
        return view();
    }


    public function add(Request $request){
        $cateData=$this->modelTwo->select();
        if($request->isPost()){
            $data=$request->param();
            $data['spic']=$data['npic'];
            $this->return_res($this->model->store($data),$this->url);
        }
        $this->assign('cateData',$cateData);
        return view();
    }

    public function edit(Request $request){
        $oldData=$this->model->get($request->param('sid'));
        $cateData=$this->modelTwo->select();
        if($request->isPost()){
            $data=$request->param();
            $data['spic']=isset($data['npic'])?$data['npic']:$oldData['spic'];
            $this->return_res($this->model->store($data),$this->url);
        }
        $this->assign('cateData',$cateData);
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

    public function ajaxEditSorts(Request $request)
    {
        if($request->isAjax()){
            $data=$request->param();
            return $this ->modelthree -> editsort($data);
        }
    }

    public function work(Request $request){
        $sid=$request->param('sid');
        $workData=$this->modelthree->where('sid',$sid)->order('wsort desc')->select();
        $this->assign('sid',$sid);
        $this->assign('workData',$workData);
        return view();
    }

    public function addwork(Request $request){
        $sid=$request->param('sid');
        $url=url('admin/shops/work',['sid'=>$sid]);
        if($request->isPost()){
            $data=$request->param();
            $data['wpic']=isset($data['pic'])?$data['pic']:'';
            $this->return_res($this->modelthree->store($data),$url);
        }
        $this->assign('sid',$sid);
        return view();
    }

    public function editwork(Request $request){
        $data=$request->param();
        $url=url('admin/shops/work',['sid'=>$data['sid']]);
        $oldData=$this->modelthree->get($data['wid']);
        if($request->isPost()){
            $data=$request->param();
            $data['wpic']=isset($data['pic'])?$data['pic']:$data['wpic'];
            $this->return_res($this->modelthree->store($data),$url);
        }
        $this->assign('sid',$data['sid']);
        $this->assign('oldData',$oldData);
        return view();
    }
}