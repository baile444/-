<?php

namespace app\index\validate;

use think\Validate;

class Regis extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'phone'=> 'require|number|length:11',
        'code'=>'require|number',
        'password'=>'require',
        'repassword'=>'require|confirm:password',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'phone.require'=>'手机号不能为空',
        'phone.number'=>'手机号格式不正确',
        'phone.length'=>'手机号格式不正确',
        'code.require'=>'验证码不能为空',
        'code.length'=>'验证码不正确',
        'password.require'=>'密码不能为空',
        'repassword.require'=>'确定密码不能为空',
        'repassword.confirm'=>'密码不一致',
    ];

    protected $scene = [
        'regis'  =>  ['phone','code','password','repassword'],
        'accountlogin'=>['phone','password'],
        'codelogin'=>['phone','code'],
        'getcode'=>['phone'],
        'editpassword'=>['password','repassword']
    ];
}
