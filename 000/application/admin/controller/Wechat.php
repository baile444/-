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
use app\wechat\controller\Token;
use think\Db;
use think\Request;

class Wechat extends Common
{
    protected $token;
    public function initialize()
    {
        parent ::initialize();
        $this->token=(new Token())->getAccessToken();
        $this->model=new \app\admin\model\Wechat();
        $this->url=url('admin/wechat/index');
    }
    public function index(Request $request){
        return view();
    }
    public function getverson(){
        $data=Db::name('wechat_mess')->column('sta');
        return $data;
    }
    public function getorder(){
        $data=Db::name('wechat_order')->where('id',1)->value('content');
        return $data;
    }

    public function setorder(Request $request){
        if($request->isAjax()){
            $data=$request->param();
            $newData['button']=$data['button'];
            $newData=json_encode($newData,256);
            $urls='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->token;
            $res=$this->curl_get_https_data($urls,$newData);
            if($res['errmsg']=='ok'){
                Db::name('wechat_order')->update(['content' => $data['oldbutton'],'id'=>1]);
                return 1;
            }
            return 0;
        }
    }

    public function curl_get_https_data($url,$data){
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        $tmpInfo = curl_exec($curl);     //返回api的json对象
        if (curl_errno($curl)) {
            return 'Errno'.curl_error($curl);
        }
        $tmpInfo=json_decode($tmpInfo,true);
        //关闭URL请求
        curl_close($curl);
        return $tmpInfo;    //返回json对象
    }

    public function getData($data){
        $order=[];
        if($data['one_name']){
            $order['button'][0]=['name'=>$data['one_name']];
            if($data['one_url']){
                $order['button'][0]['url']=$data['one_url'];
                $order['button'][0]['type']='view';
            }else{
                foreach($data['one_two_name'] as $k=>$v){
                    if($v){
                        $order['button'][0]['sub_button'][]=[
                            'type'=>'view',
                            'name'=>$v,
                            'url'=>$data['one_two_url'][$k],
                        ];
                    }
                }
            }
        }
        if($data['two_name']){
            $order['button'][1]=['name'=>$data['two_name']];
            if($data['two_url']){
                $order['button'][1]['url']=$data['two_url'];
                $order['button'][1]['type']='view';
            }else{
                foreach($data['two_two_name'] as $k=>$v){
                    if($v){
                        $order['button'][1]['sub_button'][]=[
                            'type'=>'view',
                            'name'=>$v,
                            'url'=>$data['two_two_url'][$k],
                        ];
                    }
                }
            }
        }
	   if($data['three_name']){
            $order['button'][2]=['name'=>$data['three_name']];
            if($data['three_url']){
                $order['button'][2]['url']=$data['three_url'];
                $order['button'][2]['type']='view';
            }else{
                foreach($data['three_two_name'] as $k=>$v){
                    if($v){
                        $order['button'][2]['sub_button'][]=[
                            'type'=>'view',
                            'name'=>$v,
                            'url'=>$data['three_two_url'][$k],
                        ];
                    }
                }
            }
        }
        return $order;
    }
}