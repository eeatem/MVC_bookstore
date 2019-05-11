<form method="POST" action="">
    收货人姓名：<input type="text" name="consigneeName"/>
    <? echo "<span class='error'>" . $consigneeNameError . "</span>" ?> <br>
    手机号码&emsp;：<input type="text" name="consigneeContact"/>
    <? echo "<span class='error'>" . $consigneeContactError . "</span>" ?> <br>
    地址&emsp;&emsp;&emsp;：<textarea rows="3" cols="50" name="consigneeAddress"></textarea>
    <? echo "<span class='error'>" . $consigneeAddressError . "</span>" ?> <br> <br>
    <input type="submit" value="提交"/>
</form>

<?php
// 订单提交成功后删除数据库中的购物车记录
if ($addResult == true) {
    echo "<span class='success'>" . '订单提交成功！' . "</span>";
    (new \app\models\CartModel())->where(["user_id = '$userId'"])->deleteW();
}
?>

<a href="/user/menu/"><input type="button" value="返回菜单"></a>