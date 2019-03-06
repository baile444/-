<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/20
 * Time : 11:29
 * Email: 417780879@qq.com
 */
namespace app\index\controller;
use app\admin\model\Jifen;
use app\common\controller\Base;
use app\common\Predis;
use think\facade\Log;
use think\Request;

class Fapiao extends Base
{
    protected $middleware = ['Hearders'];

    /**
     * 获取发票信息
     * @param Request                 $request
     * @param \app\index\model\Fapiao $fapiao
     *
     * @return \think\response\Json
     */
    public function getinfo(Request $request, \app\index\model\Fapiao $fapiao){
        $userid=self::UserMess()['user_id'];
        $data = $fapiao->where('user_id',$userid)->select()->toArray();
        $data=current($data);
        if(!$data){
            $fapiao->add(['user_id'=>$userid]);
        }
        return json($data);
    }

    /**
     * 修改发票信息
     * @param Request                 $request
     * @param \app\index\model\Fapiao $fapiao
     *
     * @return \think\response\Json
     */
    public function editinfo(Request $request, \app\index\model\Fapiao $fapiao){
        $data=$request->param();
        $data['user_id']=self::UserMess()['user_id'];
        $res=$fapiao->edit($data);
        if($res){
            return json(['valid'=>1]);
        }
        return json(['valid'=>0]);
    }
}