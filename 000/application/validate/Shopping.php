<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/22
 * Time : 17:37
 * Email: 417780879@qq.com
 */
namespace app\validate;
class Shopping extends BaseValidate
{
    protected $rule = [
        'gid' => 'require|number',
        'lid' => 'require|number',
        'counts' => 'require|number',
    ];

    protected $message= [
        'gid.require'=> '商品未选择',
        'gid.number'=> '商品未选择',
        'lid.require'=> '商品规格未选择',
        'lid.number'=> '商品规格未选择',
        'counts.require'=> '商品数量未选择',
        'counts.number'=> '商品数量未选择'
    ];

    protected $scene = [
        'add'  =>  ['gid','lid','counts'],
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