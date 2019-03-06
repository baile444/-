<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/11/22
 * Time : 17:32
 * Email: 417780879@qq.com
 */
namespace app\validate;
use app\lib\exception\ParameterException;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck($data,$scene='') {
        //$result = $this->batch()->check($data);//批量
        $result = $this->scene($scene)->check($data);
        if (!$result) {
            $error = $this->getError();
            $e = new ParameterException([
                'code'=>'200',
                'msg' => $error
            ]);
            throw $e;
        } else {
            return true;
        }
    }
}