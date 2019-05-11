<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-09
 * Time: 06:39
 */

namespace app\controllers;

use core\base\Controller;
use app\models\BookModel;

class BookController extends Controller
{
    public function index(){

    }
    // 书籍详情
    public function detail($bookId){
        $row=(new BookModel())->showBookDetail($bookId);

        $this->assign('row',$row);
        $this->assign('title','书籍详情');
        $this->render();
    }
}