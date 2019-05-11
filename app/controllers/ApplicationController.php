<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-07
 * Time: 19:38
 */

namespace app\controllers;

use core\base\Controller;
use app\models\ApplicationModel;

session_start();

class ApplicationController extends Controller
{
    //
    public function index()
    {
        $this->assign('title','申请');
        $this->render();
    }

    // 审核申请信息
    public function manage()
    {
        $rows = (new ApplicationModel())->fetchAll();

        $this->assign('rows', $rows);
        $this->assign('title', '审核申请信息');
        $this->render();
    }

    // 申请成为商家
    public function trader()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $applyResult = (new ApplicationModel())->applyMessage($_SESSION['userName'], '申请成为商家');
        }

        $this->assign('applyResult', $applyResult);
        $this->assign('title', '申请成为商家');
        $this->render();
    }

    // 申请开店
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $applyResult = (new ApplicationModel())->applyMessage($_SESSION['userName'], '申请开店');

        }

        $this->assign('applyResult', $applyResult);
        $this->assign('title', '申请开店');
        $this->render();
    }

    // 申请上架书籍
    public function addBook()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $titleError     = (new ApplicationModel())->isBookTitleLegal($_POST['title']);
            $writerError    = (new ApplicationModel())->isBookWriterLegal($_POST['writer']);
            $introduceError = (new ApplicationModel())->isBookIntroduceLegal($_POST['introduce']);
            $priceError     = (new ApplicationModel())->isBookPriceLegal($_POST['price']);
            $isExist        = (new ApplicationModel())->isBookApplyExist($_SESSION['userName'], $_POST['title'], $_POST['writer']);
            if ($titleError == '' && $writerError == '' && $introduceError == '' && $priceError == '' && $isExist == false) {
                $applyResult = (new ApplicationModel())->applyAddBook($_SESSION['userName'], $_POST['title'], $_POST['writer'],
                    $_POST['type'], $_POST['introduce'], $_POST['price']);
            }
        }

        $this->assign('titleError', $titleError);
        $this->assign('writerError', $writerError);
        $this->assign('introduceError', $introduceError);
        $this->assign('priceError', $priceError);
        $this->assign('isExist', $isExist);
        $this->assign('applyResult', $applyResult);
        $this->assign('title', '申请上架书籍');
        $this->render();
    }

    // 通过审核
    public function agree($applicationId)
    {
        $traderUpdateResult = (new ApplicationModel())->agreeTraderApplication($applicationId);
        $storeUpdateResult  = (new ApplicationModel())->agreeStoreApplication($applicationId);
        $bookAddResult      = (new ApplicationModel())->agreeAddBookApplication($applicationId);
        $userName           = (new ApplicationModel())->gainUserNameByApplicationId($applicationId);
        if ($traderUpdateResult == true || $storeUpdateResult == true || $bookAddResult == true) {
            (new \app\models\messageFunc())->addApplicationResultMessage($applicationId, '1', $_SESSION['userName']);
        }

        $this->assign('userName', $userName);
        $this->assign('applicationId', $applicationId);
        $this->assign('traderUpdateResult', $traderUpdateResult);
        $this->assign('storeUpdateResult', $storeUpdateResult);
        $this->assign('bookAddResult', $bookAddResult);
        $this->assign('title', '通过申请');
        $this->render();
    }

    // 忽略审核
    public function ignore($applicationId)
    {
        $managerName = $_SESSION['userName'];

        // $this->assign('deleteResult', $deleteResult);
        $this->assign('applicationId', $applicationId);
        $this->assign('managerName', $managerName);
        $this->assign('title', '忽略申请');
        $this->render();
    }
}