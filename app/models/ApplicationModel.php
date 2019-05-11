<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-07
 * Time: 19:38
 */

namespace app\models;

use core\base\Model;

class ApplicationModel extends Model
{
    // 选择申请信息表
    protected $table = 't_application';

    // 将成为商家、开店申请信息插入数据库中
    public function applyMessage($userName, $applyContent)
    {
        // 获取用户Id
        $userId = (new userFunc())->gainUserId($userName);
        // 防止用户重复提交申请
        $row = (new ApplicationModel())->where(["user_id = '$userId' AND ", "apply_content = '$applyContent'"])->fetch();
        if ($row == true) {
            $applyResult = false;
        } else {
            $data['user_id']       = $userId;
            $data['apply_time']    = date("Y-m-d H:i:s");
            $data['apply_content'] = $applyContent;
            $applyResult           = (new ApplicationModel())->add($data);
        }

        return $applyResult;
    }

    // 检测申请上架书籍页面输入的书名是否合法
    public function isBookTitleLegal($bookTitle)
    {
        if (empty($bookTitle)) {
            $bookTitleError = '*请输入书籍名称';
        } else if ((new userFunc())->isExitSpace($bookTitle)) {
            $bookTitleError = '*请勿输入空格';
        } else if (strlen($bookTitle) > 150) {
            $bookTitleError = '*书名不得超过50个中文字符，请重新输入';
        } else {
            $bookTitleError = '';
        }

        return $bookTitleError;
    }

    // 检测申请上架书籍页面输入的作者是否合法
    public function isBookWriterLegal($bookWriter)
    {
        if (empty($bookWriter)) {
            $bookWriterError = '*请输入作者姓名';
        } else if ((new userFunc())->isExitSpace($bookWriter)) {
            $bookWriterError = '*请勿输入空格';
        } else if (strlen($bookWriter) > 30) {
            $bookWriterError = '*作者姓名不得超过10个中文字符，请重新输入';
        } else {
            $bookWriterError = '';
        }

        return $bookWriterError;
    }

    // 检测申请上架书籍页面输入的简介是否合法
    public function isBookIntroduceLegal($bookIntroduce)
    {
        if (empty($bookIntroduce)) {
            $bookIntroduceError = '*请输入书籍简介';
        } else if ((new userFunc())->isExitSpace($bookIntroduce)) {
            $bookIntroduceError = '*请勿输入空格';
        } else if (strlen($bookIntroduce) > 300) {
            $bookIntroduceError = '*书籍简介不得超过100个中文字符，请重新输入';
        } else {
            $bookIntroduceError = '';
        }

        return $bookIntroduceError;
    }

    // 检测申请上架书籍页面输入的定价是否合法
    public function isBookPriceLegal($bookPrice)
    {
        if (empty($bookPrice)) {
            $bookPriceError = '*请输入书籍简介';
            // 限制输入一个小数点和阿拉伯数字
        } else if (!preg_match('/^\d+$|^\d*\.\d+$/', $bookPrice)) {
            $bookPriceError = '*仅限输入阿拉伯数字和一个小数点';
        } else if ($bookPrice >= 10000) {
            $bookPriceError = '*书籍定价不得超过10000元，请重新输入';
        } else {
            $bookPriceError = '';
        }

        return $bookPriceError;
    }

    // 检测申请上架是否书名相同且作者相同的书籍
    public function isBookApplyExist($userName, $bookTitle, $bookWriter)
    {
        $userId = (new userFunc())->gainUserId($userName);
        $row1   = (new ApplicationModel())->where(["book_title = '$bookTitle' AND ", "book_writer = '$bookWriter'"])->fetch();
        $row2   = (new bookFunc())->isBookExist($userId, $bookTitle, $bookWriter);
        if ($row1 == true || $row2 == true) {
            $isExist = true;
        } else {
            $isExist = false;
        }

        return $isExist;
    }

