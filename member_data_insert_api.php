<?php
require __DIR__ . '/__admin_required.php';
require __DIR__ . '/__connect_db.php';

$result = [
    'success' => false,
    'code' => 400,
    'info' => '沒有輸入姓名',
    'post' => $_POST,
];


#如果沒有輸入必要欄位就離開
if (empty($_POST['name'])) {
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

#看看身分證是否重複
if (isset($_POST['id_card'])) {
    $result['post'] = $_POST;
}
$s_sql = "SELECT 1 FROM `address_book` WHERE `id_card`=? ";
$s_stmt = $pdo->prepare($s_sql);
$s_stmt->execute([
    $_POST['id_card']
]);
if ($s_stmt->rowCount() == 1) {
    $result['code'] = 420;
    $result['info'] = '身分證已註冊';
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

$sql = "INSERT INTO `address_book`
(`name`,`m_level`,`m_sex`,`id_card`, `email`, `mobile`, `birthday`, `address`, `created_at`) 
VALUES (?,?,?,?,?,?,?,?,NOW())";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_POST['name'],
    $_POST['m_level'],
    $_POST['m_sex'],
    $_POST['id_card'],
    $_POST['email'],
    $_POST['mobile'],
    $_POST['birthday'],
    $_POST['address'],
]);

if ($stmt->rowCount() == 1) {
    $result['success'] = true;
    $result['code'] = 200;
    $result['info'] = '新增成功'; 
} else {
    $result['code'] = 400;
    $result['info'] = '新增失敗';
}



echo json_encode($result, JSON_UNESCAPED_UNICODE);
