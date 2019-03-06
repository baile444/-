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
use app\index\model\Reorder;
use think\Db;
use think\Request;

class Order extends Common
{
    protected $page = 10;
    public function initialize()
    {
        parent ::initialize();
        $this->model=new \app\index\model\Order();
        $this->url=url('admin/banner/index');
    }

    /**
     * 待发货
     * @param \app\index\model\Order $order
     *
     * @return \think\response\View
     */
    public function index(Request $request,\app\index\model\Order $order){
        $order_id=$request->param('order_id');
        $phone=$request->param('phone');
        if($order_id || $phone){
            if($order_id){
                $data=$order->alias('o')
                    ->join('addresss a','o.aid=a.aid')
                    ->join('user u','o.user_id=u.user_id')
                    ->where('o.sta',1)
                    ->where('o.order_id','like','%'.$order_id.'%')
                    ->with('ordermess')
                    ->order('o.orid desc')
                    ->field('o.orid,o.transaction_id,o.order_id,o.hadpay,o.create_time,a.address_before,a.address_after,u.phone,u.user_id,o.code')
                    ->paginate($this->page)->each(function($item, $key){
                        $item->fapiao = Db::name('fapiao')->where('user_id',$item->user_id)->find();
                    });
            }else{
                $data=$order->alias('o')
                    ->join('addresss a','o.aid=a.aid')
                    ->join('user u','o.user_id=u.user_id')
                    ->where('o.sta',1)
                    ->where('a.aphone',$phone)
                    ->with('ordermess')
                    ->order('o.orid desc')
                    ->field('o.orid,o.transaction_id,o.order_id,o.hadpay,o.create_time,a.address_before,a.address_after,u.phone,u.user_id,o.code')
                    ->paginate($this->page)->each(function($item, $key){
                        $item->fapiao = Db::name('fapiao')->where('user_id',$item->user_id)->find();
                    });
            }

        } else {
            $data=$order->alias('o')
                ->join('addresss a','o.aid=a.aid')
                ->join('user u','o.user_id=u.user_id')
                ->where('o.sta',1)
                ->with('ordermess')
                ->order('o.orid desc')
                ->field('o.orid,o.transaction_id,o.order_id,o.hadpay,o.create_time,a.address_before,a.address_after,u.phone,u.user_id,o.code')
                ->paginate($this->page)->each(function($item, $key){
                    $item->fapiao = Db::name('fapiao')->where('user_id',$item->user_id)->find();
                });
        }
        $this->assign('data',$data);
        return view();
    }

    public function suorder(Request $request,\app\index\model\Order $order){
        $data=$request->param();
        $order->adminStaEdit($data['orid'],'2');
        $this->redirect('admin/order/index');
    }

    /**
     * 发货单号
     * @param Request                $request
     * @param \app\index\model\Order $order
     *
     * @return bool
     */
    public function ajaxEditSort(Request $request,\app\index\model\Order $order){
        if($request->isAjax()){
            $data=$request->param();
            return $order->adminCodeEdit($data['id'],$data['code']);
        }
    }

    /**
     * 完成订单
     * @param \app\index\model\Order $order
     *
     * @return \think\response\View
     */
    public function succ(Request $request,\app\index\model\Order $order){
        $order_id=$request->param('order_id');
        $phone=$request->param('phone');
        if($order_id || $phone){
            if($order_id){
                $data=$order->alias('o')
                    ->join('addresss a','o.aid=a.aid')
                    ->join('user u','o.user_id=u.user_id')
                    ->where('o.sta','in',[3,6])
                    ->where('o.order_id','like','%'.$order_id.'%')
                    ->order('o.orid desc')
                    ->field('o.orid,o.transaction_id,o.order_id,o.hadpay,o.create_time,a.address_before,a.address_after,u.phone,o.code')
                    ->paginate($this->page);
            } else {
                $data=$order->alias('o')
                    ->join('addresss a','o.aid=a.aid')
                    ->join('user u','o.user_id=u.user_id')
                    ->where('o.sta','in',[3,6])
                    ->where('a.aphone',$phone)
                    ->order('o.orid desc')
                    ->field('o.orid,o.transaction_id,o.order_id,o.hadpay,o.create_time,a.address_before,a.address_after,u.phone,o.code')
                    ->paginate($this->page);
            }

        } else {
            $data=$order->alias('o')
                ->join('addresss a','o.aid=a.aid')
                ->join('user u','o.user_id=u.user_id')
                ->where('o.sta',3)
                ->whereOr('o.sta',6)
                ->order('o.orid desc')
                ->field('o.orid,o.transaction_id,o.order_id,o.hadpay,o.create_time,a.address_before,a.address_after,u.phone,o.code')
                ->paginate($this->page);
        }
//        dump($data);
        $this->assign('data',$data);
        return view();
    }