    // 将上架书籍申请信息插入数据库中
    public function applyAddBook($userName, $title, $writer, $type, $introduce, $price)
    {
        // 获取用户Id
        $userId = (new userFunc())->gainUserId($userName);
        // 防止用户重复提交书名相同且作者相同的上架书籍申请
        $row = (new ApplicationModel())->where(["book_title = '$title' AND ", "book_writer = '$writer'"])->fetch();
        if ($row == true) {
            $applyResult = false;
        } else {
            $data['user_id']        = $userId;
            $data['apply_time']     = date("Y-m-d H:i:s");
            $data['apply_content']  = '申请上架书籍';
            $data['book_title']     = $title;
            $data['book_writer']    = $writer;
            $data['book_type']      = $type;
            $data['book_introduce'] = $introduce;
            $data['book_price']     = $price;
            $applyResult            = (new ApplicationModel())->add($data);
        }

        return $applyResult;

    }

    // 删除数据库中相应的申请信息
    public function deleteApplication($applicationId)
    {
        $deleteResult = (new ApplicationModel())->delete($applicationId);

        return $deleteResult;
    }

    // 通过用户申请
    // 通过成为商家申请
    public function agreeTraderApplication($applicationId)
    {
        // 获取申请人用户名
        $userName = (new ApplicationModel())->gainUserNameByApplicationId($applicationId);
        $row      = (new ApplicationModel())->where(["id = '$applicationId' AND ", "apply_content = '申请成为商家'"])->fetch();
        if ($row == true) {
            // 更新用户权限
            $updateResult = (new userFunc())->updateUserLevel($userName, '1');
        }

        return $updateResult;
    }

    // 通过开店申请
    public function agreeStoreApplication($applicationId)
    {
        // 获取申请人Id
        $userId = (new ApplicationModel())->gainUserIdByApplicationId($applicationId);
        $row    = (new ApplicationModel())->where(["id = '$applicationId' AND ", "apply_content = '申请开店'"])->fetch();
        if ($row == true) {
            // 插入开店信息
            $updateResult = (new storeFunc())->addStore($userId);
        }

        return $updateResult;
    }

    // 通过书籍上架申请
    public function agreeAddBookApplication($applicationId)
    {
        // 获取申请人Id
        $userId = (new ApplicationModel())->gainUserIdByApplicationId($applicationId);
        $row    = (new ApplicationModel())->where(["id = '$applicationId' AND ", "apply_content = '申请上架书籍'"])->fetch();
        if ($row == true) {
            // 获取上架书籍信息
            $row = (new ApplicationModel())->where(["id = '$applicationId'"])->fetch();
            // 在数据库中插入书籍信息
            $addResult = (new bookFunc())->addBookMessage($userId, $row['book_title'], $row['book_writer'], $row['book_type'],
                $row['book_introduce'], $row['book_price']);
        }

        return $addResult;
    }

    // 根据申请信息Id返回用户id
    public function gainUserIdByApplicationId($applicationId)
    {
        // 获取申请人Id
        $row    = (new ApplicationModel())->where(["id = '$applicationId'"])->fetch();
        $userId = $row['user_id'];

        return $userId;
    }

    // 根据申请信息Id返回用户名
    public function gainUserNameByApplicationId($applicationId)
    {
        // 获取申请人Id
        $row    = (new ApplicationModel())->where(["id = '$applicationId'"])->fetch();
        $userId = $row['user_id'];
        // 获取用户名
        $userName = (new userFunc())->gainUserNameById($userId);

        return $userName;
    }

    // 根据申请信息Id返回申请内容
    public function gainContentByApplicationId($applicationId)
    {
        $row     = (new ApplicationModel())->where(["id = '$applicationId'"])->fetch();
        $content = $row['apply_content'];

        return $content;
    }

    // 根据申请信息返回书籍字段
    public function gainBookDataByApplicationId($applicationId, $dataName)
    {
        $row  = (new ApplicationModel())->where(["id = '$applicationId'"])->fetch();
        $data = $row[$dataName];

        return $data;
    }
}