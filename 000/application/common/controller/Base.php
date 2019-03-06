<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/1/5
 * Time : 15:07
 * Email: 417780879@qq.com
 */
namespace app\common\controller;
use app\common\Predis;
use think\Controller;
use think\facade\Request;

header("Content-type: text/html; charset=utf-8");
//如果需要设置允许所有域名发起的跨域请求，可以使用通配符 *
header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求
header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With,X-TOKEN,*');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE');

class Base extends Controller
{
//    protected $middleware = ['Hearders' => ['except' => ['home']]];
    protected static function UserMess(){
        $data=Request::param();
        return json_decode(Predis::getInstance()->get($data['hearders']['X-Token']),JSON_UNESCAPED_UNICODE);
    }
}