<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-09
 * Time: 05:07
 * Func: 存放静态方法(与用户表有关)
 */

namespace app\models;

use core\base\Model;

class bookFunc extends Model
{
    // 选择书籍表
    protected $table = 't_book';

    // 在数据库中插入书籍信息
    function addBookMessage($userId, $title, $writer, $type, $introduce,$price)
    {
        $data['user_id']   = $userId;
        $data['edit_time'] = date("Y-m-d H:i:s");
        $data['title']     = $title;
        $data['writer']    = $writer;
        $data['type']      = $type;
        $data['introduce'] = $introduce;
        $data['price']=$price;
        $addResult         = (new bookFunc())->add($data);

        return $addResult;
    }

    // 检测数据库中是否存在同一个用户上架相同作者且相同书名的书籍
    function isBookExist($userId,$bookTitle,$bookWriter){
        $result = (new bookFunc())->where(["user_id = '$userId' AND ","title = '$bookTitle' AND ","writer = '$bookWriter'"])
            ->fetch();

        return $result;
    }

    // 查询某商家已经上架的所有书籍
    function listBook($traderUserId){
        $row=(new bookFunc())->where(["user_id = '$traderUserId'"])->fetchAll();

        return $row;
    }

    // 通过书籍id获取对应书籍的相关字段
    function gainDataByBookId($bookId,$dataName){
        $row=(new bookFunc())->where(["id = '$bookId'"])->fetch();
        $data=$row[$dataName];

        return $data;
    }
}