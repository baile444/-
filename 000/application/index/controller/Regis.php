<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/9
 * Time : 16:48
 * Email: 417780879@qq.com
 */
namespace app\index\controller;
use app\common\controller\Base;
use app\common\Pcode;
use app\common\Predis;
use app\common\snowFlake\Idcreate;
use app\common\Token;
use think\facade\Log;
use think\Request;

class Regis extends Base
{
    protected $middleware = ['HearderOption'];
    //wechat appid
    protected $wxAppid="wx17d8a5f7f8636621";
    //wechat appsecret
    protected $wxAppSecret="7a6e889e7908eb9ff9eeb68b7587bb67";
    protected $kfappid='wx40e68662383447b6';
    protected $kfAppSecret='15c5efb19d3553f245d4e6e64e6a35e5';
    private static $count=0;
    public function index(Request $request)
    {
        $data = $request -> param();
    }

    /**
     * 获取验证码
     * @param Request $request
     *
     * @return \think\response\Json
     */
    public function getCode(Request $request)
    {
        $phone=$request->param('phone');
        $result=$this->validate(['phone'=>$phone],'app\index\validate\Regis.getcode');
        if(true !== $result){
            // 验证失败 输出错误信息
            return json(['valid'=>0,'msg'=>$result]);
        }
        $phonemess=json_decode(Predis::getInstance()->get($phone),256);
        if(!$phonemess||$phonemess['time']+180<time()){
            $code=(new Pcode())->getCode($phone);
//            $code=1111;
            if($code==false){
                return json(['valid'=>0,'msg'=>'验证码发送失败','time'=>0]);
            }
            $phonemess=['code'=>$code,'time'=>time()];
            Predis::getInstance()->set($phone,json_encode($phonemess,JSON_UNESCAPED_UNICODE));
        }else{
            $time=time()-$phonemess['time'];
            $time=$time>60?180-$time:60;
            return json(['valid'=>1,'msg'=>$phonemess['code'],'time'=>$time]);
        }
        return json(['valid'=>1,'msg'=>$phonemess['code'],'time'=>60]);
    }

    public function validcode(Request $request){
        $data=$request->param();
        $phonemess=json_decode(Predis::getInstance()->get($data['phone']),256);
        if($data['code'] == $phonemess['code']){
            return 1;
        } else{
            return 0;
        }
    }

    /**用户注册
     * @param Request $request
     *
     * @return \think\response\Json
     */
    public function regis(Request $request){
        $data=$request->param();
//        Predis::getInstance()->set('17601237922',json_encode(['code'=>1111,'time'=>time()],JSON_UNESCAPED_UNICODE));die;
        $result=$this->validate($data,'app\index\validate\Regis.regis');
        if(true !== $result){
            // 验证失败 输出错误信息
            return json(['valid'=>0,'msg'=>$result]);
        }

        $phonemess=json_decode(Predis::getInstance()->get($data['phone']),JSON_UNESCAPED_UNICODE);
        if(!$phonemess||$phonemess['time']+120<time()||$data['code']!=$phonemess['code']){
            return json(['valid'=>0,'msg'=>'验证码不正确或已过期']);
        }

        $isin=\app\index\model\Regis::where('phone',$data['phone'])->select();
        $isin=current($isin);
        if($isin){
            return json(['valid'=>2,'msg'=>'该手机已经注册，若遗失密码，可以手机验证登录']);
        }

        $data['password']=md5($data['password']);

        if($data['beto']){
            $lv=(new \app\index\model\Regis())->where('user_id',$data['beto'])->value('lv');
            if($lv==1){
                $data['onebelongto']=$data['beto'];
                $data['belongto']=$data['beto'];
                $data['pid']=$data['beto'];
            }else{
                $data['onebelongto']=$data['beto'];
                $data['pid']=$data['beto'];
            }
        }

        $res=(new \app\index\model\Regis())->regis($data);
        if($res){
            return json(['valid'=>1,'msg'=>'注册成功']);
        }
        return json(['valid'=>0,'msg'=>'失败，请重新注册']);
    }

