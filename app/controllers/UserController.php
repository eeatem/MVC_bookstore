<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-04
 * Time: 23:34
 * Func: 用户注册/登陆控制器
 */

namespace app\controllers;

use app\models\userFunc;
use core\base\Controller;
use app\models\UserModel;

session_start();
error_reporting(0);

class UserController extends Controller
{
    // 主页
    public function index()
    {
        $this->assign('title', '主页');
        $this->render();
    }

    // 菜单
    public function menu()
    {
        $this->assign('title','菜单');
        $this->render();
    }

    // 注册
    public function register()
    {
        // 获取用户输入表单的数据
        $userNameTemp        = $_POST['userName'];
        $emailTemp           = $_POST['email'];
        $passwordTemp        = $_POST['password'];
        $passwordConfirmTemp = $_POST['passwordConfirm'];
        $genderTemp          = $_POST['gender'];
        $questionTemp        = $_POST['question'];
        $answerTemp          = $_POST['answer'];
        $answerConfirmTemp   = $_POST['answerConfirm'];
        $checkCodeTemp       = $_POST['checkCode'];
        // 判断是否满足注册条件
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userNameError = (new userFunc())->isUserNameLegal($userNameTemp);
            if ($userNameError == '') {
                $userNameError = (new UserModel())->isUserNameExist($userNameTemp);
            }
            $emailError = (new UserModel())->isEmailLegal($emailTemp);
            if ($emailError == '') {
                $emailError = (new UserModel())->isEmailExist($emailError);
            }
            $passwordError = (new userFunc())->isPasswordLegal($passwordTemp);
            if ($passwordError == '') {
                $passwordConfirmError = (new userFunc())->isPasswordSame($passwordTemp, $passwordConfirmTemp);
            }
            $genderError        = (new UserModel())->isGenderLegal($genderTemp);
            $answerError        = (new UserModel())->isAnswerLegal($answerTemp);
            $answerConfirmError = (new UserModel())->isAnswerSame($answerTemp, $answerConfirmTemp);
            $checkCodeError     = (new UserModel())->isCheckCodeCorrect($checkCodeTemp);
            // 若满足注册条件，则将用户注册信息插入到数据库中
            if ($userNameError == '' && $emailError == '' && $passwordError == '' && $passwordConfirmError == '' && $genderError == ''
                && $genderError == '' && $answerError == '' && $answerConfirmError == '' && $checkCodeError == '') {
                $isRegisterSuccess = (new UserModel())->insertUserData($userNameTemp, $emailTemp, $passwordTemp, $genderTemp,
                    $questionTemp, $answerTemp);
            }
        }
        // 渲染注册页面
        $this->assign('userNameError', $userNameError);
        $this->assign('emailError', $emailError);
        $this->assign('passwordError', $passwordError);
        $this->assign('passwordConfirmError', $passwordConfirmError);
        $this->assign('genderError', $genderError);
        $this->assign('answerError', $answerError);
        $this->assign('answerConfirmError', $answerConfirmError);
        $this->assign('checkCodeError', $checkCodeError);
        $this->assign('isRegisterSuccess', $isRegisterSuccess);
        $this->assign('userName', $userNameTemp);
        $this->assign('title', '注册');
        $this->render();
    }

    // 登陆
    public function login()
    {
        // 获取用户输入表单的数据
        $userNameTemp  = $_POST['userName'];
        $passwordTemp  = $_POST['password'];
        $levelTemp     = $_POST['level'];
        $checkCodeTemp = $_POST['checkCode'];
        // 判断是否满足登陆条件
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userNameError = (new UserModel())->isUserNameEffective($userNameTemp);
            $userName      = (new UserModel())->gainUserName($userNameTemp);
            if ($userNameError == '') {
                $passwordError = (new UserModel())->isPasswordCorrect($userName, $passwordTemp);
            }
            $checkCodeError = (new UserModel())->isCheckCodeCorrect($checkCodeTemp);
            if ($passwordError == '' && $checkCodeError == '') {
                $levelError = (new UserModel())->isLevelLegal($userName, $levelTemp);
                if ($levelError == '') {
                    $isLoginSuccess = true;
                    // 把用户登陆的权限记录到session中
                    $_SESSION['userLevel']=$levelTemp;
                }
            }
        }
        // 渲染登陆页面
        $this->assign('userNameError', $userNameError);
        $this->assign('passwordError', $passwordError);
        $this->assign('levelError', $levelError);
        $this->assign('checkCodeError', $checkCodeError);
        $this->assign('isLoginSuccess', $isLoginSuccess);
        $this->assign('userName', $userName);
        $this->assign('title', '登陆');
        $this->render();

        if ($isLoginSuccess == true) {
            // 登陆成功后，把用户名存入session中
            $_SESSION['userName'] = $userName;
            // 用于验证密保问题
            $_SESSION['userNameTemp'] = $userName;
        }
    }

    // 注销
    public function logout()
    {
        // 清空用户登陆的session信息
        session_unset();
        session_destroy();

        $this->assign('title','注销登陆');
        $this->render();
    }

}
