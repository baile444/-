<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/20
 * Time : 11:29
 * Email: 417780879@qq.com
 */
namespace app\index\controller;
use app\admin\model\Jifen;
use app\common\controller\Base;
use app\common\Predis;
use think\Db;
use think\facade\Log;
use think\Request;

class User extends Base
{
    protected $middleware = ['Hearders'];

    //wechat appid
    protected $wxAppid="wx17d8a5f7f8636621";
    //wechat appsecret
    protected $wxAppSecret="7a6e889e7908eb9ff9eeb68b7587bb67";

    public function getuser(Request $request){
        $data=$request->hearders;
        $mess=json_decode(Predis::getInstance()->get($data['X-Token']),JSON_UNESCAPED_UNICODE);
        return json(['valid'=>1,'phone'=>$mess['phone'],'userid'=>$mess['user_id'],'user_name'=>$mess['user_name'],'user_img'=>$mess['user_img'],'wechat'=>$mess['wechat'],'apayname'=>$mess['apayname'],'apay'=>$mess['apay']]);
    }

    public function getjifen(\app\index\model\Regis $regis,Jifen $jifen){
        $userData=$regis->getUserMessage(self::UserMess()['user_id']);
        $jifenBi=$jifen->getBili();
        $userData['jifenbi']=$jifenBi;
        return json($userData);
    }

    /**
     * 提现申请
     * @param \app\index\model\Regis   $regis
     * @param \app\index\model\Getmess $getmess
     *
     * @return int|\think\response\Json
     */
    public function getmoney(\app\index\model\Regis $regis,\app\index\model\Getmess $getmess){
        $userData=$regis->getUserMessage(self::UserMess()['user_id']);
        if($userData['money']<0.01){
            return json(['valid'=>0]);
        }
        $userupload=[
            'user_id'=>$userData['user_id'],
            'money'=>0
        ];
        $getmessdata=[
            'can_content'=>'申请提现',
            'can_money'=>'-'.$userData['money'],
            'user_id'=>$userData['user_id'],
            'can_sta'=>0
        ];
        Db::startTrans();
        try {
            $regis->store($userupload);
            $getmess->add($getmessdata);
            // 提交事务
            Db::commit();
            return 1;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return 0;
        }
    }

    /**
     * 修改用户名
     * @param Request                $request
     * @param \app\index\model\Regis $regis
     *
     * @return \think\response\Json
     */
    public function username(Request $request,\app\index\model\Regis $regis){
        $data=$request->param('username');
        $token=$request->hearders;
        if(mb_strlen($data)<1||mb_strlen($data)>20){
            return json(['valid'=>0,'msg'=>'命名不符合规定']);
        }
        $updata=[
            'user_id'=>self::UserMess()['user_id'],
            'user_name'=>$data
        ];
        $res=$regis->editname($updata);
        if(!$res){
            return json(['valid'=>0,'msg'=>'修改失败']);
        }
        $mess=json_decode(Predis::getInstance()->get($token['X-Token']),JSON_UNESCAPED_UNICODE);
        $mess['user_name']=$data;
        $mess=json_encode($mess,256);
        Predis::getInstance()->set($token['X-Token'], $mess);
        return json(['valid'=>1,'msg'=>'修改成功']);
    }

    /**
     * pc修改用户资料
     * @param Request                $request
     * @param \app\index\model\Regis $regis
     *
     * @return \think\response\Json
     */
    public function userallmess(Request $request,\app\index\model\Regis $regis){
        $data=$request->param();
        $token=$request->hearders;
        if(mb_strlen($data['username'])<1||mb_strlen($data['username'])>20){
            return json(['valid'=>0,'msg'=>'命名不符合规定']);
        }
        $updata=[
            'user_id'=>self::UserMess()['user_id'],
            'user_name'=>$data['username'],
            'apayname'=>$data['apayname'],
            'apay'=>$data['apay']
        ];
        $res=$regis->editname($updata);
        if(!$res){
            return json(['valid'=>0,'msg'=>'修改失败']);
        }
        $mess=json_decode(Predis::getInstance()->get($token['X-Token']),JSON_UNESCAPED_UNICODE);
        $mess['user_name']=$data['username'];
        $mess['apayname']=$data['apayname'];
        $mess['apayname']=$data['apayname'];
        $mess['apay']=$data['apay'];
        $mess=json_encode($mess,256);
        Predis::getInstance()->set($token['X-Token'], $mess);
        return json(['valid'=>1,'msg'=>'修改成功']);
    }

    /**
     * 解绑微信
     * @param Request                $request
     * @param \app\index\model\Regis $regis
     *
     * @return \think\response\Json
     */
    public function removeWechats(Request $request,\app\index\model\Regis $regis){
        $res=$regis->editwechat(['user_id'=>self::UserMess()['user_id'],'wechat'=>'']);
        if($res){
            $token=$request->param('hearders')['X-Token'];
            $userData=Predis::getInstance()->get($token);
            $userData=json_decode($userData,true);
            $userData['wechat']='';
            Predis::getInstance()->set($token, json_encode($userData,true));
            Predis::getInstance()->expire($token,7200);
            return json(['valid'=>1,'msg'=>'解绑成功']);
        }
        return json(['valid'=>0,'msg'=>'解绑失败']);
    }

    /**
     * 修改密码
     * @param Request                $request
     * @param \app\index\model\Regis $regis
     *
     * @return \think\response\Json
     */
    public function passwords(Request $request,\app\index\model\Regis $regis){
        $data=$request->param();
        if(mb_strlen($data['password'])<6||mb_strlen($data['password'])>20){
            return json(['valid'=>0,'msg'=>'密码不可少于6位']);
        }
        $result=$this->validate($data,'app\index\validate\Regis.editpassword');
        if(true !== $result){
            // 验证失败 输出错误信息
            return json(['valid'=>0,'msg'=>$result]);
        }
        $data['password']=md5($data['password']);
        $data['user_id']=self::UserMess()['user_id'];
        $res=$regis->editpassword($data);
        if(!$res){
            return json(['valid'=>0,'msg'=>'修改密码失败']);
        }
        return json(['valid'=>1,'msg'=>'修改成功']);
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
        $coderes=json_decode($res,256);
        if(isset($coderes['access_token'])){
            $userinfoData=file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$coderes['access_token'].'&openid='.$coderes['openid'].'&lang=zh_CN');
            $userinfoData=json_decode($userinfoData,true);

            $token=$request->param('hearders')['X-Token'];
            $userData=Predis::getInstance()->get($token);
            $userData=json_decode($userData,true);

            $updata=[
                'user_id'=>$userData['user_id'],
                'wechat'=>$userinfoData['unionid'],
                'user_img'=>$userinfoData['headimgurl'],
                'user_name'=>$userinfoData['nickname']
            ];

            $regis->editMess($updata);
            $userData['wechat']=$userinfoData['unionid'];
            Predis::getInstance()->set($token, json_encode($userData,true));
            Predis::getInstance()->expire($token,7200);
            return json(['valid'=>1]);
        }else{
            Log::write($res,'wechat');
            return json(['valid'=>0,'msg'=>'绑定失败']);
        }
    }
}