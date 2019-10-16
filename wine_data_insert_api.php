<?php
require __DIR__. '/__admin_required.php';
require __DIR__.'/__connect_db.php';

$result = [
    'success' => false,
    'code' => 400,
    'info' => '沒有輸入姓名',
    'post' => $_POST,
];

# 如果沒有輸入必要欄位, 就離開
if (empty($_POST['name'])) {
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

// 上傳圖片
$upload_dir = 'lib/images/wine/uploads/';

$allowed_types = [
    'image/png',
    'image/jpeg',
];
$allowed_connection = [
    'image/png' => '.png',
    'image/jpeg' => '.jpg',
];



if (!empty($_FILES['my_file'])) {
    if (in_array($_FILES['my_file']['type'], $allowed_types)) {
        $new_filename = sha1(uniqid() . $_FILES['my_file']['name']); //加密圖片檔（轉碼）
        $new_ext = $allowed_connection[$_FILES['my_file']['type']]; //副檔名
        move_uploaded_file($_FILES['my_file']['tmp_name'], $upload_dir . $new_filename . $new_ext);  //串接 資料夾檔名+資料庫裡的轉碼檔名+副檔名
    }
}

// ---------------------------------------------------------------

$sql = "INSERT INTO `wine_goods`(
            `name`,
            `kind`,
            `producing_countries`,
            `brand`,
            `Production_area`, #5
            `years`,
            `capacity`,
            `concentration`,
            `price`,
            `Product_brief`,    #10
            `Brand_story`,
            `classification`,
            `my_file`) 
            VALUES (?,?,?,?,?
            ,?,?,?,?,?,
            ?,?,?)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_POST['name'],
    $_POST['kind'],
    $_POST['producing_countries'],
    $_POST['brand'],
    $_POST['Production_area'],  #5
    $_POST['years'],
    $_POST['capacity'],
    $_POST['concentration'],
    $_POST['price'],
    $_POST['Product_brief'],    #10
    $_POST['Brand_story'],
    $_POST['classification'],
    $new_filename . $new_ext,   //資料庫裡顯示的檔案名子 （不顯示資料夾名）
]);

if ($stmt->rowCount() == 1) {
    $result['success'] = true;
    $result['code'] = 200;
    $result['info'] = '新增成功';
} else {
    $result['code'] = 420;
    $result['info'] = '新增失敗';
}

echo json_encode($result, JSON_UNESCAPED_UNICODE);
