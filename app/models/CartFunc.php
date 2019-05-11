<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-10
 * Time: 23:44
 * Func: 存放静态方法(与购物车表有关)
 */

namespace app\models;

use core\base\Model;

class cartFunc extends Model
{
    // 选择购物车表
    protected $table = 't_cart';

    // 根据用户id返回购物车商品详情字段
    public function gainCartGoodByUserId($userId)
    {
        $rows = (new cartFunc())->where(["user_id = '$userId'"])->fetchAll();

        return $rows;
    }
}