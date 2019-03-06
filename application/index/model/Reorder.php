<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/7/18
 * Time : 15:04
 * Email: 417780879@qq.com
 */
namespace app\index\model;
use think\Model;

class Reorder extends Model
{
    protected $table='reorder';
    protected $pk='reid';
    public function add($data){
        return $this->allowField(true)->save($data);
    }

    /**
     * 修改订单状态admin
     * @param $user_id 用户id
     * @param $orid 订单id
     * @param $sta 状态标识
     *
     * @return bool
     */
    public function adminStaEdit($reid,$sta){
        return $this->allowField('resta')->save(['resta'=>$sta],[$this->pk=>$reid]);
    }
}