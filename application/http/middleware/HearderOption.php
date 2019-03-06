<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/7
 * Time : 14:38
 * Email: 417780879@qq.com
 */
namespace app\http\middleware;
use think\Response;

class HearderOption
{
    public function handle($request,\Closure $next)
    {
        $request -> hearders = $this -> getHearders();
        if (strtoupper($request->method()) == "OPTIONS") {
            return response('0000');
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
}