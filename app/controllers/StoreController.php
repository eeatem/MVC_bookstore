<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-09
 * Time: 02:37
 */

namespace app\controllers;

use app\models\bookFunc;
use app\models\userFunc;
use core\base\Controller;
use app\models\StoreModel;

session_start();

class StoreController extends Controller
{
    // 显示店铺选择
    public function index()
    {
        $rows = (new StoreModel())->fetchAll();

        $this->assign('rows', $rows);
        $this->assign('title', '进入店铺');
        $this->render();
    }

    // 显示店铺中已上架的书籍
    public function book($traderUserId)
    {
        $rows = (new bookFunc())->listBook($traderUserId);

        $this->assign('rows', $rows);
        $this->assign('title', '选择书籍');
        $this->render();
    }

    // 店铺书籍管理
    public function manage()
    {
        // 获取登陆商家id
        $userId=(new userFunc())->gainUserId($_SESSION['userName']);
        $rows=(new bookFunc())->listBook($userId);

        $this->assign('rows',$rows);
        $this->assign('title','书籍管理');
        $this->render();
    }

}