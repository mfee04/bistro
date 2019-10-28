<?php

// $db_host = 'db4free.net:3306';
// $db_name = 'bistro';
// $db_user = 'bistro204';
// $db_pass = 'bistro204';
$db_host = 'localhost';
$db_name = 'bistro';
$db_user = 'root';
$db_pass = '';
$dsn = "mysql:host={$db_host};dbname={$db_name}";

//pdo連線設定
$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //錯誤報告;拋出 exceptions 異常
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //設置默認的提取模式
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8 COLLATE utf8_unicode_ci"
];

$pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);

if(! isset($_SESSION)){
    session_start();
}