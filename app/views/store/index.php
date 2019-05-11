<span class="success">进入店铺：</span> <br>

<?php
// 店铺显示N个后换行显示
define('N', 5);
$i = 0;
foreach ($rows as $row) {
    $i++;
    ?>

    <a href="/store/book/<?php echo $row['user_id'] ?>"><input type="button" value="<?php echo $row['id'] ?>"/></a>

    <?php
    // 店铺显示N个后换行显示
    if ($i % N == 0) {
        echo "<br />";
    }
}
?>

<br> <br> <a href="/user/menu"><input type="button" value="返回菜单"></a>
