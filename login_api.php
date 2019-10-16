<?php
require __DIR__. '/__connect_db.php';

$result = [
    'success' => false, //預設值
    'code' => 400,
    'info' => '資料欄位不足',
    'post' => $_POST,
];

# 如果沒有輸入必要欄位, 就離開
if(empty($_POST['email']) or empty($_POST['password'])){ //empty是不是空值 不要用issert 空值也算一個值
    echo json_encode($result, JSON_UNESCAPED_UNICODE); //Json不要編碼Unicode
    exit;
}

$sql = "SELECT * FROM `members` WHERE `email`=? AND `password`=SHA1(?)"; //SHA1再次編碼

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_POST['email'],
    $_POST['password'],
]);
$row = $stmt->fetch();
if(! empty($row)){
    $_SESSION['loginUser'] = $row;

    $result['success'] = true;
    $result['code'] = 200;
    $result['info'] = '登入成功';
    $result['role'] = $_SESSION['loginUser']['m_level'];
} else {
    $result['code'] = 420;
    $result['info'] = '登入失敗';
}

echo json_encode($result, JSON_UNESCAPED_UNICODE);