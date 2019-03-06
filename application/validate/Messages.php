<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/22
 * Time : 17:37
 * Email: 417780879@qq.com
 */
namespace app\validate;
class Messages extends BaseValidate
{
    protected $rule = [
        'name' => 'require',
        'phone' => 'require',
        'content' => 'require'
    ];

    protected $message= [
        'name.require'=> '姓名不能为空',
        'phone.require'=> '联系号码不能为空',
        'content.require'=> '内容不能为空',
    ];
}