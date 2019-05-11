<?php
// 配置html注册页面中的密保问题
function html_register_question()
{
    $questions = array('您的第一个配偶是？', '您最喜欢的歌手是？', '您的第一位老师是？');

    foreach ($questions as $value) {
        echo "<option value='$value'>$value</option>";
    }
}
?>

    <form method="POST" action="">
        用户昵称：<input type="text" name="userName"/>
        <? echo "<span class='error'>" . $userNameError . "</span>"; ?> <br>
        常用邮箱：<input type="text" name="email"/>
        <? echo "<span class='error'>" . $emailError . "</span>"; ?> <br>
        注册密码：<input type="password" name="password"/>
        <? echo "<span class='error'>" . $passwordError . "</span>"; ?> <br>
        确认密码：<input type="password" name="passwordConfirm"/>
        <? echo "<span class='error'>" . $passwordConfirmError . "</span>"; ?> <br>
        选择性别：<input type="radio" name="gender" value="男"/>男
        <input type="radio" name="gender" value="女"/>女
        &emsp;&emsp;&emsp;&emsp;&emsp;
        <? echo "<span class='error'>" . $genderError . "</span>"; ?> <br>
        <label>密保问题：</label>
        <select name="question">
            <?php
            html_register_question();
            ?>
        </select> <br>
        问题答案：<input type="text" name="answer"/>
        <? echo "<span class='error'>" . $answerError . "</span>"; ?> <br>
        确认答案：<input type="text" name="answerConfirm">
        <? echo "<span class='error'>" . $answerConfirmError . "</span>"; ?> <br>
        验证码&emsp;：<input type="text" size="5" name="checkCode"/>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;
        <? echo "<span class='error'>" . $checkCodeError . "</span>"; ?> <br>
        <img src="\static\check_code.php"/> <br>
        <input type="submit" value="注册"/>
        <a href="/user/"><input type="button" value="返回首页"></a>
    </form>

<?php
// 若注册数据插入数据库成功，则显示注册成功提示
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $isRegisterSuccess == true) {
    echo "<span class='success'>" . 注册成功，欢迎您， . "</span>" . 用户： . "<span class='tips'>" . $userName . "</span>" . ' ! ';
    echo "<a href='/user/login/'><input type='button' value='登陆'/></a>";
}
?>