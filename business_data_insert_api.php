<?php
require __DIR__. '/__admin_required.php';
require __DIR__. '/__connect_db.php';

$result = [
    'success' => false, //預設值
    'code' => 400,
    'info' => '沒有輸入酒商名',
    'post' => $_POST,
];

# 如果沒有輸入必要欄位, 就離開
if(empty($_POST['name'])){ //empty是不是空值 不要用issert 空值也算一個值
    echo json_encode($result, JSON_UNESCAPED_UNICODE); //Json不要編碼Unicode
    exit;
}

$sql = "INSERT INTO `business`
        (`name`, `sort`, `address`, `vat`, `principal`, `phone`, `email`)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql);

$stmt->execute([ //準備要執行的SQL語句並返回一個 PDOStatement對象
    $_POST['name'],
    $_POST['sort'],
    $_POST['address'],
    $_POST['vat'],
    $_POST['principal'],
    $_POST['phone'],
    $_POST['email'],
]);

if($stmt->rowCount()==1){
    $result['success'] = true;
    $result['code'] = 200;
    $result['info'] = '新增成功';
} else {
    $result['code'] = 420;
    $result['info'] = '新增失敗';
}

//echo $stmt->rowCount(); //返回受上一個 SQL 語句影響的行數

echo json_encode($result, JSON_UNESCAPED_UNICODE);