    /**账号密码登录
     * @param Request $request
     *
     * @return \think\response\Json
     */
    public function accountlogin(Request $request,\app\index\model\Regis $regis){
        $data=$request->param();
        $result=$this->validate($data,'app\index\validate\Regis.accountlogin');
        if(true !== $result){
            // 验证失败 输出错误信息
            return json(['valid'=>0,'msg'=>$result]);
        }
        $res=$regis->where('phone',$data['phone'])->where('password',md5($data['password']))->select()->toArray();
        $res=current($res);
        if($res){
            $token=(new Token())->getToken($res['phone'].$res['user_id']);
            Predis::getInstance()->set($token,json_encode($res,JSON_UNESCAPED_UNICODE));
            Predis::getInstance()->expire($token,7200);
            return json(['valid'=>1,'msg'=>'登录成功','token'=>$token,'userid'=>$res['user_id'],'user_name'=>$res['user_name'],'user_img'=>$res['user_img'],'apayname'=>$res['apayname'],'apay'=>$res['apay'],'wechat'=>$res['wechat']]);
        }
        return json(['valid'=>0,'msg'=>'账号或密码不正确']);
    }

    /**验证码登录
     * @param Request $request
     *
     * @return \think\response\Json
     */
    public function codelogin(Request $request){
        $data=$request->param();
        $result=$this->validate($data,'app\index\validate\Regis.codelogin');
        if(true !== $result){
            // 验证失败 输出错误信息
            return json(['valid'=>0,'msg'=>$result]);
        }

        $phonemess=json_decode(Predis::getInstance()->get($data['phone']),JSON_UNESCAPED_UNICODE);
        if(!$phonemess||$phonemess['time']+120<time()||$data['code']!=$phonemess['code']){
            return json(['valid'=>0,'msg'=>'验证码不正确或已过期']);
        }

        $res=\app\index\model\Regis::where('phone',$data['phone'])->select()->toArray();
        $res=current($res);

        if(!$res){
            //不存在，注册
            //有推荐人时
            if($data['beto']){
                $lv=(new \app\index\model\Regis())->where('user_id',$data['beto'])->value('lv');
                if($lv==1){
                    $data['onebelongto']=$data['beto'];
                    $data['belongto']=$data['beto'];
                    $data['pid']=$data['beto'];
                }else{
                    $data['onebelongto']=$data['beto'];
                    $data['pid']=$data['beto'];
                }
            }
            $num=(new \app\index\model\Regis())->regis($data);
            if(!$num){
                return json(['valid'=>0,'msg'=>'登录失败，请重试']);
            }
            $res=\app\index\model\Regis::where('phone',$data['phone'])->find()->toArray();
        }
        $token=(new Token())->getToken($res['phone'].$res['user_id']);
        Predis::getInstance()->set($token,json_encode($res,JSON_UNESCAPED_UNICODE));
        Predis::getInstance()->expire($token,7200);
        return json(['valid'=>1,'msg'=>'登录成功','token'=>$token,'userid'=>$res['user_id'],'user_name'=>$res['user_name'],'user_img'=>$res['user_img'],'apayname'=>$res['apayname'],'apay'=>$res['apay'],'wechat'=>$res['wechat']]);
    }

