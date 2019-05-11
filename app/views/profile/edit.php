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

// 生成编辑个人资料html页面中的生日年份选择
function html_editIntroduce_birthdayYear()
{
    // 获取当前年份 并生成一系列年份选择
    for ($year = date(Y); $year >= 1920; $year--) {
        echo "<option value='$year'>$year</option>";
    }
}

// 生成编辑个人资料html页面中的生日月份选择
function html_editIntroduce_birthdayMonth()
{
    // 生成一系列月份选择
    for ($month = 1; $month <= 12; $month++) {
        echo "<option value='$month'>$month</option>";
    }
}

// 生成编辑个人资料html页面中的所在区域选择
function html_editIntroduce_location()
{
    $province = array('北京', '天津', '上海', '重庆', '河北', '山西', '辽宁', '吉林', '黑龙江', '江苏', '浙江',
        '安徽', '福建', '江西', '山东', '河南', '湖北', '湖南', '广东', '海南', '四川', '贵州',
        '云南', '陕西', '甘肃', '青海', '台湾', '内蒙古', '广西', '西藏', '宁夏',
        '新疆', '香港', '澳门');

    foreach ($province as $value) {
        echo "<option value='$value'>$value</option>";
    }
}
session_start();
isUserLogin($_SESSION[userName], '尚未登陆，无法修改个人资料！', '/user/login/');
?>

    <form method="POST" action="">
        <label>出生年月：</label>
        <select name="birthdayYear">
            <option value="">------</option>
            <? html_editIntroduce_birthdayYear(); ?>
        </select>年
        <select name="birthdayMonth">
            <option value="">---</option>
            <? html_editIntroduce_birthdayMonth(); ?>
        </select>月
        <!-- 若未填写出生年月则报错 -->
        <? echo "<span class=error>$birthdayError</span>"; ?> <br>
        <label>所在区域：</label>
        <select name="location">
            <option value="">--------</option>
            <? html_editIntroduce_location(); ?>
        </select>省/自治区/直辖市
        <!-- 若未填写所在区域则报错 -->
        <? echo "<span class='error'>$locationError</span>"; ?> <br>
        <label>个人简介：</label>
        <textarea rows="5" cols="52" name="introduce"></textarea> <br>
        验证码&emsp;：&nbsp;<input type="text" size="5" name="checkCode"/>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;
        <? echo "<span class='error'>" . $checkCodeError . "</span>"; ?> <br>
        <img src="\static\check_code.php"/> <br>
        <input type="submit" value="提交">
        <a href="/profile/"><input type="button" value="返回"></a>
    </form>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($editResult == true) {
        echo "<span class='success'>个人资料修改成功！</span>";
    } else {
        echo "<span class='error'>个人资料修改失败！</span>";
    }
}
?>