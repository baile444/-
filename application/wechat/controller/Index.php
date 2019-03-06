<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/7/25
 * Time : 16:36
 * Email: 417780879@qq.com
 */
namespace app\wechat\controller;
use think\Controller;
use think\Db;
use think\facade\Log;

class Index extends Controller
{
    protected $wxAppid     = "wx17d8a5f7f8636621";
    protected $wxAppSecret = "7a6e889e7908eb9ff9eeb68b7587bb67";
    protected $access_token;

    public function initialize()
    {
        $this->access_token=(new Token())->getAccessToken();
    }

    public function index()
    {
        $signature = $this -> request -> param('signature');
        $timestamp = $this -> request -> param('timestamp');
        $nonce     = $this -> request -> param('nonce');
        $echostr   = $this -> request -> param('echostr');
        if(!$echostr) {
            $this -> responseMsg();
        }
        if($this -> checkSignature($signature,$timestamp,$nonce)) {
            echo $echostr;
            die;//这里特别注意，如果不用die结束程序会token验证失败
        } else {
            echo false;
        }
    }

    private function checkSignature($signature,$timestamp,$nonce)
    {
        $token  = "shanghaidangri";//这里写你在微信公众平台里面填写的token
        $tmpArr = [$token,$timestamp,$nonce];
        sort($tmpArr,SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    public function responseMsg()
    {
//        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postStr = file_get_contents("php://input");
        $result='';
        if(!empty($postStr)) {
            $postObj = simplexml_load_string($postStr,'SimpleXMLElement',LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj -> MsgType);
            switch($RX_TYPE) {
            case 'event':
                $result = $this -> receiverEvent($postObj);
                break;
            case 'text':
                $content = "您的消息已收到，稍后我们的客服会联系您";
                Log::write($postObj,'order');
                $result = $this -> transmitText($postObj,$content);
                break;
            }
            echo $result;
        } else {
            echo "";
            exit;
        }
    }

    private function receiverEvent($object)
    {
        $content    = '';
        $peoplemess = (new Wxpay())->curl_order("https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $this -> access_token . "&openid=" . $object -> FromUserName . "&lang=zh_CN");
        switch($object -> Event) {
        case "subscribe":
            // $res=Db::name('unionid')->where('unionid',$peoplemess['unionid'])->select();
            // if(!$res){Db::name('unionid')->insert(['unionid'=>$peoplemess['unionid']]);}
            $content = "您好，欢迎关注上海当日企服";
            break;
        case "unsubscribe":
            $content = "";
            Db ::name('unionid') -> where('unionid',$peoplemess['unionid']) -> delete();
            break;
        case "CLICK":
            $content = Db ::name('wechat_mess') -> where('sta',$object -> EventKey) -> value('mess');
            break;
        }
        //switch
        $result = $this -> transmitText($object,$content);
        return $result;
    }

    protected function sendClick($object,$content)
    {
        $textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[text]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            <FuncFlag>0</FuncFlag>
                            </xml>";
        $result  = sprintf($textTpl,$object -> FromUserName,$object -> ToUserName,time(),$content);
        return $result;
    }

    private function transmitText($object,$content)
    {
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";
        $result  = sprintf($textTpl,$object -> FromUserName,$object -> ToUserName,time(),$content);
        return $result;
    }

    public function curl_get_https($url)
    {
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_HEADER,1);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false); // 跳过证书检查
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);  // 从证书中检查SSL加密算法是否存在
        $tmpInfo = curl_exec($curl);     //返回api的json对象
        $tmpInfo = json_decode($tmpInfo,true);
        //关闭URL请求
        curl_close($curl);
        return $tmpInfo;    //返回json对象
    }

    //获取微信token
    public function getAccessToken(Token $wecahttoken)
    {
        $token = $wecahttoken -> getAccessToken();
        return $token;
    }

    public function login()
    {
        dump(urlencode('http://qyfw24.com'));
//        http%3A%2F%2Fqyfw24.com
//        http%3A%2F%2Fm.qyfw24.com
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx17d8a5f7f8636621&redirect_uri=http%3A%2F%2Fqyfw24.com&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
        $url=$this->curl_order($url);
        dump($url);
//        $res=(new Wxpay())->openid();
//        dump($res);
        return view();
    }

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

    public function data_to_xml($params)
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
}