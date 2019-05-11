<?php

use app\models\userFunc;

session_start();
?>
<table width=250 border="0" cellpadding="5" cellspacing="1" bgcolor="#add3ef">
    <tr bgcolor="#eff3ff">
        <td>书名：<?php echo $row['title'] ?></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td>作者：<?php echo $row['writer'] ?></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td>类型：<?php echo $row['type'] ?></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td>简介：<?php echo $row['introduce'] ?></td>
    </tr>
    <tr bgcolor="#eff3ff">
        <td>定价：<?php echo $row['price'] ?></td>
    </tr>
    <?php
    if ($_SESSION['userLevel'] == 0) {
        ?>
        <tr bgcolor="#ffffff">
            <td>&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;
                <a href="/cart/addGood/<?php echo $row['id'] ?>"><input type="button" value="加入购物车"></a>
            </td>
        </tr>
        <?php

    }
    ?>
</table>

<?php
if($_SESSION['userLevel']==0) {
    echo "<a href='/store/book/'><input type='button' value='返回'></a>";
}else{
    echo "<a href='/store/manage/'><input type='button' value='返回'></a>";
}