<?php
// 检测用户是否已经登陆，并返回错误信息
function isUserLogin($userNameSession, $error, $file)
{
    if (empty($userNameSession)) {
        echo "<span class='error'>" . $error . "</span>";
        echo "<a href='$file'><input type='button' value='登陆'></a>";
        die;
    }
}
// 检测用户是否已经登陆
session_start();
isUserLogin($_SESSION['userName'],'尚未登陆，无法显示个人资料！','/user/login');
?>

<form method="POST" action="">
    <span class="success">用户名&emsp;：</span> <? echo $_SESSION['userName']; ?> <br> <br>
    <span class="success">注册邮箱：</span> <? echo $email; ?> <br> <br>
    <span class="success">出生年月：</span> <? echo $birthdayYear; ?> 年
    <span class="success"></span> <? echo $birthdayMonth; ?> 月 <br> <br>
    <span class="success">所在区域：</span> <? echo $location; ?>（省/自治区/直辖市）<br> <br>
    <span class="success">个人简介：</span> <? echo $introduce; ?> <br> <br>
    <span class="success">登陆权限：</span> <? echo $level; ?> <br> <br>
    <span class="success">注册时长：</span> <? echo $registerTime; ?> 天 <br> <br>
    <a href="/profile/"><input type="button" value="返回"></a>
</form>