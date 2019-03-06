<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/12/5
 * Time : 15:14
 * Email: 417780879@qq.com
 */
namespace app\wechat\controller;
use app\common\Predis;
use think\facade\Log;

class Token extends Config
{
    //获取微信token
    public function getAccessToken(){
        $access_token=Predis::getInstance()->get('all_access_token');
        if(!$access_token){
            $access_token=$this->curl_get_https("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->wxAppid."&secret=".$this->wxAppSecret);
            if(isset($access_token['access_token'])){
                Predis::getInstance()->set('all_access_token',$access_token['access_token']);
                Predis::getInstance()->expire('all_access_token',6000);
            }
            Log::write($access_token,'wechat');
        }
        return $access_token;
    }

    /**curl 请求
     * @param $url
     *
     * @return mixed
     */
    public function curl_get_https($url){
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
        $tmpInfo = curl_exec($curl);     //返回api的json对象
        $tmpInfo=json_decode($tmpInfo,true);
        //关闭URL请求
        curl_close($curl);
        return $tmpInfo;    //返回json对象
    }
}