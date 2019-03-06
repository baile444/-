<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/5/26
 * Time : 14:56
 * Email: 417780879@qq.com
 */
namespace app\admin\controller;
use app\admin\model\Goodspic;
use app\admin\model\Level;
use app\common\controller\Common;
use app\admin\model\Goods as Shopgoods;
use app\admin\model\Cate as Cate;
use think\Db;
use think\Request;

class Goods extends Common
{
    protected $page=20;
    public function initialize()
    {
        parent ::initialize();
        $this->url=url('admin/goods/index');
        $this->model=new \app\admin\model\Goods();
    }

    public function index(Request $request){
        $goodsData=Db::name('goods')->alias('g')
            ->join('cate c','g.cid=c.cid')
            ->order('g.gsort desc,g.gid desc')
            ->paginate($this->page);
        if($request->post()){
            $gname=$request->param('gname');
            $goodsData=Db::name('goods')->alias('g')
                ->join('cate c','g.cid=c.cid')
                ->where('g.gname','like','%'.$gname.'%')
                ->order('g.gsort desc,g.gid desc')
                ->paginate($this->page);
        }
        $this->assign('goodsData',$goodsData);
        return view();
    }

    public function rececommend(Request $request){
        $data=$request->param();
        $data['page']=isset($data['page'])?$data['page']:0;
        $url=url('admin/goods/index',['gid'=>$data['gid'],'page'=>$data['page']]);
//        if($data['re']==1){
//            \app\admin\model\Recommend::create(['gid'=>$data['gid']]);
//        }
        $this->return_res((new Shopgoods())->store($data),$url);
    }

    public function pic(Request $request){
        $gid=$request->param('gid');
        $name=Shopgoods::where('gid',$gid)->value('gname');
        $picData=Goodspic::where('gid',$gid)->order('bsort desc')->select();
        $this->assign('picData',$picData);
        $this->assign('name',$name);
        return view();
    }

    public function level(Request $request){
        $name=Shopgoods::where('gid',$request->param('gid'))->value('gname');
        $levelData=Level::where('gid',$request->param('gid'))->select();
        $this->assign('levelData',$levelData);
        $this->assign('name',$name);
        return view();
    }

    public function addgoods(Request $request){
        $cateDate=Cate::all();
        if($request->isPost()){
            $data=$request->param();
            $this->return_res($this->model->store($data),$this->url);
        }
        $this->assign('cateDate',$cateDate);
        return view();
    }

    public function addgoodspic(Request $request){
        $name=Shopgoods::where('gid',$request->param('gid'))->value('gname');
        if($request->isPost()){
            $data=$request->param();
            $data['page']=isset($data['page'])?$data['page']:0;
            $url=url('admin/goods/pic',['gid'=>$data['gid'],'page'=>$data['page']]);
            $this->return_res((new Goodspic())->store($data),$url);
        }
        $this->assign('name',$name);
        return view();
    }

    public function addlevel(Request $request){
        if($request->isPost()){
            $data=$request->param();
            $data['page']=isset($data['page'])?$data['page']:0;
            $url=url('admin/goods/level',['gid'=>$data['gid'],'page'=>$data['page']]);
            $this->return_res((new Level())->store($data),$url);
        }
        return view();
    }

    public function editgoods(Request $request){
        $cateDate=Cate::all();
        $gid=$request->param('gid');
        $page=$request->param('page');
        $oldData=$this->model->find($gid)->toArray();
        if($request->isPost()){
            $data=$request->param();
            $this->return_res($this->model->store($data),$this->url.'?page='.$page);
        }
        $this->assign('oldData',$oldData);
        $this->assign('cateDate',$cateDate);
        return view();
    }

    public function editlevel(Request $request){
        $oldData=Level::get($request->param('lid'));
        if($request->isPost()){
            $data=$request->param();
            $data['page']=isset($data['page'])?$data['page']:0;
            $url=url('admin/goods/level',['gid'=>$data['gid'],'page'=>$data['page']]);
            $this->return_res((new Level())->store($data),$url);
        }
        $this->assign('oldData',$oldData);
        return view();
    }

    public function delgoods(Request $request){
        if($request->isGet()){
            $id=$request->param('id');
            $page=$request->param('page');
            $num=$this->model->destroy($id);
            $this->return_del($num,$this->url.'?page='.$page);
        }
    }

    public function delpic(Request $request){
        if($request->isGet()){
            $data=$request->param();
            $data['page']=isset($data['page'])?$data['page']:0;
            $url=url('admin/goods/pic',['gid'=>$data['gid'],'page'=>$data['page']]);
            $num=(new Goodspic())->destroy($data['id']);
            $this->return_del($num,$url);
        }
    }

    public function dellevel(Request $request){
        if($request->isGet()){
            $data=$request->param();
            $data['page']=isset($data['page'])?$data['page']:0;
            $url=url('admin/goods/level',['gid'=>$data['gid'],'page'=>$data['page']]);
            $num=(new Level())->destroy($data['id']);
            $this->return_del($num,$url);
        }
    }

    public function ajaxEditSort(Request $request)
    {
        if($request->isAjax()){
            return $this ->model -> editsort($request -> param());
        }
    }

    public function ajaxEditSortpic(Request $request)
    {
        if($request->isAjax()){
            return (new Goodspic()) -> editsort($request -> param());
        }
    }
}