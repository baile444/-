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

class Messages extends Common
{
    public function initialize()
    {
        parent ::initialize();
        $this->model=new \app\index\model\Messages();
        $this->url=url('admin/messages/index');
    }

    public function index(){
        $mess=$this->model->order('create_time desc')->paginate(20);
        $this->assign('mess',$mess);
        return view();
    }

    public function del(Request $request){
        $data=$request->param();
        $data['page']=isset($data['page'])?$data['page']:1;
        $num=$this->model->destroy($data['id']);
        $urls=url('admin/messages/index',['id'=>$data['id']]).'?page='.$data['page'];
        $this->delmess($num,$urls);
    }
}