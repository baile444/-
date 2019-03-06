<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/22
 * Time : 17:37
 * Email: 417780879@qq.com
 */
namespace app\validate;
class Order extends BaseValidate
{
    protected $rule = [
        'spid' => 'require|checkNum',
        'orid' => 'require|number'
    ];

    protected $message= [
        'spid.require'=> '未选择商品',
        'orid.require'=> '订单未提交',
        'orid.number'=> '订单未提交',
    ];

    protected $scene = [
        'beforeorder'  =>  ['spid'],
        'payorder'     =>  ['orid']
    ];

    protected function checkNum($value){
        if (count($value)<1){
            return '未选择商品';
        }
        foreach($value as $k=>$v){
            if(!is_numeric($v)){
                return '未选择商品';
            }
        }
        return true;
    }
}