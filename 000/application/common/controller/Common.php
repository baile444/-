<?php
namespace app\common\controller;
use app\admin\model\Login;
use Predis\Client;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use think\Controller;
use think\Request;
use think\facade\Session;
header("Content-Type: text/html; charset=UTF-8");
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/29
 * Time: 14:08
 */
class Common extends Controller
{
    //登录标识
    protected $adminid;
    //添加、编辑后跳转地址
    protected $url;
    //实例化模型
    protected $model;
    //实例化模型
    protected $modelTwo;

    protected $redis;

    public function initialize()
    {
        parent ::initialize();
        //        $this->redis=new Client();
        $this -> adminid = Session::get('admin.id');
        if (!$this -> adminid) {
            $this -> redirect('admin/login/index');
        }
        $adminDate = Login ::get($this -> adminid) -> visible(['id', 'name']) -> toArray();
        $this -> assign('adminDate', $adminDate);
    }
    public function out(Request $request){
        if ($request->isAjax()){
            Session::delete('admin.id');
            return 1;
        }
    }
    /**
     * 判断跳转
     * @param $res 执行操作后返回的数组
     * @param $url 跳转的地址
     */
    public function return_res($res, $url)
    {
        if ($res['valid'] == 1) {
            echo "<script>alert('" . $res['msg'] . "');location.href='" . $url . "'</script>";
            exit;
        } else {
            echo "<script>alert('" . $res['msg'] . "');history.go(-1)</script>";
            exit;
        }
    }

    /**
     * 删除
     * @param $res
     * @param $url
     */
    public function return_del($res, $url,$pic='')
    {
        if ($res >= 1) {
            if (!empty($pic)&&is_file($pic)){
                unlink($pic);
            }
            echo "<script>alert('删除成功');location.href='" . $url . "'</script>";
            exit;
        } else {
            echo "<script>alert('删除失败');history.go(-1)</script>";
            exit;
        }
    }

    /**
     *删除
     * @param        $res
     * @param        $url
     * @param string $pic
     */
    public function delmess($res, $url,$pic='')
    {
        if ($res >= 1) {
            if (!empty($pic)&&is_file($pic)){
                unlink($pic);
            }
            echo "<script>location.href='" . $url . "'</script>";
            exit;
        } else {
            echo "<script>alert('删除失败');history.go(-1)</script>";
            exit;
        }
    }
    /**
     * 图片上传
     */
    public function uploadss(Request $request)
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file=$request->file();
        $file = current($file);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file -> validate(['size' => 1024000, 'ext' => 'jpg,png,jpeg,gif']) -> move('../public/uploads');
        if ($info) {
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            $picpath=str_replace('\\','/',$info -> getSaveName());
            $res = ['valid' => 1, 'msg' => $picpath];
            echo json_encode($res);
        } else {
            // 上传失败获取错误信息
            echo $file -> getError();
        }
    }
    public function uploads(Request $request){
        $file=$request->file();
        $file = current($file);
        $file=$file->getInfo();
        $name=$request->param('name');
        $filepath=$file['tmp_name'];
        $key=$name.'_'.time().rand(1,1000).mb_strstr($file['name'],'.');
        return json($this->qiniuUpload($key,$filepath));
    }

    private function qiniuUpload($key,$filePath){
        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = self::uploadment()->putFile(self::qiniuToken(), $key, $filePath);
        if ($err !== null) {
            return ['valid' => 0, 'msg' => '上传失败'];
        } else {
            return ['valid' => 1, 'msg' => $key];
        }
    }
    private static function uploadment(){
        $uploadMgr = new UploadManager();
        return $uploadMgr;
    }

    private static function qiniuToken(){
        $ak='QaFdu71LhHCMcG0n8xfi14_K9qTrZcvCQxSIGKw1';
        $sk='MW-AP9YTw2nXMCgX8dSdW6KVb_txoTdt_zmXWavh';
        $bucket = 'qyfw24';
        $auth=new Auth($ak,$sk);
        $token = $auth->uploadToken($bucket);
        return $token;
    }

    /**
     * 删除图片
     * @param Request $request
     */
    public function delimg(Request $request)
    {
        if ($request -> isAjax()) {
            $path = $request -> param('path');
            if($path){
                unlink(APP_PATH.'/uploads/'.$path);
                return 1;
            }
            return 2;
        }
    }
}