<?php
// 生成编辑个人资料html页面中的书籍类型选择
function html_addBook_type()
{
    $province = array('文学类', '言情类', '科幻类', '工具类', '教育类');

    foreach ($province as $value) {
        echo "<option value='$value'>$value</option>";
    }
}
session_start();
// 检测用户是否已经登陆
(new \app\models\userFunc())->isUserLogin($_SESSION['userName'], '尚未登陆，无法提交申请！', '/user/login');
// 检测用户是否为商家
(new \app\models\userFunc())->checkIsOrdinaryOrTrader($_SESSION['userName'], '1', '非商家，无法申请上架书籍！');
?>

<span class="success">请填写书籍信息：</span>
<form method="POST" action="">
    书名：<input type="text" size="30" name="title"/>
    <?php echo "<span class='error'>" . $titleError . "</span>"; ?> <br>
    作者：<input type="text" size="30" name="writer"/>
    <?php echo "<span class='error'>" . $writerError . "</span>"; ?> <br>
    <label>类型：</label>
    <select name="type">
        <?php html_addBook_type(); ?>
    </select> <br>
    简介：<textarea rows="5" cols="52" name="introduce"></textarea>
    <?php echo "<span class='error'>" . $introduceError . "</span>"; ?> <br>
    定价：<input type="text" size="10" name="price"/>元(最高精确到小数点后两位)
    <?php echo "<span class='error'>" . $priceError . "</span>"; ?> <br>
    <input type="submit" value="提交"/>
</form>

<?php
if($isExist==true){
    echo "<span class='error'>".'书籍上架申请提交失败，由于该作者同名书籍已提交上架申请或已上架至本店'."</span>";
}
if($applyResult==true){
    echo "<span class='success'>".'书籍上架申请提交成功！'."</span>";
}
?>

<a href="/application/"><input type="button" value="返回"/></a>
