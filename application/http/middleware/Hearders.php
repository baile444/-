<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/7
 * Time : 14:38
 * Email: 417780879@qq.com
 */
namespace app\http\middleware;

use app\common\Predis;
use think\Response;

class Hearders
{
    public function handle($request,\Closure $next)
    {
        $request -> hearders = $this -> getHearders();
        if(!$this->validtoken($request -> hearders)){
            return response('对不起访问错误');
        }
        if (strtoupper($request->method()) == "OPTIONS") {
            return Response::create()->send();
        }

        return $next($request);
    }

    //获取头部信息
    private function getHearders()
    {
        $headers = [];
        foreach($_SERVER as $name => $value) {
            if(substr($name,0,5) == 'HTTP_') {
                $headers[str_replace(' ','-',ucwords(strtolower(str_replace('_',' ',substr($name,5)))))] = $value;
            }
        }
        return $headers;
    }

    private function validtoken($headers){
        if(!isset($headers['X-Token'])){
            return false;
        }
        $res=Predis::getInstance()->get($headers['X-Token']);
        if(!$res){
            return false;
        }
        Predis::getInstance()->expire($headers['X-Token'],7200);
        return true;
    }
}