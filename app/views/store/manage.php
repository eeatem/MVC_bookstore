<span class="success">在售书籍：</span> <br>

<?php
// 书籍显示N本后换行显示
define('N', 5);
$i = 0;
foreach ($rows as $row) {
    $i++;
    ?>

    <a href="/book/detail/<?php echo $row['id']?>"><input type="button" value="<?php echo $row['title'] ?>"/></a>

    <?php
    // 书籍显示N本后换行显示
    if ($i % N == 0) {
        echo "<br />";
    }
}
?>

<br> <br> <a href="/user/menu/"><input type="button" value="返回菜单"></a>
