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

class Allmess extends Common
{
    protected $urltwo;
    public function initialize()
    {
        parent ::initialize();
        $this->model=new \app\admin\model\Allmess();
        $this->url=url('admin/allmess/index');
    }

    public function index(Request $request){
        $shopfromData=$this->model->where('cid',$request->param('cid'))->order('pid,asort desc')->select()->toArray();
//        $news=[];
//        if(count($shopfromData)>0){
//            foreach($shopfromData as $k=>$v) {
//                if($v['pid'] == 0) {
//                    $v['_data']=[];
//                    $news[$v['id']] = $v;
//                } else {
//                    if(isset($news[$v['pid']])){
//                        $news[$v['pid']]['_data'][] = $v;
//                    }
//                }
//            }
//        }
        $cname=\app\admin\model\Category::where('cid',$request->param('cid'))->value('cname');
        $this->assign('cname',$cname);
        $this->assign('allData',$shopfromData);
        return view();
    }


    public function add(Request $request){
        if($request->isPost()){
            $data=$request->param();
            $url=url('admin/allmess/index',['cid'=>$data['cid']]);
            $this->return_res($this->model->store($data),$url);
        }
        $cateData=$this->model->where('pid',0)->where('cid',$request->param('cid'))->select();
        $this->assign('cateData',$cateData);
        return view();
    }

    public function edit(Request $request){
        $oldData=$this->model->get($request->param('id'));
        if($request->isPost()){
            $data=$request->param();
            $url=url('admin/allmess/index',['cid'=>$data['cid']]);
            $this->return_res($this->model->store($data),$url);
        }
        $cateData=$this->model->where('pid',0)->where('cid',$request->param('cid'))->select();
        $this->assign('cateData',$cateData);
        $this->assign('oldData',$oldData);
        return view();
    }

    public function del(Request $request){
        if($request->isGet()){
            $id=$request->param('id');
//            $this->model->where('pid',$id)->delete();
            $num=$this->model->destroy($id);
            $url=url('admin/allmess/index',['sid'=>$request->param('sid')]);
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