<?php
session_start();
(new \app\models\userFunc())->isUserLogin($_SESSION['userNameTemp'],'尚未检测到用户名，无法修改密码！','login.php');
?>

<form method="POST" action="">
    <span class="success">密保问题：</span> <? echo (new \app\models\userFunc())->gainUserData($_SESSION[userName], 'question'); ?> <br>
    <span class="success">问题答案：</span> <input type="text" name="answer"/>
    <? echo "<span class='error'>".$answerError."</span>" ?> <br>
    <input type="submit" value="提交"/>
    <a href="/change/"><input type="button" value="返回"></a>
</form>

<?php
// 若密保问题通过验证
if($isCanChangePassword==true) {
    // 把密保问题验证结果存入session中
    $_SESSION['isCanChangePassword']=$isCanChangePassword;
    // 跳转到修改密码页面
    $url = "/change/password/";
    echo "<script type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}
?>