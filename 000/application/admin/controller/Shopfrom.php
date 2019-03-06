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

class Shopfrom extends Common
{
    protected $urltwo;
    public function initialize()
    {
        parent ::initialize();
        $this->model=new \app\admin\model\Shopfrom();
        $this->url=url('admin/shopfrom/index');
    }

    public function index(Request $request){
        $shopfromData=$this->model->where('sid',$request->param('sid'))->order('pid,sort desc')->select()->toArray();
        $news=[];
        foreach($shopfromData as $k=>$v){
            if($v['pid']==0){
                $news[$v['cid']]=$v;
            }else{
                if(isset($news[$v['pid']])){
                    $news[$v['pid']]['_data'][]=$v;
                }
            }
        }
        $this->assign('shopfromData',$news);
        return view();
    }


    public function add(Request $request){
        if($request->isPost()){
            $data=$request->param();
            $url=url('admin/shopfrom/index',['sid'=>$data['sid']]);
            $this->return_res($this->model->store($data),$url);
        }
        $cateData=$this->model->where('pid',0)->where('sid',$request->param('sid'))->select();
        $this->assign('cateData',$cateData);
        return view();
    }

    public function edit(Request $request){
        $oldData=$this->model->get($request->param('cid'));
        if($request->isPost()){
            $data=$request->param();
            $url=url('admin/shopfrom/index',['sid'=>$data['sid']]);
            $this->return_res($this->model->store($data),$url);
        }
        $cateData=$this->model->where('pid',0)->where('sid',$request->param('sid'))->select();
        $this->assign('cateData',$cateData);
        $this->assign('oldData',$oldData);
        return view();
    }

    public function del(Request $request){
        if($request->isGet()){
            $id=$request->param('id');
            $num=$this->model->destroy($id);
            $this->model->where('pid',$id)->delete();
            $url=url('admin/shopfrom/index',['sid'=>$request->param('sid')]);
            $this->delmess($num,$url);
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