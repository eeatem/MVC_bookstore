<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-10
 * Time: 23:11
 * Func: 存放静态方法(与订单商品表有关)
 */

namespace app\models;

use core\base\Model;

class orderGoodsFunc extends Model
{
    // 选择订单商品表
    protected $table = 't_order_goods';

    // 插入订单商品信息
    public function addOrderGood($orderId,$goodId,$goodNumber,$goodPrice){
        $data['order_id']         = $orderId;
        $data['good_id']          = $goodId;
        $data['good_number']      = $goodNumber;
        $data['good_total_price'] = $goodPrice * $goodNumber;
        $addResult=(new orderGoodsFunc())->add($data);

        return $addResult;
    }

    // 根据订单编号返回商品信息
    public function showGoodsByOrderId($orderId){
        $rows=(new orderGoodsFunc())->where(["order_id = '$orderId'"])->fetchAll();

        return $rows;
    }
}