    //微信绑定手机号，未注册
    public function wechatbind(Request $request){
        $data=$request->param();
        $result=$this->validate($data,'app\index\validate\Regis.codelogin');
        if(true !== $result){
            // 验证失败 输出错误信息
            return json(['valid'=>0,'msg'=>$result]);
        }

        $phonemess=json_decode(Predis::getInstance()->get($data['phone']),JSON_UNESCAPED_UNICODE);
        if(!$phonemess||$phonemess['time']+120<time()||$data['code']!=$phonemess['code']){
            return json(['valid'=>0,'msg'=>'验证码不正确或已过期']);
        }

        $res=\app\index\model\Regis::where('phone',$data['phone'])->select()->toArray();
        $res=current($res);
        $uninoidData=json_decode(Predis::getInstance()->get('unionid'.$data['unionid']),256);
        if(!$res){
            if(isset($data['beto'])){
                $lv=(new \app\index\model\Regis())->where('user_id',$data['beto'])->value('lv');
                if($lv==1){
                    $data['onebelongto']=$data['beto'];
                    $data['belongto']=$data['beto'];
                    $data['pid']=$data['beto'];
                }else{
                    $data['onebelongto']=$data['beto'];
                    $data['pid']=$data['beto'];
                }
            }
            $data['wechat']=$uninoidData['unionid'];
            $data['user_img']=$uninoidData['headimgurl'];
            $data['user_name']=$uninoidData['nickname'];

            $num=(new \app\index\model\Regis())->regis($data);
            if(!$num){
                return json(['valid'=>0,'msg'=>'登录失败，请重试']);
            }
            $res=\app\index\model\Regis::where('phone',$data['phone'])->find()->toArray();
        }else{
            $updata=[
                'user_id'=>$res['user_id'],
                'wechat'=>$uninoidData['unionid'],
                'user_img'=>$uninoidData['headimgurl'],
                'user_name'=>$uninoidData['nickname'],
            ];
            (new \app\index\model\Regis())->editMess($updata);
        }
        $token=(new Token())->getToken($res['phone'].$res['user_id']);
        Predis::getInstance()->set($token,json_encode($res,JSON_UNESCAPED_UNICODE));
        Predis::getInstance()->expire($token,7200);
        return json(['valid'=>1,'msg'=>'登录成功','token'=>$token,'userid'=>$res['user_id'],'user_name'=>$res['user_name'],'user_img'=>$res['user_img'],'apayname'=>$res['apayname'],'apay'=>$res['apay'],'wechat'=>$res['wechat']]);
    }

