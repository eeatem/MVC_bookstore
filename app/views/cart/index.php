<?php

use app\models\bookFunc;

session_start();
?>

<table width=550 border="1" cellpadding="1" cellspacing="0" bgcolor="#ffffff">
    <tr bgcolor="#add3ef">
        <td>书籍</td>
        <td>店铺</td>
        <td>单价</td>
        <td>数量</td>
        <td>增加</td>
        <td>减少</td>
    </tr>
    <?php
    foreach ($rows as $row) {
        $bookId = $row['good_id'];
        ?>
        <tr bgcolor="#ffffff">
            <td><?php echo (new bookFunc())->gainDataByBookId($bookId, 'title') ?></td>
            <td><?php echo (new bookFunc())->gainDataByBookId($bookId, 'user_id') ?></td>
            <td><?php echo $bookPrice=(new bookFunc())->gainDataByBookId($bookId, 'price') ?></td>
            <td><?php echo $bookNumber=$row['good_number'] ?></td>
            <td>
                <a href="/cart/increase/<?php echo $row['id'] ?>"><input type="button" value="增加"/></a>
            </td>
            <td>
                <a href="/cart/decrease/<?php echo $row['id'] ?>"><input type="button" value="减少"/></a>
            </td>
        </tr>
        <?php
        $totalPrice+=$bookPrice*$bookNumber;
        // 保留小数点后两位输出商品总价格
        $totalPrice=sprintf("%.2f",$totalPrice);
        // 把总价存在session中，用于后期扩展付款等功能时使用
        $_SESSION['totalPrice']=$totalPrice;
    }
    ?>
    总计：<?php echo $totalPrice ?>元
    <?php
    if($rows==true) {
        ?>
        <a href="/order/submit/"><input type="button" value="提交订单"/></a>
        <?php
    }
    ?>
</table>

<a href="/user/menu/"><input type="button" value="返回菜单"></a>
