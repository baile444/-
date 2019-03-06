<?php
namespace app\index\controller;
use app\admin\model\Banner;
use app\admin\model\Cateban;
use app\admin\model\Category;
use app\admin\model\Firendship;
use app\admin\model\Logos;
use app\admin\model\News;
use app\admin\model\Servers;
use app\admin\model\Shopfrom;
use app\admin\model\Works;
use app\common\controller\Base;
use app\common\Ordercode;
use app\common\Predis;
use EasyWeChat\Factory;
use think\Db;
use think\facade\Log;
use think\Request;

class Index extends Base
{
    public function index()
    {
//        $phone=\app\admin\model\Logos::where('id',1)->value('message');
//        (new Ordercode())->getCode($phone);
        return view();
    }

    public function pchome(){
        return true;
    }

    /**
     * 微信支付成功通知
     */
    public function home(){
        $config=[
            'app_id'             => 'wx17d8a5f7f8636621',
            'mch_id'             => '1517212151',
            'key'                => 'e35d5fbf31d42f4fa0771aa9915cf469',
        ];
        $app=Factory::payment($config);
        $response = $app->handlePaidNotify(function($message, $fail){
            if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if ($message['result_code']=== 'SUCCESS') {
                    \app\index\model\Order::where('order_id', $message['out_trade_no'])->update(['sta' => 1,'hadpay'=>$message['total_fee']/100,'transaction_id'=>$message['transaction_id']]);
                    return true;
                } else {
                    Log::write($fail,'wechat');
                    return $fail('支付失败，请稍后再通知我');
                }
            } else {
                return $fail('通信失败，请稍后再通知我');
            }
            return true; // 返回处理完成
        });
        $response->send();
    }

    public function getlogos(){
        $data=Logos::get(1);
        return json($data);
    }

    /**轮播图
     * @return \think\response\Json
     */
    public function lunbo(){
        $data=Banner::order('sort desc,id')->select();
        return json($data);
    }

    /**分类
     * @return \think\response\Json
     */
    public function category(){
        $data=Predis::getInstance()->get('api_category');
        if(!$data){
            $data=Category::order('sort desc,cid')->field('cid,cname,clevel,cintro,npic,cpic,mpic')->select();
            foreach($data as $k=>$v){
                $data[$k]['_cate']=explode('#',$v['clevel']);
            }
            Predis::getInstance()->set('api_category',json_encode($data,256));
        }else{
            $data=json_decode($data,256);
        }
        return json($data);
    }

    /**服务优势
     * @return \think\response\Json
     */
    public function servers(){
        $data=Servers::order('sort desc')->select();
        return json($data);
    }

    /**
     * 友情链接
     * @return \think\response\Json
     */
    public function firendship(){
        $data=Firendship::order('sort desc')->limit(12)->select();
        return json($data);
    }

    /**
     * 新闻资讯首页
     * @return \think\response\Json
     */
    public function getnews(){
        $data=News::order('sort desc')->limit(3)->select();
        return json($data);
    }

    /**
     * 新闻资讯全部
     * @return \think\response\Json
     */
    public function getallnews(){
        $data=Db::name('news')->alias('n')
            ->join('newscate c','n.cid=c.cid')
            ->order('n.sort desc')
            ->limit(2)
            ->select();
        foreach($data as $k=>$v){
            $time1=date('Y-m',$v['create_time']);
            $time2=date('d',$v['create_time']);
            $data[$k]['nian']=$time1;
            $data[$k]['day']=$time2;
        }
        return json($data);
    }

    /**新闻内容
     * @param Request $request
     *
     * @return \think\response\Json
     */
    public function getnewscontent(Request $request){
        $nid=$request->param('nid');
        $data=News::get($nid);
        return json($data);
    }

    /**服务商列表
     * @param Request $request
     *
     * @return \think\response\Json
     */
    public function getServerCate(Request $request){
        $cid=$request->param('cid');
        $name=$cid<1?'全部':Category::where('cid',$cid)->value('cname');
        if($cid<1){
            $olddata=Db::name('shops')->alias('s')
                ->join('category c','s.cid=c.cid')
                ->join('works w','w.sid=s.sid')
                ->order('c.sort desc,s.ssort desc')
                ->select();
        }else{
            $olddata=Db::name('shops')->alias('s')
                ->join('category c','s.cid=c.cid')
                ->join('works w','w.sid=s.sid')
                ->where('c.cid',$cid)
                ->order('s.ssort desc')
                ->select();
        }
        $newData=[];
        foreach($olddata as $k=>$v){
            if(isset($newData[$v['sid']])){
                $newData[$v['sid']]['wnames'][]=$v['wname'];
            }else{
                $newData[$v['sid']]=$v;
                $newData[$v['sid']]['wnames'][]=$v['wname'];
            }
        }
        $data=[
            'type'=>$name,
            'mess'=>$newData
        ];
        return json($data);
    }

    /**服务商详情
     * @param Request $request
     *
     * @return \think\response\Json
     */
    public function getServerContent(Request $request){
        $sid=$request->param('sid');
        $com=Category::get($sid);
        $works=Works::where('sid',$sid)->select();
        $data=[
            'com'=>$com,
            'works'=>$works
        ];
        return json($data);
    }

    /**获取表单
     * @param Request $request
     *
     * @return \think\response\Json
     */
    public function getfrom(Request $request){
        $sid=$request->param('sid');
        $data=Shopfrom::where('sid',$sid)->select()->toArray();
        $newdata=[];
        foreach($data as $k=>$v){
            $v['sta']=1;
            if($v['pid']==0){
                $newdata[$v['cid']]=$v;
            }else{
                $newdata[$v['pid']]['_data'][]=$v;
            }
        }
        return json($newdata);
    }

    /**
     * 获取首页表单
     * @param Request $request
     */
    public function getallfrom(Request $request){
        $data=Db::name('category')->alias('c')
            ->join('allmess a','c.cid=a.cid')
            ->order(['c.sort'=>'desc','c.cid','a.asort'=>'desc','a.id'])
            ->field('c.cid,c.cname,a.name,a.sta')
            ->select();
        $newData=[];
        foreach($data as $k=>$v){
            if(!isset($newData[$v['cid']])){
                $newData[$v['cid']]=$v;
            }
            $newData[$v['cid']]['_data'][]=$v;
        }
//        dump($data);
        return json($newData);
    }

    public function getallfroms(Request $request){
        $data=Db::name('category')->alias('c')
            ->join('allmess a','c.cid=a.cid')
            ->order(['c.sort'=>'desc','c.cid','a.asort'=>'desc','a.id'])
            ->select();
        $newData=[];
        foreach($data as $k=>$v){
            if($v['pid']==0){
                $newData[$v['cid']]['cid']=$v['cid'];
                $newData[$v['cid']]['cname']=$v['cname'];
                $newData[$v['cid']]['sta']=$v['sta'];
                $newData[$v['cid']]['_data'][$v['id']]=$v;
            }else{
                $newData[$v['cid']]['_data'][$v['pid']]['_data'][]=$v;
            }
        }
        return json($newData);
    }

    /**
     * 获取分类轮播图
     * @param Request $request
     *
     * @return \think\response\Json
     */
    public function getLunbo(Request $request){
        $cid=$request->param('sid');
        $data=Cateban::where('cid',$cid)->order('sort desc')->select();
        return json($data);
    }
}
