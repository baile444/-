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

class Ordercode
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
        'content'   => '上海当日企服提醒：您有新的订单。【上海当日企服】',
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
        $num     = file_get_contents($config['https']."?action=".$config['action']."&userid=".$config['userid']."&account=".$config['userid']."&password=".$config['password']."&mobile=" . $phone . "&content=".$config['content']."&sendTime=".$config['sendTime']."&extno=".$config['extno']);
    }
}