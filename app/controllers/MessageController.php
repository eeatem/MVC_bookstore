<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-11
 * Time: 13:22
 */

namespace app\controllers;

use core\base\Controller;
use app\models\MessageModel;

session_start();

class MessageController extends Controller
{
    // 查看站内信
    public function index()
    {
        $rows = (new MessageModel())->showMessage($_SESSION['userName']);

        $this->assign('rows', $rows);
        $this->assign('title', '站内信');
        $this->render();
    }

    // 站内信详情
    public function detail($messageId)
    {
        $row=(new MessageModel())->where(["id = '$messageId'"])->fetch();
        $changeResult=(new MessageModel())->changeMessageStatus($messageId);

        $this->assign('row',$row);
        $this->assign('changeResult',$changeResult);
        $this->assign('title','站内信详情');
        $this->render();
    }
}