    /**
     * 待收货
     * @param \app\index\model\Order $order
     *
     * @return \think\response\View
     */
    public function wait(Request $request,\app\index\model\Order $order){
        $order_id=$request->param('order_id');
        $phone=$request->param('phone');
        if($order_id || $phone){
            if($order_id){
                $data=$order->alias('o')
                    ->join('addresss a','o.aid=a.aid')
                    ->join('user u','o.user_id=u.user_id')
                    ->where('o.sta',2)
                    ->where('o.order_id','like','%'.$order_id.'%')
                    ->order('o.orid desc')
                    ->field('o.orid,o.transaction_id,o.order_id,o.hadpay,o.create_time,a.address_before,a.address_after,u.phone,o.code')
                    ->paginate($this->page);
            }else{
                $data=$order->alias('o')
                    ->join('addresss a','o.aid=a.aid')
                    ->join('user u','o.user_id=u.user_id')
                    ->where('o.sta',2)
                    ->where('a.aphone',$phone)
                    ->order('o.orid desc')
                    ->field('o.orid,o.transaction_id,o.order_id,o.hadpay,o.create_time,a.address_before,a.address_after,u.phone,o.code')
                    ->paginate($this->page);
            }

        } else {
            $data=$order->alias('o')
                ->join('addresss a','o.aid=a.aid')
                ->join('user u','o.user_id=u.user_id')
                ->where('o.sta',2)
                ->order('o.orid desc')
                ->field('o.orid,o.transaction_id,o.order_id,o.hadpay,o.create_time,a.address_before,a.address_after,u.phone,o.code')
                ->paginate($this->page);
        }

        $this->assign('data',$data);
        return view();
    }
    public function beorder(Request $request,\app\index\model\Order $order){
        $data=$request->param();
        $order->adminStaEdit($data['orid'],'3');
        $this->redirect('admin/order/wait');
    }

    /**
     * 退款订单
     * @param \app\index\model\Order $order
     *
     * @return \think\response\View
     */
    public function recommend(Request $request,\app\index\model\Order $order){
        $order_id=$request->param('order_id');
        $phone=$request->param('phone');
        if($order_id || $phone){
            if($order_id){
                $data=$order->alias('o')
                    ->join('reorder r','o.orid=r.orid')
                    ->join('addresss a','o.aid=a.aid')
                    ->join('user u','o.user_id=u.user_id')
                    ->where('o.sta',4)
                    ->where('o.order_id','like','%'.$order_id.'%')
                    ->field('o.orid,o.transaction_id,o.order_id,o.hadpay,o.create_time,a.address_before,a.address_after,u.phone,r.reprice,r.reid,o.code')
                    ->paginate($this->page);
            } else {
                $data=$order->alias('o')
                    ->join('reorder r','o.orid=r.orid')
                    ->join('addresss a','o.aid=a.aid')
                    ->join('user u','o.user_id=u.user_id')
                    ->where('o.sta',4)
                    ->where('a.aphone',$phone)
                    ->field('o.orid,o.transaction_id,o.order_id,o.hadpay,o.create_time,a.address_before,a.address_after,u.phone,r.reprice,r.reid,o.code')
                    ->paginate($this->page);
            }

        } else {
            $data=$order->alias('o')
                ->join('reorder r','o.orid=r.orid')
                ->join('addresss a','o.aid=a.aid')
                ->join('user u','o.user_id=u.user_id')
                ->where('o.sta',4)
                ->field('o.orid,o.transaction_id,o.order_id,o.hadpay,o.create_time,a.address_before,a.address_after,u.phone,r.reprice,r.reid,o.code')
                ->paginate($this->page);
        }

        $this->assign('data',$data);
        return view();
    }
    public function reorder(Request $request,\app\index\model\Order $order,Reorder $reorder){
        $data=$request->param();
        $order->adminStaEdit($data['orid'],'5');
        $reorder->adminStaEdit($data['reid'],'1');
        $this->redirect('admin/order/recommend');
    }
    /**
     * 已处理退款订单
     * @param \app\index\model\Order $order
     *
     * @return \think\response\View
     */
    public function hadrecommend(Request $request,\app\index\model\Order $order){
        $order_id=$request->param('order_id');
        $phone=$request->param('phone');
        if($order_id || $phone){
            if($order_id){
                $data=$order->alias('o')
                    ->join('reorder r','o.orid=r.orid')
                    ->join('addresss a','o.aid=a.aid')
                    ->join('user u','o.user_id=u.user_id')
                    ->where('o.sta',5)
                    ->where('o.order_id','like','%'.$order_id.'%')
                    ->order('o.orid desc')
                    ->field('o.orid,o.transaction_id,o.order_id,o.hadpay,o.create_time,a.address_before,a.address_after,u.phone,r.reprice,r.reid,o.code')
                    ->paginate($this->page);
            } else {
                $data=$order->alias('o')
                    ->join('reorder r','o.orid=r.orid')
                    ->join('addresss a','o.aid=a.aid')
                    ->join('user u','o.user_id=u.user_id')
                    ->where('o.sta',5)
                    ->where('a.aphone',$phone)
                    ->order('o.orid desc')
                    ->field('o.orid,o.transaction_id,o.order_id,o.hadpay,o.create_time,a.address_before,a.address_after,u.phone,r.reprice,r.reid,o.code')
                    ->paginate($this->page);
            }

        }else{
            $data=$order->alias('o')
                ->join('reorder r','o.orid=r.orid')
                ->join('addresss a','o.aid=a.aid')
                ->join('user u','o.user_id=u.user_id')
                ->where('o.sta',5)
                ->order('o.orid desc')
                ->field('o.orid,o.transaction_id,o.order_id,o.hadpay,o.create_time,a.address_before,a.address_after,u.phone,r.reprice,r.reid,o.code')
                ->paginate($this->page);
        }
        $this->assign('data',$data);
        return view();
    }
}