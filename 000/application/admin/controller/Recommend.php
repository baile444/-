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

class Recommend extends Common
{
    public function initialize()
    {
        parent ::initialize();
        $this->model=new \app\admin\model\Recommend();
        $this->url=url('admin/recommend/index');}

    public function index(){
//        $reData=Db::name('goods')->alias('g')
//            ->join('recommend r','g.gid=r.gid')
//            ->where('r.typecid=0')
//            ->order('r.sta desc,r.rsort desc,r.rid')
//            ->select();
//        $this->assign('reData',$reData);
        return view();
    }

    public function start(Request $request){
        $data=$request->param();
        $this->return_res($this->model->store($data),$this->url);
    }

    public function edit(Request $request){
        $oldData=$this->model->get($request->param('rid'));
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
            (new \app\admin\model\Goods())->store(['gid'=>$data['gid'],'re'=>0]);
            if($data['pic']){
                unlink(APP_PATH.'/uploads/'.$data['pic']);
            }
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