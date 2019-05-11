<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-04
 * Time: 23:34
 * Func: 用户注册/登陆模型
 */

namespace app\models;

use core\base\Model;


class UserModel extends Model
{
    // 选择数据库中的用户表
    protected $table = 't_user';

    /*
     *
     * <--------------------------------------登陆页面-------------------------------------->
     *
     */

    // 检测登陆页面用户名或邮箱输入是否能够使用
    public function isUserNameEffective($userName)
    {
        // 查询数据库是否存在登陆页面输入的用户名
        $row1 = (new UserModel())->where(["user_name = '$userName'"])->fetch();
        // 查询数据库是否存在登陆页面输入的邮箱
        $row2 = (new UserModel())->where(["email = '$userName'"])->fetch();
        // 检测用户名是否为空
        if ($userName == '') {
            $userNameError = '*请输入用户名或邮箱';
        } else if ((new userFunc())->isExitSpace($userName)) {
            $userNameError = '*请勿输入空格';
        } else if ($row1 == false && $row2 == false) {
            $userNameError = "*该用户名或邮箱不存在 " . "<a href='/user/register/'>注册</a>";
        } /*
              else if (!preg_match("/^[A-Za-z0-9]+$/", $userName)) {
                $userNameError = '*请勿输入汉字、空格或其他特殊字符';
            }
            */
        else {
            $userNameError = '';
        }

        return $userNameError;
    }

    // 获取登陆页面输入的用户名（根据用户名或邮箱）
    public function gainUserName($userName)
    {
        // 查询数据库是否存在登陆页面输入的用户名
        $row1 = (new UserModel())->where(["user_name = '$userName'"])->fetch();
        // 查询数据库是否存在登陆页面输入的邮箱
        $row2 = (new UserModel())->where(["email = '$userName'"])->fetch();
        if ($row1 == true) {
            $userName = $row1['user_name'];
        } else {
            $userName = $row2['user_name'];
        }

        return $userName;
    }

    // 检测登陆页面密码输入是否正确
    public function isPasswordCorrect($userName, $password)
    {

        // 查询数据库中用户名或邮箱是否与输入的密码匹配
        $row = (new UserModel())->where(["user_name = '$userName'"])->fetch();
        // 检测密码是否为空
        if ($password == '') {
            $passwordError = '*请输入密码';
        } else if (md5($password) != $row['password']) {
            $passwordError = '*密码错误，请重新输入';
        } else {
            $passwordError = '';
        }

        return $passwordError;
    }

    // 检测登陆页面用户选择权限是否与之匹配
    public function isLevelLegal($userName, $level)
    {
        // 查询数据库中用户的权限（等级）
        $row = (new UserModel())->where(["user_name = '$userName'"])->fetch();
        if ($row['level'] == '2') {
            if ($level != $row['level']) {
                $levelError = '*请选择正确的登陆权限';
            }
        } else if ($level > $row['level']) {
            $levelError = '*请选择正确的登陆权限';
        } else {
            $levelError = '';
        }

        return $levelError;
    }

    // 检测用户是否正确输入了验证码
    public function isCheckCodeCorrect($checkCode)
    {
        if ($checkCode != $_SESSION['checkCode']) {
            $checkCodeError = '*请输入正确的验证码';
        } else {
            $checkCodeError = '';
        }

        return $checkCodeError;
    }

    /*
     *
     * <--------------------------------------注册页面-------------------------------------->
     *
     */

    // 检测用户名是否已被注册
    public function isUserNameExist($userName)
    {
        // 查询数据库的用户表中是否已经存在该用户名
        $row = (new UserModel())->where(["user_name = '$userName'"])->fetch();
        if ($row == true) {
            $userNameError = '*该用户名已被注册，请重新输入';
        } else {
            $userNameError = '';
        }

        return $userNameError;
    }

    // 检测注册邮箱是否合法
    public function isEmailLegal($email)
    {
        if (empty($email)) {
            $emailError = '*请输入常用邮箱';
        } else if ((new userFunc())->isExitSpace($email)) {
            $emailError = '*请勿输入空格';
        } else if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) {
            $emailError = '*邮箱格式错误，请输入正确的邮箱地址';
        } else {
            $emailError = '';
        }

        return $emailError;
    }

    // 检测邮箱是否已被占用
    public function isEmailExist($email)
    {
        // 查询数据库的用户表中是否已存在该邮箱
        $row = (new UserModel())->where(["email = '$email'"])->fetch();
        if ($row == true) {
            $emailError = '*该邮箱已被占用，请重新输入';
        } else {
            $emailError = '';
        }

        return $emailError;
    }

    // 检测用户是否正确选择了性别
    public function isGenderLegal($gender)
    {
        if ($gender != '男' && $gender != '女') {
            $genderError = '*请选择性别';
        } else {
            $genderError = '';
        }

        return $genderError;
    }

    // 检测用户是否输入了密保问题答案
    public function isAnswerLegal($answer)
    {
        if ($answer == '') {
            $answerError = '*请输入密码问题答案';
        } else if ((new userFunc())->isExitSpace($answer)) {
            $answerError = '*请勿输入空格';
        }
        // 限制密保问题答案输入规则（待完善）
        /* else if (!preg_match("", $answer)) {
            $answerError = '*仅包含汉字，且最多输入10个汉字';
        }
        */ else {
            $answerError = '';
        }

        return $answerError;
    }

    // 检测用户两次输入的密保问题答案是否一致
    public function isAnswerSame($answer, $answerConfirm)
    {
        if ($answerConfirm != $answer) {
            $answerSameError = '*两次答案输入不一致，请重新输入';
        } else {
            $answerSameError = '';
        }

        return $answerSameError;
    }

    // 将用户注册信息插入到数据库中
    public function insertUserData($userName, $email, $password, $gender, $question, $answer)
    {
        $data['user_name']     = $userName;
        $data['email']         = $email;
        $data['password']      = md5($password);
        $data['gender']        = $gender;
        $data['register_time'] = date("y-m-d");
        $data['question']      = $question;
        $data['answer']        = $answer;
        $insertResult          = (new UserModel())->add($data);

        return $insertResult;
    }
}

