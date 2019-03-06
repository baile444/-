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

class Pinglun extends Base
{
    protected $middleware = [
        'Hearders'=>['only'=> ['addping']]
    ];

    /**
     * 提交评论
     * @param Request                  $request
     * @param \app\validate\Pinglun    $valid
     * @param \app\index\model\Order   $order
     * @param \app\index\model\Pinglun $pinglun
     *
     * @return \think\response\Json
     */
    public function addping(Request $request,\app\validate\Pinglun $valid,\app\index\model\Order $order,\app\index\model\Pinglun $pinglun){
        $data=$request->param();
        $valid->goCheck($data);
        $res=$order->staEdit(self::UserMess()['user_id'],$data['orid'],6);
        if(!$res){
            return json(['valid'=>0,'msg'=>'该订单不属于您']);
        }
        $data['user_id']=self::UserMess()['user_id'];
        $res=$pinglun->add($data);
        if(!$res){
            return json(['valid'=>0,'msg'=>'评论失败']);
        }
        return json(['valid'=>1,'msg'=>'评论成功']);
    }

    /**
     * 获取少量评论
     * @param Request                  $request
     * @param \app\index\model\Pinglun $pinglun
     *
     * @return \think\response\Json
     */
    public function getping(Request $request,\app\index\model\Pinglun $pinglun){
        $gid=$request->param('gid');
        $res=$pinglun->getping($gid);
        $count=$pinglun->where('gid',$gid)->count();
        $data=[
            'count'=>$count,
            'data'=>$res
        ];
        return json($data);
    }

    /**
     * 获取全部评论
     * @param Request                  $request
     * @param \app\index\model\Pinglun $pinglun
     *
     * @return \think\response\Json
     */
    public function getallping(Request $request,\app\index\model\Pinglun $pinglun){
        $gid=$request->param('gid');
        $res=$pinglun->getallping($gid);
        return json($res);
    }
}