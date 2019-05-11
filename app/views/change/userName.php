<?php
(new \app\models\userFunc())->isUserLogin($_SESSION[userName], '尚未登陆，无法修改用户名！', '/user/login/');
?>

<form method="POST" action="">
    <span class="success">新的用户名：</span> <input type="text" name="userName"/>
    <? echo "<span class='error'>" . $userNameError . "</span>"; ?> <br>
    <span class="success"> 确认用户名：</span> <input type="text" name="userNameConfirm"/>
    <? echo "<span class='error'>" . $userNameConfirmError . "</span>" ?> <br>
    <input type="submit" value="提交">
    <a href="/change/"><input type="button" value="返回"></a>
</form>

<?php
session_start();

// 若用户名修改信息执行成功
if ($_SERVER['REQUEST_METHOD']=='POST' && $changeResult == true) {
    echo "<span class='success'>" . "用户名修改成功，请牢记您的新用户名：" . "<span class='tips'>" . $_POST[userName] . "</span>" . " ！" . "</span>";
    // 更新登陆的session
    $_SESSION['userName'] = $_POST['userName'];
}
?>