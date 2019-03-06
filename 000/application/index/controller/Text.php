<?php
namespace app\index\controller;
use app\admin\model\Recommend;
use app\common\controller\Base;
use app\common\Pcode;
use app\common\Predis;
use app\common\snowFlake\Idcreate;
use app\wechat\controller\Wxpay;
use think\Request;

class Text extends Base
{
    public function index(Request $request)
    {
        //        $content=Predis::getInstance()->get('aa');
        //        $xml = simplexml_load_string($content);
        //        $arr = json_decode(json_encode($xml),true);
        //        dump($arr);
    }

    public function text()
    {
        $log_id=rand(10000,99999);
        $newsurl='https://xiaojiding.com/HttpService/rec_new/?name=推荐&app_id=dangriqiye&user_id=2020&size=1&log_id='.$log_id.'&res_type=news&loc_province=&loc_city=';
        $data=file_get_contents($newsurl);
        $data=json_decode($data,256);
        dump($data);
        $newcontenrurl='https://xiaojiding.com/HttpService/get_news_detail2?id='.$data['data']['data'][0]['id'].'&log_id='.$data['log_id'];
        $datas=file_get_contents($newcontenrurl);
        dump(json_decode($datas,256));
    }

    public function fei()
    {
        dump(time());
    }

    public function getfei2($num)
    {
        $arr = ['1' => 0,'2' => 1];
        for($i = 3; $i <= $num; $i ++) {
            $arr[$i] = $arr[$i - 1] + $arr[$i - 2];
        }
        return $arr[$num];
    }

    public function getfei($num)
    {
        if($num == 0) {
            return 0;
        }
        if($num < 0 && $num < 3) {
            return 1;
        }
        if($num == 4) {
            return 2;
        }
        static $no = 5;
        static $pre = 1;
        static $next = 2;
        if($num > $no) {
            $no   += 1;
            $t    = $pre;
            $pre  = $next;
            $next = $pre + $t;
            $this -> getfei($num);
        }
        return $pre + $next;
    }
}
