<?php
// 应用目录为当前目录
define('APP_PATH', __DIR__ . '/');

// 加载核心文件
require(APP_PATH . 'core/Core.php');

// 加载配置文件
$config = require(APP_PATH . 'config/config.php');

// 实例化
(new core\core($config))->run();
