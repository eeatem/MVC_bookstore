<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-09
 * Time: 06:38
 */

namespace app\models;

use core\base\Model;

class BookModel extends Model
{
    // 选择书籍表
    protected $table = 't_book';

    // 通过书籍id查询指定书籍，并返回其相关字段内容
    public function showBookDetail($bookId){
        $row=(new BookModel())->where(["id = '$bookId'"])->fetch();

        return $row;
    }
}