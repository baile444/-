<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/16
 * Time : 10:09
 * Email: 417780879@qq.com
 */
namespace app\common;

use think\facade\Log;

class Pcode
{
    public static $_instance = [];
    private $config=[
        'length'    =>4,
        //手机验证码地址
        'https'     => 'https://sh2.ipyy.com/sms.aspx',
        'action'    => 'send',
        //用户名
        'userid'    => 'dn44',
        //发送密码
        'password'  => 'dn4455',
        //发送内容
        'content'   => ['上海当日企服提醒：您的验证码','，在1分钟内有效，如非本人操作请忽略本短信。【上海当日企服】'],
        'sendTime'  => '',
        'extno'     => ''
    ];
    public function getCode($phone){
        if(empty(self::$_instance)){
            self::$_instance=$this->config;
        }else{
            self::$_instance=array_merge($this->config,self::$_instance);
        }
        return $this->get(self::$_instance,$phone);
    }
    private function get($config,$phone){
        $rand = '';
        for($i = 0; $i < $config['length']; $i ++) {
            $rand .= rand(0,9);
        }
        $num     = file_get_contents($config['https']."?action=".$config['action']."&userid=".$config['userid']."&account=".$config['userid']."&password=".$config['password']."&mobile=" . $phone . "&content=".$config['content'][0] . $rand . $config['content'][1]."&sendTime=".$config['sendTime']."&extno=".$config['extno']);
        $xml = simplexml_load_string($num);
        $arr = json_decode(json_encode($xml),true);
        Log::write($num,'code');
        if($arr['message']=='操作成功'){
            return $rand;
        }else{
            return false;
        }
    }
}