<?php
session_start();
// 检测登陆用户是否为管理员
$level = (new \app\models\userFunc())->checkUserLevel($_SESSION['userName']);
if ($level != '2') {
    echo "<span class='error'>" . '非管理员登陆，无法处理审核信息！' . "</span>";
    die;
}
?>

<table width=250 border="0" cellpadding="5" cellspacing="1" bgcolor="#add3ef">
    <?php
    foreach ($rows as $row) {
        $name = (new \app\models\userFunc())->gainUserNameById($row['user_id']);
        if ($row['apply_content'] == '申请成为商家' || $row['apply_content'] == '申请开店') {
            ?>
            <tr bgcolor="#eff3ff">
                <td>申请人&emsp;：<?= $name ?></td>
            </tr>
            <tr bgcolor="#ffffff">
                <td>内&emsp;容&emsp;：<?= $row['apply_content'] ?></td>
            </tr>
            <tr bgcolor="#eff3ff">
                <td>创建时间：<?= $row['apply_time'] ?></td>
            </tr>
            <tr bgcolor="#add3ef">
                <td>
                    <a href="/application/agree/<?php echo $row['id'] ?>"><input type="button" value="通过"/></a>
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    <a href="/application/ignore/<?php echo $row['id'] ?>"><input type="button" value="忽略"/></a>
                </td>
            </tr>
            <?php
        } else if ($row['apply_content'] == '申请上架书籍') {
            ?>
            <tr bgcolor="#eff3ff">
                <td>申请人&emsp;：<?= $name ?></td>
            </tr>
            <tr bgcolor="#eff3ff">
                <td>内&emsp;容&emsp;：<?= $row['apply_content'] ?></td>
            </tr>
            <tr bgcolor="#eff3ff">
                <td>创建时间：<?= $row['apply_time'] ?></td>
            </tr>
            <tr bgcolor="#ffffff">
                <td>书名：<?= $row['book_title'] ?></td>
            </tr>
            <tr bgcolor="#ffffff">
                <td>作者：<?= $row['book_writer'] ?></td>
            </tr>
            <tr bgcolor="#ffffff">
                <td>类型：<?= $row['book_type'] ?></td>
            </tr>
            <tr bgcolor="#ffffff">
                <td>简介：<?= $row['book_introduce'] ?></td>
            </tr>
            <tr bgcolor="#ffffff">
                <td>定价：<?= $row['book_price'] ?></td>
            </tr>
            <tr bgcolor="#add3ef">
                <td>
                    <a href="/application/agree/<?php echo $row['id'] ?>"><input type="button" value="通过"/></a>
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    <a href="/application/ignore/<?php echo $row['id'] ?>"><input type="button" value="忽略"/></a>
                </td>
            </tr>
            <?php
        }
    }
    ?>
</table>

<a href="/application/"><input type="button" value="返回"/></a>