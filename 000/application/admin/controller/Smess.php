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

class Smess extends Common
{
    protected $urltwo;
    public function initialize()
    {
        parent ::initialize();
        $this->model=new \app\admin\model\Smess();
        $this->url=url('admin/smess/index');
    }

    public function index(Request $request){
        $smessdata=\app\admin\model\Smess::where('sta',0)->order('smid desc')->select()->toArray();
        foreach($smessdata as $k=>$v){
            $smessdata[$k]['cid']=json_decode($v['cid'],true);
        }
        $this->assign('smessdata',$smessdata);
        return view();
    }

    public function bmess(Request $request){
        $smessdata=\app\admin\model\Smess::where('sta',1)->order('smid desc')->select();
        foreach($smessdata as $k=>$v){
            $smessdata[$k]['cid']=json_decode($v['cid'],true);
        }
        $this->assign('smessdata',$smessdata);
        return view();
    }

    public function del(Request $request){
        if($request->isGet()){
            $id=$request->param('id');
            $num=$this->model->destroy($id);
            $this->delmess($num,$this->url);
        }
    }

    public function dels(Request $request){
        if($request->isGet()){
            $id=$request->param('id');
            $num=$this->model->destroy($id);
            $url=url('admin/smess/bmess');
            $this->delmess($num,$url);
        }
    }

    public function ajaxEditBeiwang(Request $request){
        if($request->isAjax()){
            $data=$request->param();
            if($data['type']==1){
                $urls=url('admin/smess/index');
            }else{
                $urls=url('admin/smess/bsmess');
            }
            $res=$this->model->store($data);
            if($res){
                return 1;
            }else{
                return 0;
            }
        }
    }
}