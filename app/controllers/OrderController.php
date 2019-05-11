<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-10
 * Time: 19:25
 */

namespace app\controllers;

use app\models\userFunc;
use core\base\Controller;
use app\models\OrderModel;

session_start();

class OrderController extends Controller
{
    // 查看订单
    public function index()
    {
        $rows=(new OrderModel())->showOrder($_SESSION['userName']);

        $this->assign('rows',$rows);
        $this->assign('title','查看订单');
        $this->render();
    }

    // 查看订单详情
    public function detail($orderId){
        // 订单信息
        $row1=(new OrderModel())->where(["id = '$orderId'"])->fetch();
        // 订单商品信息
        $row2=(new OrderModel())->showOrderDetail($orderId);

        $this->assign('row1',$row1);
        $this->assign('row2',$row2);
        $this->assign('title','订单详情');
        $this->render();
    }

    // 提交订单
    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $consigneeNameError    = (new OrderModel())->isConsigneeNameLegal($_POST['consigneeName']);
            $consigneeContactError = (new OrderModel())->isConsigneeContactLegal($_POST['consigneeContact']);
            $consigneeAddressError = (new OrderModel())->isConsigneeAddressLegal($_POST['consigneeAddress']);
            if ($consigneeNameError == '' && $consigneeContactError == '' && $consigneeAddressError == '') {
                $addResult = (new OrderModel())->addOrder($_SESSION['userName'], $_POST['consigneeName'], $_POST['consigneeContact'],
                    trim($_POST['consigneeAddress']));
            }
        }
        // 获取用户id
        $userId=(new userFunc())->gainUserId($_SESSION['userName']);

        $this->assign('consigneeNameError', $consigneeNameError);
        $this->assign('consigneeContactError', $consigneeContactError);
        $this->assign('consigneeAddressError', $consigneeAddressError);
        $this->assign('addResult',$addResult);
        $this->assign('userId',$userId);
        $this->assign('title', '提交订单');
        $this->render();
    }
}