<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/12/6
 * Time : 10:52
 * Email: 417780879@qq.com
 */
namespace app\wechat\controller;
use app\common\Predis;
use EasyWeChat\Factory;
use think\facade\Log;

class Wxpay extends Config
{
    /**
     * 扫码付款回调地址
     */
    public function pcpayorder(){
        $config=[
            'app_id'             => $this -> wxAppid,
            'mch_id'             => $this -> mch_id,
            'key'                => $this -> key,
            'notify_url'         => $this->notify_url_h5,
//            'body'               => 'ceshi',
//            'total_fee'          => 1,
        ];
        $app = Factory::payment($config);
        $response = $app->handleScannedNotify(function ($message, $fail, $alert) use ($app) {
            $rest = json_decode(Predis::getInstance()->get($message['product_id']),256);
            $result = $app->order->unify([
                'notify_url'         => $app->config['notify_url'],
                'body'               => $rest['body'],
                'total_fee'          => $rest['money']*100,
                'trade_type' => 'NATIVE',
                'out_trade_no' => $message['product_id'],
                'product_id' => $message['product_id'],
                'openid' => $message['openid'],
                'is_subscribe' => $message['is_subscribe']
            ]);
            return $result['prepay_id'];
        });
        $response->send();
    }

    /**
     * 生成二维码
     * @param $order_id
     *
     * @return string
     */
    public function pcQrCodeUrl($res){
        $config=[
            'app_id'             => $this -> wxAppid,
            'mch_id'             => $this -> mch_id,
            'key'                => $this -> key,
        ];
        $app = Factory::payment($config);
        $content = $app->scheme($res['order_id']);
        return $content;
    }

    // jsapi
    public function payforwechat($openid = '',$out_trade_no = '',$total_fee = '',$body = '')
    {
        $config=[
            'app_id'             => $this -> wxAppid,
            'mch_id'             => $this -> mch_id,
            'key'                => $this -> key,
        ];
        $app = Factory::payment($config);
        $result = $app->order->unify([
            'body' => $body,
            'out_trade_no' => $out_trade_no,
            'total_fee' => $total_fee*100,
            'notify_url' => $this->notify_url_h5,
            'trade_type' => 'JSAPI',
            'openid' => $openid,
        ]);
        return $result;
    }

    public function getwebsing($res){
        $config=[
            'app_id'             => $this -> wxAppid,
            'mch_id'             => $this -> mch_id,
            'key'                => $this -> key,
        ];
        $payment = Factory::payment($config);
        $jssdk = $payment->jssdk;
        return $jssdk->bridgeConfig($res['prepay_id'],false);
    }

    public static function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }

    public function getordermess(){}

    /**
     * 获取网页授权用户支付openid
     * @param $data
     *
     * @return array|mixed
     */
    public function payopenid($data)
    {
        $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->wxAppid.'&secret='.$this->wxAppSecret.'&code='.$data['code'].'&grant_type=authorization_code';
        $res=file_get_contents($url);
        $coderes=json_decode($res,256);
        if(isset($coderes['access_token'])){
            $pay_token='openid'.$data['orid'];
            Predis::getInstance()->set($pay_token,$coderes['openid']);
            Predis::getInstance()->expire($pay_token,6000);
            return 1;
        }else{
            Log::write($res,'wechat');
            return 0;
        }
    }


    /**
     * 签名sign
     *
     * @param      $paramArray
     * @param bool $isencode
     *
     * @return string
     */
    protected function data_to_url($paramArray,$isencode = false)
    {
        $paramStr = '';
        ksort($paramArray);
        $i = 0;
        foreach($paramArray as $key => $value) {
            if($i == 0) {
                $paramStr .= '';
            } else {
                $paramStr .= '&';
            }
            $paramStr .= $key . '=' . ($isencode ? urlencode($value) : $value);
            ++ $i;
        }
        $stringSignTemp = $paramStr . "&key=" . $this -> key;
//        $besign=hash_hmac("sha256",$stringSignTemp,$this -> key);
        if(isset($paramArray['signType'])){
            $besign=hash_hmac("sha256",$stringSignTemp,$this -> key);
        }else{
            $besign=md5($stringSignTemp);
        }
        $sign= strtoupper($besign);
        return $sign;
    }

    /**
     * arr to xml
     *
     * @param $params
     *
     * @return bool|string
     */
    protected function data_to_xml($params)
    {
        if(!is_array($params) || count($params) <= 0) {
            return false;
        }
        $xml = "<xml>";
        foreach($params as $key => $val) {
            if(is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    /**
     * post 请求
     * @param        $url
     * @param string $data
     * @param string $method
     * @param bool   $ssl
     *
     * @return mixed
     */
    public function curl_order($url,$data='',$method='POST',$ssl = false)
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,$method);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        if($ssl) {
            curl_setopt($ch,CURLOPT_SSLCERT,$this -> sslcert_path);
            curl_setopt($ch,CURLOPT_SSLKEY,$this -> sslkey_path);
        }
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_AUTOREFERER,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result  = curl_exec($ch);
        return $result;
    }
}