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

class Getmess extends Base
{
    protected $middleware = ['Hearders'];

    /**
     * 获取返利统计
     * @param Request                $request
     * @param \app\index\model\Regis $regis
     *
     * @return \think\response\Json
     */
    public function getallcounts(\app\index\model\Regis $regis){
        $allcount=$regis->getCounts(self::UserMess()['user_id']);
        return json($allcount);
    }

    /**
     * 获取返利流水
     * @param Request                  $request
     * @param \app\index\model\Getmess $getmess
     */
    public function getallmess(\app\index\model\Getmess $getmess){
        $getmessData=$getmess->getjifenmess(self::UserMess()['user_id']);
        return json($getmessData);
    }

    /**
     * 获取返利流水pc分页
     * @param Request                  $request
     * @param \app\index\model\Getmess $getmess
     */
    public function getallmesspage(Request $request,\app\index\model\Getmess $getmess){
        $page=$request->param('page');
        $page = is_numeric($page) ? $page : 1;
        $getmessData=$getmess->getjifenmesspage(self::UserMess()['user_id'],$page);
        return json($getmessData);
    }

    /**
     * 余额流水
     * @param \app\index\model\Getmess $getmess
     *
     * @return \think\response\Json
     */
    public function getallmoneymess(\app\index\model\Getmess $getmess){
        $getmessData=$getmess->getmoneymess(self::UserMess()['user_id']);
        return json($getmessData);
    }

    /**
     * 获取积分流水
     * @param \app\index\model\Getmess $getmess
     *
     * @return \think\response\Json
     */
    public function getalljifenmess(\app\index\model\Getmess $getmess){
        $res=$getmess->getjifen(self::UserMess()['user_id']);
        return json($res);
    }

    /**
     * 获取积分流水分页pc
     * @param \app\index\model\Getmess $getmess
     *
     * @return \think\response\Json
     */
    public function getalljifenmesspage(Request $request,\app\index\model\Getmess $getmess){
        $data=$request->param();
        $data['can_sta'] = isset($data['can_sta']) ? $data['can_sta'] : 0;
        $data['page'] = isset($data['page']) ? $data['page'] : 1;
        $res=$getmess->getjifenpage(self::UserMess()['user_id'],$data);
        return json($res);
    }

    /**
     * 获取余额流水分页pc
     * @param \app\index\model\Getmess $getmess
     *
     * @return \think\response\Json
     */
    public function getallmoneymesspage(Request $request,\app\index\model\Getmess $getmess){
        $data=$request->param();
        $data['can_sta'] = isset($data['can_sta']) ? $data['can_sta'] : 0;
        $data['page'] = isset($data['page']) ? $data['page'] : 1;
        $res=$getmess->getmoneypage(self::UserMess()['user_id'],$data);
        return json($res);
    }
}