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
use app\index\model\Getmess;
use app\index\model\Regis;
use think\Db;
use think\Request;

class User extends Common
{
    public function initialize()
    {
        parent ::initialize();
        $this->model=new \app\admin\model\User();
        $this->url=url('admin/user/index');
    }

    /**
     * 余额流水
     * @param Request $request
     * @param Getmess $getmess
     *
     * @return \think\response\View
     */
    public function moneylist(Request $request,Getmess $getmess){
        $user_id=$request->param('user_id');
        $data=$getmess->with('order')->where('user_id',$user_id)->where('can_money','>','-999999')->where('can_sta',1)->order('can_id desc')->select()->toArray();
        $this->assign('data',$data);
        return view();
    }

    /**
     * 积分流水
     * @param Request $request
     * @param Getmess $getmess
     *
     * @return \think\response\View
     */
    public function jifenlist(Request $request,Getmess $getmess){
        $user_id=$request->param('user_id');
        $data=$getmess->with('order')->where('user_id',$user_id)->where('can_fen','>','-999999')->where('can_sta',1)->order('can_id desc')->select()->toArray();
        $this->assign('data',$data);
        return view();
    }

    /**
     * 会员列表
     * @param \app\admin\model\User $user
     *
     * @return \think\response\View
     */
    public function index(Request $request,\app\admin\model\User $user){
        $phone=$request->param('phone');
        if($phone){
            $userData=$user->where('phone','like',$phone.'%')->paginate(20);
        } else {
            $userData=$user->paginate(20);
        }
        $this->assign('userData',$userData);
        return view();
    }

    /**
     * 提现列表
     * @param Getmess $getmess
     *
     * @return \think\response\View
     */
    public function remoney(Getmess $getmess){
        $data=$getmess->alias('g')
            ->join('user u','g.user_id=u.user_id')
            ->where('g.can_content','申请提现')
            ->where('g.can_sta',0)
            ->field('u.user_id,u.phone,u.wechat,u.apayname,u.apay,g.can_id,g.can_sta,g.create_time,g.can_money')
            ->select();
        $this->assign('data',$data);
        return view();
    }

    /**
     * 确认提现
     * @param Request $request
     * @param Getmess $getmess
     */
    public function gsta(Request $request,Getmess $getmess){
        $can_id=$request->param('can_id');
        $getmess->editsta($can_id);
        $this->redirect('admin/user/remoney');
    }

    /**
     * 已提现列表
     * @param Getmess $getmess
     *
     * @return \think\response\View
     */
    public function hadremoney(Getmess $getmess){
        $data=$getmess->alias('g')
            ->join('user u','g.user_id=u.user_id')
            ->where('g.can_content','申请提现')
            ->where('g.can_sta',1)
            ->field('u.user_id,u.phone,u.wechat,u.apayname,u.apay,g.can_id,g.can_sta,g.create_time,g.can_money')
            ->select();
        $this->assign('data',$data);
        return view();
    }

    /**
     * 推广
     * @param Request $request
     */
    public function edit(Request $request){
        $data=$request->param();
        $page=isset($data['page']) ? $data['page'] : 1;
        $url=$this->url . '?page=' . $page;
        $this->return_res($this->model->store($data),$url);
    }

    /**
     * 改变积分
     * @param Request $request
     * @param Regis   $regis
     * @param Getmess $getmess
     *
     * @return int
     */
    public function ajaxJifen(Request $request,Regis $regis,Getmess $getmess){
        $data=$request->param();
        $userdata=$regis->getUserMessage($data['userid']);
        $userup=[
            'user_id'=>$userdata['user_id'],
            'jifen'=>$userdata['jifen']+$data['can_fen']
        ];
        if($userup['jifen'] < 0){
            return '积分不能少于0';
        }
        $getmessdata=[
            'user_id'=>$userdata['user_id'],
            'can_content'=>$data['can_content'],
            'can_fen'=>$data['can_fen'],
            'can_sta'=>1,
        ];
        Db::startTrans();
        try {
            $regis->store($userup);
            $getmess->add($getmessdata);
            // 提交事务
            Db::commit();
            return 1;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return 0;
        }
    }

    /**
     * 改变余额
     * @param Request $request
     * @param Regis   $regis
     * @param Getmess $getmess
     *
     * @return int
     */
    public function ajaxMoney(Request $request,Regis $regis,Getmess $getmess){
        $data=$request->param();
        $userdata=$regis->getUserMessage($data['userid']);
        $userup=[
            'user_id'=>$userdata['user_id'],
            'money'=>$userdata['money']+$data['can_money']
        ];
        if($userup['money']<0){
            return '余额不能少于0';
        }
        $getmessdata=[
            'user_id'=>$userdata['user_id'],
            'can_content'=>$data['can_content'],
            'can_money'=>$data['can_money'],
            'can_sta'=>1,
        ];
        Db::startTrans();
        try {
            $regis->store($userup);
            $getmess->add($getmessdata);
            // 提交事务
            Db::commit();
            return 1;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return 0;
        }
    }
}