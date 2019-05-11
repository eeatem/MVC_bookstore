<?php

use app\models\userFunc;
use app\models\storeFunc;

session_start();

if ($_SESSION['userLevel'] == 0 && (new userFunc())->checkUserLevel($_SESSION['userName']) == 0) {
    ?>
    <a href="/store/"><input type="button" value="商城"></a>
    <a href="/cart/"><input type="button" value="购物车"></a>
    <a href="/order/"><input type="button" value="我的订单"></a>
    <a href="/application/"><input type="button" value="申请"></a>
    <a href="/message/"><input type="button" value="站内信"></a>
    <a href="/change/"><input type="button" value="修改用户名/密码"></a>
    <a href="/profile/"><input type="button" value="个人资料"></a>
    <a href="/user/logout/"><input type="button" value="注销登陆"></a>
    <?php
}
if ($_SESSION['userLevel'] == 0 && (new userFunc())->checkUserLevel($_SESSION['userName']) == 1) {
    ?>
    <a href="/store/"><input type="button" value="商城"></a>
    <a href="/cart/"><input type="button" value="购物车"></a>
    <a href="/order/"><input type="button" value="我的订单"></a>
    <a href="/message/"><input type="button" value="站内信"></a>
    <a href="/change/"><input type="button" value="修改用户名/密码"></a>
    <a href="/profile/"><input type="button" value="个人资料"></a>
    <a href="/user/logout/"><input type="button" value="注销登陆"></a>
    <?php
}
if ($_SESSION['userLevel'] && (new storeFunc())->isTraderHasStore($_SESSION['userName']) == false) {
    ?>
    <a href="/application/"><input type="button" value="申请"></a>
    <a href="/message/"><input type="button" value="站内信"></a>
    <a href="/change/"><input type="button" value="修改用户名/密码"></a>
    <a href="/profile/"><input type="button" value="个人资料"></a>
    <a href="/user/logout/"><input type="button" value="注销登陆"></a>
    <?php
}
if ($_SESSION['userLevel'] == 1 && (new storeFunc())->isTraderHasStore($_SESSION['userName']) == true) {
    ?>
    <a href="/store/manage/"><input type="button" value="店铺管理"></a>
    <a href="/application/"><input type="button" value="申请"></a>
    <a href="/message/"><input type="button" value="站内信"></a>
    <a href="/change/"><input type="button" value="修改用户名/密码"></a>
    <a href="/profile/"><input type="button" value="个人资料"></a>
    <a href="/user/logout/"><input type="button" value="注销登陆"></a>
    <?php
}
if ($_SESSION['userLevel'] == 2) {
    ?>
    <a href="/application/"><input type="button" value="申请信息管理"></a>
    <a href="/message/"><input type="button" value="站内信"></a>
    <a href="/change/"><input type="button" value="修改用户名/密码"></a>
    <a href="/profile/"><input type="button" value="个人资料"></a>
    <a href="/user/logout/"><input type="button" value="注销登陆"></a>
    <?php
}
?>
