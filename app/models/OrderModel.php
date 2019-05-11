<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-10
 * Time: 19:25
 */

namespace app\models;

use core\base\Model;

session_start();

class OrderModel extends Model
{
    // 选择订单表
    protected $table = 't_order';

    // 检测提交订单页面用户输入的收货人姓名是否合法
    public function isConsigneeNameLegal($consigneeName)
    {
        if (empty(trim($consigneeName))) {
            $consigneeNameError = '*请输入收货人姓名';
        } else if (strlen($consigneeName) > 30) {
            $consigneeNameError = '*限制最多输入10个汉字';
        } else {
            $consigneeNameError = '';
        }

        return $consigneeNameError;
    }

    // 检测提交订单页面用户输入的收货人手机号码是否合法
    public function isConsigneeContactLegal($consigneeContact)
    {
        if (empty($consigneeContact)) {
            $consigneeContactError = '*请输入收货人手机号码';
        } else if ((new userFunc())->isExitSpace($consigneeContact)) {
            $consigneeContactError = '*请勿输入空格';
            // 判断（中国）手机号码格式是否正确
        } else if (!preg_match('/^(13[0-9]|14[0-9]|15[0-9]|16[0-9]|17[0-9]|18[0-9]|19[0-9])\d{8}$/', $consigneeContact)) {
            $consigneeContactError = '*请输入正确的手机号码';
        } else {
            $consigneeContactError = '';
        }

        return $consigneeContactError;
    }

    // 检测提交订单页面用户输入的收货人地址是否合法
    public function isConsigneeAddressLegal($consigneeAddress)
    {
        if (empty(trim($consigneeAddress))) {
            $consigneeAddressError = '*请输入收货人地址';
        } else if (strlen($consigneeAddress) > 150) {
            $consigneeAddressError = '*限制最多输入50个汉字';
        } else {
            $consigneeAddressError = '';
        }

        return $consigneeAddressError;
    }

    // 在数据库中插入订单信息
    public function addOrder($userNameSession, $consigneeName, $consigneeContact, $consigneeAddress)
    {
        // 获取用户id
        $userId      = (new userFunc())->gainUserId($userNameSession);
        $time        = date("YmdHis");
        $orderNumber = $userId . $time;
        // 订单信息字段
        $data['order_number']      = $orderNumber;
        $data['buyer_id']          = $userId;
        $data['create_time']       = date("Y-m-d H:i:s");
        $data['total_price']       = $_SESSION['totalPrice'];
        $data['consignee_name']    = $consigneeName;
        $data['consignee_contact'] = $consigneeContact;
        $data['consignee_address'] = $consigneeAddress;
        $addResult                 = (new OrderModel())->add($data);
        // 查询订单号
        $row1    = (new OrderModel())->where(["order_number = '$orderNumber'"])->fetch();
        $orderId = $row1['id'];
        // 订单商品信息字段
        $rows = (new cartFunc())->gainCartGoodByUserId($userId);
        foreach ($rows as $row) {
            $goodPrice = (new bookFunc())->gainDataByBookId($row['good_id'], 'price');
            $addResult = (new orderGoodsFunc())->addOrderGood($orderId, $row['good_id'], $row['good_number'], $goodPrice);
        }

        return $addResult;
    }

    // 查看订单
    public function showOrder($userName)
    {
        // 获取用户id
        $userId = (new userFunc())->gainUserId($userName);
        // 查询数据库中的订单信息
        $rows = (new OrderModel())->where(["buyer_id = '$userId'"])->fetchAll();

        return $rows;
    }

    // 查看订单详情
    public function showOrderDetail($orderId)
    {
        // 获取该订单的商品信息
        $rows=(new orderGoodsFunc())->showGoodsByOrderId($orderId);

        return $rows;
    }
}