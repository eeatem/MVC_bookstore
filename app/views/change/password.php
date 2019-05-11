<?php
session_start();
(new \app\models\ChangeModel())->isCanChangePassword($_SESSION['isCanChangePassword']);
?>

    <form method="POST" action="">
        <span class="success">新密码：</span>&emsp;<input type="password" name="password"/>
        <? echo "<span class='error'>" . $passwordError . "</span>"; ?> <br>
        <span class="success">确认密码：</span><input type="password" name="passwordConfirm">
        <? echo "<span class='error'>" . $passwordConfirmError . "</span>"; ?> <br>
        <input type="submit" value="提交">
    </form>

<?php
// 若密码修改信息执行成功
if ($changeResult == true) {
    echo "<span class='success'>密码修改成功，请牢记您的新密码！</span>";
    echo "<a href='/user/menu/'><input type='button' value='返回菜单'></a>";
    // 清除密保问题验证结果
    $_SESSION['isCanChangePassword']=false;
}
?>