<?php
// 配置html登陆页面中的用户权限选择
function html_login_level()
{
    $levels = array('普通用户', '商家', '管理员');
    $i      = 0;
    foreach ($levels as $value) {
        echo "<option value='$i'>$value</option>";
        ++$i;
    }
}
?>

    <form method="POST" action="">
        用户名或邮箱：<input type="text" name="userName"/>
        <? echo "<span class='error'>" . $userNameError . "</span>" ?> <br>
        登陆密码&emsp;&emsp;：<input type="password" name="password"/>
        <? echo "<span class='error'>" . $passwordError . "</span>" ?> <br>
        <label>选择权限&emsp;&emsp;：</label>
        <select name="level">
            <? html_login_level(); ?>
        </select>
        &emsp;&emsp;&emsp;&emsp;<? echo "<span class='error'>" . $levelError . "</span>"; ?> <br>
        验证码&emsp;&emsp;&emsp;：<input type="text" size="5" name="checkCode"/>
        <? echo "<span class='error'>" . $checkCodeError . "</span>" ?> <br>
        <img src="\static\check_code.php"/> <br>
        <input type="submit" value="登陆"/>
        <a href="/user/"><input type="button" value="返回首页"></a>
    </form>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && $isLoginSuccess == true) {
    echo "<span class='success'>" . 登陆成功，欢迎您， . "</span>" . 用户： . "<span class='tips'>" . $userName . "</span>" . ' ! ';
    echo "<a href='/user/menu/'><input type='button' value='进入菜单'></a>";
}
?>