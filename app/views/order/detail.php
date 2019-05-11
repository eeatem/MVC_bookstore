<?php
// 订单状态
function showOrderStatus($orderStatusId)
{
    if ($orderStatusId == '0') {
        $orderStatus = '未发货';
    } else if ($orderStatusId == '1') {
        $orderStatus = '已发货';
    }

    return $orderStatus;
}
use \app\models\bookFunc;
?>
<div>订单号&emsp;：<?php echo $row1['order_number'] ?></div>
<div>创建时间：<?php echo $row1['create_time'] ?></div>
<div>订单状态：<?php echo showOrderStatus($row1['status']) ?></div>
<div>商品&emsp;&emsp;：
    <table width=550 border="1" cellpadding="1" cellspacing="0" bgcolor="#ffffff">
        <tr bgcolor="#add3ef">
            <td>书籍</td>
            <td>作者</td>
            <td>店铺</td>
            <td>单价</td>
            <td>数量</td>
            <td>小计</td>
        </tr>
<?php
foreach ($row2 as $row) {
    $bookId=$row['good_id'];
    ?>
        <tr bgcolor="#ffffff">
            <td><?php echo (new bookFunc())->gainDataByBookId($bookId,'title') ?></td>
            <td><?php echo (new bookFunc())->gainDataByBookId($bookId,'writer') ?></td>
            <td><?php echo (new bookFunc())->gainDataByBookId($bookId,'user_id') ?></td>
            <td><?php echo (new bookFunc())->gainDataByBookId($bookId,'price') ?></td>
            <td><?php echo $row['good_number'] ?></td>
            <td><?php echo $row['good_total_price'] ?></td>
        </tr>
    <?php
}
?>
    </table>
    <div>总计&emsp;&emsp;：<?php echo $row1['total_price'] ?></div>
    <div>收货人&emsp;：<?php echo $row1['consignee_name'] ?></div>
    <div>联系电话：<?php echo $row1['consignee_contact'] ?></div>
    <div>收货地址：<?php echo $row1['consignee_address'] ?></div>

    <a href="/order/"><input type="button" value="返回"></a>