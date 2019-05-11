<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-06
 * Time: 01:10
 */

namespace app\models;

use core\base\Model;

class ProfileModel extends Model
{
    // 选择数据库中的个人资料表
    protected $table = 't_introduce';

    /*
     *
     * <--------------------------------------编辑个人资料页面-------------------------------------->
     *
     */

    // 在数据库中执行个人资料修改信息
    public function editIntroduce($userName, $birthdayYear, $birthdayMonth, $location, $introduce)
    {
        // 获取用户id
        $userId = (new userFunc())->gainUserId($userName);
        // 查询数据库是否已经存在个人资料数据
        $row = (new ProfileModel())->where(["user_id = '$userId'"])->fetch();
        // 获取用户填写的个人资料信息
        $data['birthday_year']  = $birthdayYear;
        $data['birthday_month'] = $birthdayMonth;
        $data['location']       = $location;
        $data['introduce']      = $introduce;
        if ($row == false) {
            // 若数据库中不存在个人资料数据，则插入
            $data['user_id'] = $userId;
            $editResult      = (new ProfileModel())->add($data);
        } else {
            // 若数据库中已存在个人资料数据，则更新
            $editResult = (new ProfileModel())->where(["user_id = '$userId'"])->update($data);
        }

        return $editResult;
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
     * <--------------------------------------显示个人资料页面-------------------------------------->
     *
     */

    // 获取数据库个人资料表各字段中的内容
    public function gainProfileData($userName, $dataName)
    {
        // 获取用户id
        $userId = (new userFunc())->gainUserId($userName);
        // 获取个人资料信息
        $row=(new ProfileModel())->where(["user_id = '$userId'"])->fetch();
        $data   = $row[$dataName];

        return $data;
    }
}