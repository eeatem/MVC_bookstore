<?php
session_start();
// 检测用户是否已经登陆
(new \app\models\userFunc())->isUserLogin($_SESSION['userName'], '尚未登陆，无法提交申请！', '/user/login');
// 检测用户是否为普通用户
(new \app\models\userFunc())->checkIsOrdinaryOrTrader($_SESSION['userName'], '0', '非普通用户，无法申请成为商家！');
?>

    <form method="POST" action="">
        <span class="error">即将向管理员提交成为商家申请：</span> <br>
        <input type="submit" value="提交"/>
    </form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($applyResult == true) {
        echo "<span class='success'>申请提交成功，请耐心等待管理员审核！</span>";
    } else {
        echo "<span class='error'>申请提交失败，由于您重复申请或其他未知原因！</span>";
    }
}
?>

<a href="/application/"><input type="button" value="返回"/></a>
