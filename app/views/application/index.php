<?php
session_start();

use app\models\userFunc;
use app\models\storeFunc;

if ($_SESSION['userLevel'] == '0') {
    ?>
    <a href="/application/trader/"><input type="button" value="申请成为商家"></a>
    <a href="/user/menu/"><input type="button" value="返回菜单"></a>
    <?php
}
?>
<?php
if ($_SESSION['userLevel'] == '1' && (new storeFunc())->isTraderHasStore($_SESSION['userName']) == false) {
    ?>
    <a href="/application/store/"><input type="button" value="申请开店"></a>
    <a href="/user/menu/"><input type="button" value="返回菜单"></a>
    <?php
}
?>
<?php
if ($_SESSION['userLevel'] == '1' && (new storeFunc())->isTraderHasStore($_SESSION['userName']) == true) {
    ?>
    <a href="/application/addBook/"><input type="button" value="申请上架书籍"></a>
    <a href="/user/menu/"><input type="button" value="返回菜单"></a>
    <?php
}
?>
<?php
if ($_SESSION['userLevel'] == '2') {
    ?>
    <a href="/application/manage/"><input type="button" value="用户申请管理"></a>
    <a href="/user/menu/"><input type="button" value="返回菜单"></a>
    <?php
}
?>
