<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-06
 * Time: 22:34
 */

namespace app\models;

use core\base\Model;

class ChangeModel extends Model
{
    // 检测两次密码输入是否一致
    public function isUserNameSame($userName, $userNameConfirm)
    {
        if ($userNameConfirm != $userName) {
            $userNameSameError = '*两次用户名输入不一致，请重新输入';
        } else {
            $userNameSameError = '';
        }

        return $userNameSameError;
    }

    // 选择用户表
    protected $table = 't_user';

    // 更新数据库用户表中的用户名数据
    public function updateUserName($userName, $newUserName)
    {
        $data['user_name'] = $newUserName;
        $changeResult=(new ChangeModel())->where(["user_name = '$userName'"])->update($data);
        // 查询用户名是否修改成功
        // $changeResult=(new ChangeModel())->where(["user_name = '$newUserName'"])->fetch();

        return $changeResult;
    }

    // 检测用户是否通过修改密码验证
    public function isCanChangePassword($session)
    {
        if ($session!=true) {
            echo "<span class='error'>尚未通过验证，无法修改密码！</span>";
            die;
        }
    }

    // 更新数据库用户表中的密码数据
    public function updatePassword($userName, $password)
    {
        $data['password']=md5($password);
        $changeResult=(new ChangeModel())->where(["user_name = '$userName'"])->update($data);

        return $changeResult;
    }

    // 验证密保是否输入正确
    public function isAnswerCorrect($userName, $answer)
    {
        // 获取数据库中的密保问题答案
        $row=(new ChangeModel())->where(["user_name = '$userName'"])->fetch();
        $row['answer'];
        // 进行判断
        if ($answer == '') {
            $answerError = '*请输入密保问题答案';
        } else if ((new userFunc)->isExitSpace($answer)) {
            $answerError = '*请勿输入空格';
        } else if ($answer != $row['answer']) {
            $answerError = '*密保问题答案错误，请重新输入';
        } else {
            $answerError = '';
        }

        return $answerError;
    }
}