我的订单： <br>
<?php
foreach ($rows as $row){
?>
    <a href="/order/detail/<?php echo $row['id'] ?>"><input type="button" value="<?php echo $row['order_number'] ?>"/></a>
<?php
}
?>

<br> <a href="/user/menu/"><input type="button" value="返回菜单"></a>
