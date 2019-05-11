<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-04
 * Time: 23:33
 * Func: 存放静态方法(与用户表有关)
 */

namespace app\models;

use core\base\Model;

class userFunc extends Model
{
    // 检测输入内容是否存在空格
    function isExitSpace($data)
    {
        if (preg_match('/\s/', $data)) {
            return true;
        } else {
            return false;
        }
    }

    // 检测用户是否已经登陆，并返回错误信息
    function isUserLogin($userNameSession, $error, $file)
    {
        if (empty($userNameSession)) {
            echo "<span class='error'>" . $error . "</span>";
            echo "<a href='$file'><input type='button' value='登陆'></a>";
            die;
        }
    }

    // 检测用户名是否合法
    function isUserNameLegal($userName)
    {
        if (empty($userName)) {
            $userNameError = '*请输入用户名';
        } else if (!preg_match("/^[a-zA-Z][a-zA-Z0-9_]{3,9}$/", $userName)) {
            $userNameError = '*用户名必须以字母开头，仅包含字母、数字、下划线，限制长度4-10位';
        } else {
            $userNameError = '';
        }

        return $userNameError;
    }

    // 检测密码是否合法
    function isPasswordLegal($password)
    {
        if (empty($password)) {
            $passwordError = '*请输入密码';
        } else if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,14}$/", $password)) {
            $passwordError = '*密码必须包含大小写字母和数字，不能使用特殊字符，限制长度6-14位';
        } else {
            $passwordError = '';
        }

        return $passwordError;
    }

    // 检测两次密码输入是否一致
    function isPasswordSame($password, $passwordConfirm)
    {
        if ($passwordConfirm != $password) {
            $passwordSameError = '*两次密码输入不一致，请重新输入';
        } else {
            $passwordSameError = '';
        }

        return $passwordSameError;
    }

    // 选择用户表
    protected $table = 't_user';

    // 获取数据库用户表中的用户id
    function gainUserId($userName)
    {
        $row    = (new userFunc())->where(["user_name = '$userName'"])->fetch();
        $userId = $row['id'];

        return $userId;
    }

    // 通过用户id获取用户名
    function gainUserNameById($userId)
    {
        $row = (new userFunc())->where(["id = '$userId'"])->fetch();
        $userName = $row['user_name'];

        return $userName;
    }

    // 获取数据库用户表字段中的内容
    function gainUserData($userName, $dataName)
    {
        $row  = (new userFunc())->where(["user_name = '$userName'"])->fetch();
        $data = $row[$dataName];
        // 获取用户登陆权限
        if ($dataName == 'level') {
            $data = $row['level'];
            if ($data == '0') {
                $data = '普通用户';
            }
            if ($data == '1') {
                $data = '商家';
            }
            if ($data == '2') {
                $data = '管理员';
            }
        }
        // 计算用户注册时长
        if ($dataName == 'register_time') {
            $data = $row['register_time'];
            // 获取当前日期
            $time = date('Y-m-d');
            $data = strtotime($time) - strtotime($data);
            $data /= 3600 * 24;
        }

        return $data;
    }

    // 申请成为商家/开店页面中检测用户是否为普通用户/商家
    function checkIsOrdinaryOrTrader($userName, $level, $error)
    {
        $row = (new userFunc)->where(["user_name = '$userName'"])->fetch();
        if ($row['level'] != $level) {
            echo "<span class='error'>$error</span>";
            die;
        }
    }

    // 检测用户权限
    function checkUserLevel($userName)
    {
        $row    = (new userFunc())->where(["user_name = '$userName'"])->fetch();
        $level  = $row['level'];

        return $level;
    }

    // 修改用户权限
    function updateUserLevel($userName,$newLevel){
        $data['level']=$newLevel;
        $updateResult=(new userFunc())->where(["user_name = '$userName'"])->update($data);

        return $updateResult;
    }

}