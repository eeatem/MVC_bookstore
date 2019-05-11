<?php

use app\models\ApplicationModel;

if ($traderUpdateResult == true) {
    echo "<span class='success'>" . '权限修改成功：' . "</span>" . 用户： . "<span class='tips'>" . $userName . "</span>" . ' 已成为商家！';
    // 权限修改成功，同时删除审核记录
    (new ApplicationModel())->deleteApplication($applicationId);
}

if ($storeUpdateResult == true) {
    echo "<span class='success'>" . '权限修改成功：' . "</span>" . 用户： . "<span class='tips'>" . $userName . "</span>" . ' 已成功开店！';
    // 权限修改成功，同时删除审核记录
    (new ApplicationModel())->deleteApplication($applicationId);

}

if ($bookAddResult == true) {
    echo "<span class='success'>".'书籍上架成功！'."</span>";
    // 书籍上架成功，同时删除审核记录
    (new ApplicationModel())->deleteApplication($applicationId);
}
?>

<a href="/application/"><input type="button" value="返回"></a>
