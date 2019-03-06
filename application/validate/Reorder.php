<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/22
 * Time : 17:37
 * Email: 417780879@qq.com
 */
namespace app\validate;
class Reorder extends BaseValidate
{
    protected $rule = [
        'reason_id' => 'require|number',
        'reprice' => 'require',
        'reason' => 'require',
    ];

    protected $message= [
        'reason_id.require'=> '退款选项必须选',
        'reprice.require'=> '退款金额必须选',
        'reason.require'=> '退款理由必须填',
    ];
}