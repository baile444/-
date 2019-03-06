<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/6/29
 * Time : 15:37
 * Email: 417780879@qq.com
 */
namespace app\common\phpmail;
use think\Request;

class Demo
{
    public function mail(Request $request){
        if($request->isPost()){
            $smtpserver = "ssl://smtp.qq.com";//SMTP服务器
            $smtpserverport =465;//SMTP服务器端口  25被屏蔽，用465，阿里云需要开启端口
            $smtpusermail = "417780879@qq.com";//SMTP服务器的用户邮箱
            $smtpuser = "417780879@qq.com";//SMTP服务器的用户帐号，注：部分邮箱只需@前面的用户名
            $smtppass = "gdafpmxwsejxbjaf";//SMTP服务器的用户密码qfnojrhtquvwbjfg
            //	$mailtitle = $_POST['title'];//邮件主题
            $mailtitle =  "=?utf-8?B?" . base64_encode($_POST['title']) . "?=";//邮件主题
            $mailcontent = $_POST['content'];//邮件内容
            $smtpemailto = $_POST['toemail'];//发送给谁
            $mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
            //************************ 配置信息 ****************************
            $smtp = new Smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
            $smtp->debug = false;//是否显示发送的调试信息
            $state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
            if($state==""){
                echo "对不起，邮件发送失败！请检查邮箱填写是否有误。";
                echo "<a href='cateindex.html'>点此返回</a>";
                exit();
            }
            echo "恭喜！邮件发送成功！！";
            echo "<a href='cateindex.html'>点此返回</a>";
            echo "</div>";
        }
    }
}