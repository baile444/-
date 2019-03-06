<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/22
 * Time : 17:37
 * Email: 417780879@qq.com
 */
namespace app\validate;
class Addresss extends BaseValidate
{
    protected $rule = [
        'aname' => 'require',
        'aphone' => 'require|number|length:11',
//        'province' => 'require',
//        'city' => 'require',
//        'area' => 'require',
        'address_before' => 'checkAddress',
        'address_after' => 'require',
    ];

    protected $message= [
        'aname.require'=> '收件人名字不能为空',
        'aphone.require'=> '联系号码不能为空',
        'aphone.number'=> '联系号码不符合规定',
        'aphone.length'=> '联系号码不符合规定',
//        'province.require'=> '省份必须选择',
//        'city.require'=> '城市必须选择',
//        'area.require'=> '区域必须选择',
        'address_after.require'=> '详细地址不能为空',
    ];

    protected function checkAddress($value){
        $va=json_decode($value,JSON_UNESCAPED_UNICODE);
        $mess=['省份不能为空','城市不能为空','区域不能为空'];
        if(!isset($va['province'])||!$va['province']){
            return $mess[0];
        }
        if(!isset($va['city'])||!$va['city']){
            return $mess[1];
        }
        if(!isset($va['area'])||!$va['area']){
            return $mess[2];
        }
        return true;
    }
}