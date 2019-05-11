<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-08
 * Time: 02:34
 * Func: 存放静态方法(与店铺表有关)
 */

namespace app\models;

use core\base\Model;

class storeFunc extends Model
{
    // 选择店铺表
    protected $table = 't_store';

    // 在数据库插入开店信息
    public function addStore($userId)
    {
        $data['user_id']     = $userId;
        $data['create_time'] = date("Y-m-d H:i:s");
        $addResult           = (new storeFunc())->add($data);

        return $addResult;
    }

    // 查询商家是否已经开店
    public function isTraderHasStore($userNameSession)
    {
        // 获取商家id
        $userId=(new userFunc())->gainUserId($userNameSession);
        $result=(new storeFunc())->where(["user_id = '$userId'"])->fetch();

        return $result;
    }
}