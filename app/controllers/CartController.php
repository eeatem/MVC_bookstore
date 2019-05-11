<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-10
 * Time: 02:01
 */

namespace app\controllers;

use app\models\bookFunc;
use app\models\userFunc;
use core\base\Controller;
use app\models\CartModel;

session_start();

class CartController extends Controller
{
    // 购物车
    public function index()
    {
        // 获取用户id
        $userId = (new userFunc())->gainUserId($_SESSION['userName']);
        // 查询该用户加入购物车的所有书籍
        $rows = (new CartModel())->where(["user_id = '$userId'"])->fetchAll();

        $this->assign('rows', $rows);
        $this->assign('title', '购物车');
        $this->render();
    }

    // 添加商品到购物车
    public function addGood($goodId)
    {
        $storeId   = (new bookFunc())->gainDataByBookId($goodId, 'user_id');
        $addResult = (new CartModel())->addGoodToCart($_SESSION['userName'], $goodId);

        $this->assign('addResult', $addResult);
        $this->assign('storeId', $storeId);
        $this->assign('title', '添加商品');
        $this->render();
    }

    // 购物车中商品数量加1
    public function increase($cartId)
    {
        $increaseResult = (new CartModel())->increaseGoodNumber($cartId);

        $this->assign('increaseResult', $increaseResult);
        $this->assign('title', '增加商品数量');
        $this->render();
    }

    // 购物车中商品数量减1
    public function decrease($cartId)
    {
        $decreaseResult = (new CartModel())->decreaseGoodNumber($cartId);

        $this->assign('decreaseResult', $decreaseResult);
        $this->assign('title', '减少商品数量');
        $this->render();
    }
}