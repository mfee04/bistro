<?php
require __DIR__. '/__admin_required.php';
require __DIR__.'/__connect_db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0; //intval() 函數用於獲取變量的整數值

if(! empty($sid)){ //sid不為空值時
    $sql = "DELETE FROM `business` WHERE `sid`=$sid"; //sql刪除語法
    $pdo->query($sql); //執行並查詢，查詢後只回傳一個查詢結果的物件
}

header('Location: '. $_SERVER['HTTP_REFERER']); //頁面跳轉