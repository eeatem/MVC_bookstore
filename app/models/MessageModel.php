<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-11
 * Time: 13:18
 */

namespace app\models;

use core\base\Model;

session_start();

class MessageModel extends Model
{
    //  选择信息表
    protected $table = 't_message';

    // 查询登陆用户的站内信
    public function showMessage($userNameSession)
    {
        // 获取登陆用户id
        $userId=(new userFunc())->gainUserId($userNameSession);
        // 获取站内信字段
        $rows=(new MessageModel())->where(["receiver_id = '$userId'"])->order(['id DESC'])->fetchAll();

        return $rows;
    }

    // 修改站内信状态未已读
    public function changeMessageStatus($messageId){
        $data['status']='1';
        $changeResult=(new MessageModel())->where(["id = '$messageId'"])->update($data);

        return $changeResult;
    }
}