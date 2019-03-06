<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/22
 * Time : 16:25
 * Email: 417780879@qq.com
 */
namespace app\index\controller;
use app\common\controller\Base;
use \app\validate\Addresss as Vaddress;
use think\Request;

class Addresss extends Base
{
    protected $middleware = ['Hearders'];

    /**获取所有地址
     * @param Request                   $request
     * @param \app\index\model\Addresss $model
     *
     * @return \think\response\Json
     */
    public function getaddress(Request $request,\app\index\model\Addresss $model){
        $olddata=$model->where('user_id',self::UserMess()['user_id'])->select()->toArray();
        $data=[];
        foreach($olddata as $k=>$v){
            $v['aphone']=substr($v['aphone'],0,3).'****'.substr($v['aphone'],-4);
            $v['address_before']=json_decode($v['address_before'],JSON_UNESCAPED_UNICODE);
            $v['address_before']=$v['address_before']['province'].$v['address_before']['city'].$v['address_before']['area'];
            $data[]=$v;
        }
        return json($data);
    }

    /**添加地址
     * @param Request                   $request
     * @param Vaddress                  $vaddress
     * @param \app\index\model\Addresss $model
     *
     * @return \think\response\Json
     */
    public function addaddress(Request $request,Vaddress $vaddress,\app\index\model\Addresss $model){
        $data=$request->param();
        $vaddress->goCheck($data);
        $data['user_id']=self::UserMess()['user_id'];
        $model->add($data);
        return json(['valid'=>1,'msg'=>'添加成功']);
    }

    /**获取地址信息
     * @param Request                   $request
     * @param \app\index\model\Addresss $model
     *
     * @return \think\response\Json
     */
    public function editaddress(Request $request, \app\index\model\Addresss $model){
        $aid=$request->param('aid');
        if(!$aid){return json(['valid'=>0,'msg'=>'错误']);}
        $data=$model->where('user_id',self::UserMess()['user_id'])->find($aid)->toArray();
        $data['address_before']=json_decode($data['address_before'],JSON_UNESCAPED_UNICODE);
        return json($data);
    }

    /**获取默认地址
     * @param \app\index\model\Addresss $model
     *
     * @return \think\response\Json
     */
    public function getdefault(Request $request,\app\index\model\Addresss $model){
        $aid=$request->param('aid');
        if($aid){
            $data=$model->where('user_id',self::UserMess()['user_id'])->where('aid',$aid)->find();
        }else{
            $data=$model->where('user_id',self::UserMess()['user_id'])->order('aid desc')->limit(1)->select()->toArray();
            $data=current($data);
        }
        if(isset($data['aphone'])){
            $data['aphone']=substr($data['aphone'],0,3).'****'.substr($data['aphone'],-4);
            $data['address_before']=json_decode($data['address_before'],JSON_UNESCAPED_UNICODE);
            $data['address_before']=$data['address_before']['province'].$data['address_before']['city'].$data['address_before']['area'];
        }
        return json($data);
    }

    /**编辑地址
     * @param Request                   $request
     * @param Vaddress                  $vaddress
     * @param \app\index\model\Addresss $model
     *
     * @return \think\response\Json
     */
    public function toeditaddress(Request $request,Vaddress $vaddress,\app\index\model\Addresss $model){
        $data=$request->param();
        $vaddress->goCheck($data);
        $data['user_id']=self::UserMess()['user_id'];
        $model->edit($data);
        return json(['valid'=>1,'msg'=>'编辑成功']);
    }

    /**删除地址
     * @param Request                   $request
     * @param \app\index\model\Addresss $model
     *
     * @return \think\response\Json
     */
    public function deladdress(Request $request,\app\index\model\Addresss $model){
        $aid=$request->param('aid');
        if(!$aid){
            return json(['valid'=>0,'msg'=>'错误']);
        }
        $model->del($aid);
        return json(['valid'=>1,'msg'=>'删除成功']);
    }
}