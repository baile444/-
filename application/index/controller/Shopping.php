<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/20
 * Time : 11:29
 * Email: 417780879@qq.com
 */
namespace app\index\controller;
use app\common\controller\Base;
use think\Request;

class Shopping extends Base
{
    protected $middleware = ['Hearders'];

    /**获取购物车
     * @param \app\index\model\Shopping $model
     *
     * @return \think\response\Json
     */
    public function getcar(\app\index\model\Shopping $model){
        $data=$model->resources(self::UserMess()['user_id']);
        return json($data);
    }

    /**
     * 购物车数量
     * @param \app\index\model\Shopping $shopping
     *
     * @return float|string
     */
    public function getcartscoutns(\app\index\model\Shopping $shopping){
        $data=$shopping->resources(self::UserMess()['user_id']);
        $counts=count($data);
        return $counts;
    }

    /**添加购物车
     * @param Request                   $request
     * @param \app\validate\Shopping    $vshopping
     * @param \app\index\model\Shopping $model
     *
     * @return \think\response\Json
     */
    public function addcar(Request $request,\app\validate\Shopping $vshopping,\app\index\model\Shopping $model){
        $data=$request->param();
        $vshopping->goCheck($data,'add');
        $res=$model->add($data);
        if($res<1){
            return json(['valid'=>0,'msg'=>'未知错误']);
        }
        return json(['valid'=>1,'spid'=>$res,'msg'=>'宝贝已在购物车等您']);
    }

    /**修改购物车
     * @param Request $request
     * @param \app\index\model\Shopping $model
     */
    public function editcarts(Request $request,\app\index\model\Shopping $model){
        $data=$request->param();
        $spids=[];
        foreach($data['spid'] as $k=>$v){
            $spids[]=json_decode($v,256);
        }
        $model->editall($spids);
        return 1;
    }

    /**
     * 删除购物车
     * @param Request                   $request
     * @param \app\index\model\Shopping $model
     *
     * @return int
     */
    public function delcarts(Request $request,\app\index\model\Shopping $model){
        $spid=$request->param('spid');
        $res=$model->delcart(self::UserMess()['user_id'],$spid);
        if(!$res){
            return 0;
        }
        return 1;
    }

    /**
     * 清空购物车
     * @param Request                   $request
     * @param \app\index\model\Shopping $model
     *
     * @return int
     */
    public function delallcarts(Request $request,\app\index\model\Shopping $model){
        $res=$model->delallcart(self::UserMess()['user_id']);
        if(!$res){
            return 0;
        }
        return 1;
    }
}