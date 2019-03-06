<?php

namespace app\admin\model;
use app\common\model\Common;
use think\captcha\Captcha;
use think\facade\Session;

class Login extends Common
{
	protected $pk='userId';
	protected $table='hcj_admin_user';

   /**
	* 后台登录
	* @param $data
	* @return array
	*/
	public function login($data){
	   if (!$data['userName']||!$data['userPwd']||!$data['code']){return ['valid'=>0,'msg'=>'请输入账号密码验证码'];}
	   $data['userPwd']=md5($data['userPwd']);
	   $res=$this->check_verify($data['code']);
	   if (!$res){
	      return ['valid'=>0,'msg'=>'验证码错误，请重新输入'];
	   }
	   $res=$this->where('userName',$data['userName'])->where('userPwd',$data['userPwd'])->select();
        if (isset($res[0]['userId'])){
            Session::set('hcj_admin_user.userId',$res[0]['userId']);
	      return ['valid'=>1,'msg'=>'登录成功'];
	   }else{
		  return ['valid'=>0,'msg'=>'账号或密码错误'];
	   }
	}

   /**
	* 验证码验证
	* @param $code
	* @param string $id
	* @return bool
	*/
	protected function check_verify($code, $userId = ''){
	   $captcha = new Captcha();
	   return $captcha->check($code, $userId);
	}

   /**
	* 修改密码
	* @param $data
	* @return array
	*/
	public function editpass($data){
	   if (!$data['name']||!$data['password']||!$data['newpassword']||!$data['againpassword']){return ['valid'=>0,'msg'=>'请输入账号密码'];}
	   $data['password']=md5($data['password']);
	   $res=$this->where('name',$data['name'])->where('password',$data['password'])->select();
	   if ($res){
		  if ($data['newpassword']==$data['againpassword']){
			 $newpass=md5($data['againpassword']);
			 $res=$this->allowField(['password'])->save(['password'=>$newpass],['id'=>$res[0]['id']]);
			 if ($res){
				return ['valid'=>1,'msg'=>'修改密码成功，请重新登录'];
			 }else{
				return ['valid'=>0,'msg'=>'密码修改失败，请重新操作'];
			 }
		  }else{
			 return ['valid'=>0,'msg'=>'两次输入的密码不一致'];
		  }
	   }else{
		  return ['valid'=>0,'msg'=>'账号或密码错误'];
	   }
	}
}