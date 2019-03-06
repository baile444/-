<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/7
 * Time : 16:12
 * Email: 417780879@qq.com
 */
namespace app\index\controller;
use app\admin\model\Cate;
use app\admin\model\Recommend;
use app\common\controller\Base;
use app\admin\model\Goods as Shops;
use app\common\Predis;
use think\Db;
use think\Request;

class Goods extends Base
{
    /**首页推荐商品商品信息
     * @param Request $request
     */
    public function getGoods(Request $request,Shops $shop){
        $olddata=$shop->with('level,goodspic')->field('gcontent',true)->where('re',1)->where('gsta',1)->order('gsort desc,gid desc')->select()->toArray();
        $data=[];
        foreach($olddata as $k=>$v){
            if($v['level']&&$v['goodspic']){
                $data[]=$v;
            }
        }
        return json($data);
    }

    /**pc首页推荐商品商品信息
     * @param Request $request
     */
    public function getpcGoods(Request $request,Shops $shop){
        $olddata=$shop->with('level,goodspic')->field('gcontent',true)->where('re',1)->where('gsta',1)->order('gsort desc,gid desc')->limit(5)->select()->toArray();
        $data=[];
        foreach($olddata as $k=>$v){
            if($v['level']&&$v['goodspic']){
                $data[]=$v;
            }
        }
        return json($data);
    }

    /**商品 de 分类
     * @param Request $request
     *
     * @return \think\response\Json
     */
    public function getCate(Request $request){
        $data=Cate::order('csort desc,cid')->select();
        return json($data);
    }

    /**
     * pc商城首页
     * @param Cate  $cate
     * @param Shops $shop
     *
     * @return \think\response\Json
     */
    public function pcgoods(Cate $cate,Shops $shop){
        $catedata=$cate->order('csort desc')->select();
        foreach($catedata as $k=>$v){
            $data=$shop->with('level,goodspic')->where('cid',$v['cid'])->where('gsta',1)->field('gcontent',true)->order('gid desc')->limit(5)->select();
            foreach($data as $m=>$n){
                if(isset($n['goodspic'][0]['pic'])){
                    $data[$m]['goodspics']=$n['goodspic'][0]['pic'];
                }
            }
            $catedata[$k]['_data']=$data;
        }
        return json($catedata);
    }

    /**分类商品
     * @param Request $request
     *
     * @return \think\response\Json
     */
    public function getCateGoods(Request $request,Shops $shop){
        $cid=$request->param('cid');
        if($cid==0){
            return $this->getGoods();
        }
        $data=$shop->with('level,goodspic')->where('cid',$cid)->where('gsta',1)->field('gcontent',true)->order('gid desc')->select();
//        $data=$shop::has('level')->with('level,goodspic')->where('cid',$cid)->order('gid desc')->select();
        return json($data);
    }

    /**获取单个商品信息
     * @param Request $request
     *
     * @return \think\response\Json
     */
    public function getOneGoods(Request $request){
        $data=(new Shops)->with('level,goodspic')->where('gid',$request->param('gid'))->where('gsta',1)->find();
        return json($data);
    }

    /**获取广告
     * @param Request $request
     *
     * @return \think\response\Json
     */
    public function getRecommend(Request $request,Recommend $recommend){
        $cid=$request->param('cid');
        $data=$recommend->where('typecid',$cid)->order('rsort')->select()->toArray();
        return json($data);
    }

    /**
     * 搜索
     * @param Request $request
     * @param Shops   $shop
     *
     * @return \think\response\Json
     */
    public function getSearch(Request $request,Shops $shop){
        $link=$request->param('searchvalue');
        $data=$shop->with('level,goodspic')->where('gsta',1)->whereLike('gname','%'.$link.'%')->field('gcontent',true)->order('gsort desc,gid desc')->select()->toArray();
        return json($data);
    }
}