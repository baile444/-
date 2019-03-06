<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/22
 * Time : 17:37
 * Email: 417780879@qq.com
 */
namespace app\validate;
class Text extends BaseValidate
{
    protected $rule = [
        'id' => 'require',
        'idss' => 'require',
    ];

    protected $message= [
        'id.require'=>'不能为空'
    ];
}