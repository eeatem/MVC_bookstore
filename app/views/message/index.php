<?php
// 查询站内被读状态
function showStatus($statusId)
{
    if($statusId=='0'){
        $status='未读';
    }else if($statusId=='1'){
        $status='已读';
    }

    return $status;
}

foreach ($rows as $row) {
    ?>
    <a href="/message/detail/<?php echo $row['id'] ?>"><input type="button" value="<?php echo $row['content'] ?>"/></a>
    <?php echo showStatus($row['status']) ?>
    <br>
    <?php
}
?>

<br> <a href="/user/menu/"><input type="button" value="返回菜单"></a>