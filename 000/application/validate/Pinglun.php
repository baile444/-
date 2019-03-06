<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/22
 * Time : 17:37
 * Email: 417780879@qq.com
 */
namespace app\validate;
class Pinglun extends BaseValidate
{
    protected $rule = [
        'content' => 'require',
        'gid' => 'require',
        'orid' => 'require',
    ];

    protected $message= [
        'content.require'=> '评论内容不能为空',
        'gid.require'=> '未选择商品',
        'orid.require'=> '未选择订单',
    ];
}