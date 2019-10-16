<?php
require __DIR__. '/__admin_required.php';
require __DIR__.'/__connect_db.php';

$result = [
    'success' => false,
    'code' => 400,
    'info' => '資料欄位不足',
    'post' => $_POST,
];


# 如果沒有輸入必要欄位
if(empty($_POST['organizer']) or empty($_POST['sid'])){
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}
$upload_dir = 'lib/images/activity/uploads/';

$allowed_types = [
    'image/png',
    'image/jpeg',
];
$allowed_connection = [
    'image/png' => '.png',
    'image/jpeg' => '.jpg',
];

if (!empty($_FILES['picture'])) {
    // var_dump($_FILES['picture']['name'][$key]);
    foreach($_FILES['picture']['name'] as $key=>$v ){
         $new_filename = sha1(uniqid() . $_FILES['picture']['name'][$key]); //加密圖片檔（轉碼）
         $new_ext = $allowed_connection[$_FILES['picture']['type'][$key]]; //副檔名
         move_uploaded_file($_FILES['picture']['tmp_name'][$key], $upload_dir . $new_filename . $new_ext);  //串接 資料夾檔名+資料庫裡的轉碼檔名+副檔名
         $Pic_array[]=$new_filename . $new_ext;
     }
}
     $Pic=json_encode($Pic_array, JSON_UNESCAPED_UNICODE);
     
// TODO: 檢查必填欄位, 欄位值的格式
# \[value\-\d\]
// $sql = "UPDATE `address_book` SET `sid`=?,`name`=?,`email`=?,`mobile`=?,`birthday`=?,`address`=?,`created_at`=? WHERE 1";

$sql = "UPDATE `activity` SET 
            `organizer`=?,
            `organizer_Email`=?,
            `contact_number`=?,
            `picture`=?,
            `name`=?,
            `activity_start_Date`=?,
            `activity_end_Date`=?,
            `location`=?,
            `Introduction`=?,
            `price`=?,
            `Number_limit`=?
            WHERE `sid`=?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
        $_POST['organizer'],
        $_POST['organizer_Email'],
        $_POST['contact_number'],
        // $_POST['picture'],
        $Pic,
        $_POST['name'],
        $_POST['activity_start_Date'],
        $_POST['activity_end_Date'],
        $_POST['location'],
        $_POST['Introduction'],
        $_POST['price'],
        $_POST['Number_limit'],
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








