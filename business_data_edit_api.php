<?php
require __DIR__. '/__admin_required.php';
require __DIR__. '/__connect_db.php';

$result = [
    'success' => false, //預設值
    'code' => 400,
    'info' => '資料欄位不足',
    'post' => $_POST,
];

# 如果沒有輸入必要欄位, 就離開
if(empty($_POST['name']) or empty($_POST['sid'])){ //empty是不是空值 不要用issert 空值也算一個值
    echo json_encode($result, JSON_UNESCAPED_UNICODE); //Json不要編碼Unicode
    exit;
}

// TODO: 檢查必填欄位, 欄位值的格式

# \[value\-\d\] 尋找取代的Reg正規表示法

$sql = "UPDATE `business` SET 
            `name`=?,
            `sort`=?,
            `address`=?,
            `vat`=?,
            `principal`=?,
            `phone`=?,
            `email`=?
            WHERE `sid`=?";

$stmt = $pdo->prepare($sql);

$stmt->execute([ //準備要執行的SQL語句並返回一個 PDOStatement對象
    $_POST['name'],
    $_POST['sort'],
    $_POST['address'],
    $_POST['vat'],
    $_POST['principal'],
    $_POST['phone'],
    $_POST['email'],
    $_POST['sid'],
]);

if($stmt->rowCount()==1){
    $result['success'] = true;
    $result['code'] = 200;
    $result['info'] = '修改成功';
} else {
    $result['code'] = 420;
    $result['info'] = '資料沒有修改';
}

echo json_encode($result, JSON_UNESCAPED_UNICODE);