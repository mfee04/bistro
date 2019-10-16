<?php
// 多重刪除
require __DIR__. '/__admin_required.php';
require __DIR__.'/__connect_db.php';

$sids = isset($_GET['sids']) ? $_GET['sids'] : ''; //將陣列轉成字串
// $sids = explode(',', $sids);                    //將字串轉成陣列

// echo "DELETE FROM `wine_goods` WHERE `sid` IN ($sids)";  //檢查回傳出現甚麼東西
// exit;        //停止開關

// if (! empty($sids)) {
    $pdo->query("DELETE FROM `address_book` WHERE `sid` IN ($sids)"); //資料庫執行刪除動作
    
header('Location: '. $_SERVER['HTTP_REFERER']);