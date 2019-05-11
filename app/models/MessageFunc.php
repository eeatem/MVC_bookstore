<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-11
 * Time: 13:20
 * Func: 存放静态方法(与信息表有关)
 */

namespace app\models;

use core\base\Model;

class messageFunc extends Model
{
    //  选择信息表
    protected $table = 't_message';

    // 在数据库中插入申请结果站内信
    public function addApplicationResultMessage($applicationId, $resultId, $managerNameSession)
    {
        // 获取申请人id和申请内容
        $applicationUserId  = (new ApplicationModel())->gainUserIdByApplicationId($applicationId);
        $applicationContent = (new ApplicationModel())->gainContentByApplicationId($applicationId);
        // 判断申请结果
        if ($resultId == '1') {
            $result = '成功';
        } else if ($resultId == '0') {
            $result = '失败';
        }
        // 获取管理员id
        $managerId = (new userFunc())->gainUserId($managerNameSession);
        // 站内信字段
        $data['sender_id']   = $managerId;
        $data['receiver_id'] = $applicationUserId;
        $data['create_time'] = date("Y-m-d H:i:s");
        if ($applicationContent == '申请成为商家' || $applicationContent == '申请开店') {
            $data['content'] = $applicationContent . $result;
        } else if ($applicationContent == '申请上架书籍') {
            // 获取申请信息书籍名称
            $bookName=(new ApplicationModel())->gainBookDataByApplicationId($applicationId,'book_title');
            $data['content'] = '书籍：'.'《'.$bookName.'》'.'申请上架'. $result;
        }
        $addResult = (new messageFunc())->add($data);

        return $addResult;
    }
}