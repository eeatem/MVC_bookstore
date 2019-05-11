<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-06
 * Time: 22:37
 */

namespace app\controllers;

use app\models\userFunc;
use core\base\Controller;
use app\models\ChangeModel;

session_start();

class ChangeController extends Controller
{
    // 主页
    public function index()
    {
        $this->assign('title', '修改用户名/密码');
        $this->render();
    }

    // 修改用户名
    public function userName()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // 检测用户名是否能够使用
            if ($_POST['userName'] == $_SESSION['userName']) {
                $userNameError = '*请勿输入当前用户名';
            } else {
                $userNameError = (new userFunc())->isUserNameLegal($_POST['userName']);
            }
            // 检测两次用户名输入是否一致
            if ($userNameError == '') {
                $userNameConfirmError = (new ChangeModel())->isUserNameSame($_POST['userName'], $_POST['userNameConfirm']);
            }
            // 修改数据库中的用户名
            if ($userNameError == '' && $userNameConfirmError == '') {
                $changeResult = (new ChangeModel())->updateUserName($_SESSION['userName'], $_POST['userName']);
            }
        }

        $this->assign('userNameError', $userNameError);
        $this->assign('userNameConfirmError', $userNameConfirmError);
        $this->assign('changeResult', $changeResult);
        $this->assign('title', '修改用户名');
        $this->render();
    }

    // 修改密码
    public function password()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // 检测用户输入的新密码是否合法
            $passwordError = (new userFunc())->isPasswordLegal($_POST['password']);
            // 检测两次密码输入是否一致
            if ($passwordError == '') {
                $passwordConfirmError = (new userFunc())->isPasswordSame($_POST['password'], $_POST['passwordConfirm']);
            }
            if ($passwordError == '' && $passwordConfirmError == '') {
                $changeResult = (new ChangeModel())->updatePassword($_SESSION['userName'], $_POST['password']);
            }

        }

        $this->assign('passwordError', $passwordError);
        $this->assign('passwordConfirmError', $passwordConfirmError);
        $this->assign('changeResult', $changeResult);
        $this->assign('title', '修改密码');
        $this->render();
    }

    // 验证密保问题
    public function check()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $answerError = (new ChangeModel())->isAnswerCorrect($_SESSION['userName'], $_POST['answer']);
            if ($answerError == '') {
                $isCanChangePassword = true;
            }
        }

        $this->assign('answerError', $answerError);
        $this->assign('isCanChangePassword', $isCanChangePassword);
        $this->assign('title', '验证密保问题');
        $this->render();
    }
}