<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/19
 * Time : 18:53
 * Email: 417780879@qq.com
 */
namespace app\common;
class Token
{
    public function getToken($res){
        return md5(time().$res);
    }
}