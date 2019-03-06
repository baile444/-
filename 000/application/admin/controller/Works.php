<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/2/2
 * Time : 13:43
 * Email: 417780879@qq.com
 */
namespace app\admin\controller;
use app\common\controller\Common;
use app\index\model\Work;
use think\Db;
use think\Request;

class Works extends Common
{
    public function initialize()
    {
        parent ::initialize();
        $this->model=new Work();
    }

    public function index(Request $request)
    {
        $data=Db::table('res_work')->alias('w')
            ->join('res_category c','w.cid=c.cid')
            ->join('res_user u','w.user_id=u.user_id')
            ->order('w.sorts')
            ->select();
        $this->assign('data',$data);
        return view();
    }

    public function editworks(Request $request){
        $data=[
          'id'=>$request->param('id'),
          'sorts'=>1
        ];
        $this->model->editMess($data);
        $this->redirect('admin/works/index');
    }

}