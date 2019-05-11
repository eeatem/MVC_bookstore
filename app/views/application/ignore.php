<?php
// 插入站内信
(new \app\models\messageFunc())->addApplicationResultMessage($applicationId, '0', $managerName);
$deleteResult = (new \app\models\ApplicationModel())->deleteApplication($applicationId);
if ($deleteResult == true) {
    echo "<span class='error'>该申请信息已被忽略！</span>";
}
?>

<a href="/application/"><input type="button" value="返回"></a>