    /**
     * 手机授权获取微信 unionid
     * @param Request $request
     *
     * @return float|int 存储标识 unionid + 雪花算法唯一id 返回唯一id
     */
    public function getUnionid(Request $request,\app\index\model\Regis $regis){
        $data=$request->param();
        $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->wxAppid.'&secret='.$this->wxAppSecret.'&code='.$data['code'].'&grant_type=authorization_code';
        $res=file_get_contents($url);

        $coderes=json_decode($res,256);
        if(isset($coderes['access_token'])){
            $userdata=$regis->where('wechat',$coderes['unionid'])->select()->toArray();
            $userdata=current($userdata);
            if($userdata){
                $token=(new Token())->getToken($userdata['phone'].$userdata['user_id']);
                Predis::getInstance()->set($token,json_encode($userdata,JSON_UNESCAPED_UNICODE));
                Predis::getInstance()->expire($token,7200);
                return json(['valid'=>1,'msg'=>'登录成功','token'=>$token,'userid'=>$userdata['user_id'],'phone'=>$userdata['phone'],'user_name'=>$userdata['user_name'],'user_img'=>$userdata['user_img'],'apayname'=>$userdata['apayname'],'apay'=>$userdata['apay'],'wechat'=>$userdata['wechat']]);
            }
            $userinfoData=file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$coderes['access_token'].'&openid='.$coderes['openid'].'&lang=zh_CN');
            $onlyid=Idcreate::createOnlyId();
            $unionid='unionid'.$onlyid;
            Predis::getInstance()->set($unionid,$userinfoData);
            Predis::getInstance()->expire($unionid,6000);
            return json(['valid'=>$onlyid]);
        }else{
            Log::write($res,'wechat');
            return json(['valid'=>0]);
        }
    }

    /**
     * pc授权获取微信 unionid
     * @param Request $request
     *
     * @return float|int 存储标识 unionid + 雪花算法唯一id 返回唯一id
     */
    public function getpcUnionid(Request $request,\app\index\model\Regis $regis){
        $data=$request->param();
        $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->kfappid.'&secret='.$this->kfAppSecret.'&code='.$data['code'].'&grant_type=authorization_code';
        $res=file_get_contents($url);

        $coderes=json_decode($res,256);
        if(isset($coderes['access_token'])){
            $userdata=$regis->where('wechat',$coderes['unionid'])->select()->toArray();
            $userdata=current($userdata);
            if($userdata){
                $token=(new Token())->getToken($userdata['phone'].$userdata['user_id']);
                Predis::getInstance()->set($token,json_encode($userdata,JSON_UNESCAPED_UNICODE));
                Predis::getInstance()->expire($token,7200);
                return json(['valid'=>1,'msg'=>'登录成功','token'=>$token,'userid'=>$userdata['user_id'],'phone'=>$userdata['phone'],'user_name'=>$userdata['user_name'],'user_img'=>$userdata['user_img'],'wechat'=>$userdata['wechat']]);
            }
            $userinfoData=file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$coderes['access_token'].'&openid='.$coderes['openid'].'&lang=zh_CN');
            $onlyid=Idcreate::createOnlyId();
            $unionid='unionid'.$onlyid;
            Predis::getInstance()->set($unionid,$userinfoData);
            Predis::getInstance()->expire($unionid,6000);
            return json(['valid'=>$onlyid]);
        }else{
            Log::write($res,'wechat');
            return json(['valid'=>0]);
        }
    }

    /**
     * 已登录用户绑定微信
     * @param Request                $request
     * @param \app\index\model\Regis $regis
     *
     * @return \think\response\Json
     */
    public function bindWechat(Request $request,\app\index\model\Regis $regis){
        $data=$request->param();
        $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->wxAppid.'&secret='.$this->wxAppSecret.'&code='.$data['code'].'&grant_type=authorization_code';
        $res = file_get_contents($url);
        Log::write($res,'wechat');
        if(isset($coderes['access_token'])){
            Predis::getInstance()->set($data['code'],$res);
            Predis::getInstance()->expire($data['code'],6000);
        }
        $res=Predis::getInstance()->get($data['code']);
        $coderes=json_decode($res,256);
        return $res;
//        if(isset($coderes['access_token'])){
//            $userinfoData=file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$coderes['access_token'].'&openid='.$coderes['openid'].'&lang=zh_CN');
//            $userinfoData=json_decode($userinfoData,true);
//
//            $token=$request->param('hearders')['X-Token'];
//            $userData=Predis::getInstance()->get($token);
//            $userData=json_decode($userData,true);
//
//            $updata=[
//                'user_id'=>$userData['user_id'],
//                'wechat'=>$userinfoData['unionid'],
//                'user_img'=>$userinfoData['headimgurl'],
//                'user_name'=>$userinfoData['nickname']
//            ];
//
//            return json($updata);
//            $regis->editMess($updata);
//            $userData['wechat']=$userinfoData['unionid'];
//            Predis::getInstance()->set($token, json_encode($userData,true));
//            Predis::getInstance()->expire($token,7200);
//            return json(['valid'=>1]);
//        }else{
//            Log::write($res,'wechat');
//            return json(['valid'=>0,'msg'=>'绑定失败']);
//        }
    }

    public function aaa(){
        Predis::getInstance()->set('17601237921',json_encode(['code'=>1111,'time'=>time()],JSON_UNESCAPED_UNICODE));die;
    }


    public function regissss()
    {
        $headers = [];
        foreach($_SERVER as $name => $value) {
            if(substr($name,0,5) == 'HTTP_') {
                $headers[str_replace(' ','-',ucwords(strtolower(str_replace('_',' ',substr($name,5)))))] = $value;
            }
        }
        dump($headers);
    }
}