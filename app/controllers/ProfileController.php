<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-06
 * Time: 01:10
 */

namespace app\controllers;

use app\models\userFunc;
use core\base\Controller;
use app\models\ProfileModel;

session_start();
// error_reporting(0);
// require '/usr/local/var/www/bookstore/app/models/UserFunc.php.php ProfileController extends Controller
class ProfileController extends Controller
{
    public function index()
    {
        $this->assign('title', '个人资料');
        $this->render();
    }

    // 编辑个人资料
    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // 检测用户是否选择了出生年月
            if ($_POST['birthdayYear'] == '' || $_POST['birthdayMonth'] == '') {
                $birthdayError = '*请选择出生年月';
            } else {
                $birthdayError = '';
            }
            // 检测用户是否选择了所在区域
            if ($_POST['location'] == '') {
                $locationError = '*请选择所在区域';
            } else {
                $locationError = '';
            }
            // 检测用户是否正确输入了验证码
            $checkCodeError = (new ProfileModel())->isCheckCodeCorrect(trim($_POST['checkCode']));
            // 判断用户能否进行个人资料修改
            if ($birthdayError == '' && $locationError == '' && $checkCodeError == '') {
                $isCanEdit = true;
            } else {
                $isCanEdit = false;
            }
            if ($isCanEdit == true) {
                $editResult = (new ProfileModel())->editIntroduce($_SESSION['userName'], $_POST['birthdayYear'], $_POST['birthdayMonth'],
                    $_POST['location'], $_POST['introduce']);
            }
        }
        // echo (new userFunc())->gainUserId($_SESSION['userName']);

        $this->assign('birthdayError', $birthdayError);
        $this->assign('locationError', $locationError);
        $this->assign('checkCodeError', $checkCodeError);
        $this->assign('editResult', $editResult);
        $this->assign('title', '编辑个人资料');
        $this->render();
    }

    // 查看个人资料
    public function show()
    {
        $email=(new userFunc())->gainUserData($_SESSION['userName'],'email');
        $birthdayYear=(new ProfileModel())->gainProfileData($_SESSION['userName'],'birthday_year');
        $birthdayMonth=(new ProfileModel())->gainProfileData($_SESSION['userName'],'birthday_month');
        $location=(new ProfileModel())->gainProfileData($_SESSION['userName'],'location');
        $introduce=(new ProfileModel())->gainProfileData($_SESSION['userName'],'introduce');
        $level=(new userFunc())->gainUserData($_SESSION['userName'],'level');
        $registerTime=(new userFunc())->gainUserData($_SESSION['userName'],'register_time');

        $this->assign('email',$email);
        $this->assign('birthdayYear',$birthdayYear);
        $this->assign('birthdayMonth',$birthdayMonth);
        $this->assign('location',$location);
        $this->assign('introduce',$introduce);
        $this->assign('level',$level);
        $this->assign('registerTime',$registerTime);
        $this->assign('title','查看个人资料');
        $this->render();
    }

}