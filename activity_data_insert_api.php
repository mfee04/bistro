<?php
require __DIR__. '/__admin_required.php';
require __DIR__.'/__connect_db.php';
// 	json 溝通
$result = [
    'success' => false,
    'code' => 400,
    'info' => '沒有輸入主辦單位',
    'post' => $_POST,
];
# 如果沒有輸入必要欄位, 就離開 empty空字串拿到true
if(empty($_POST['organizer'])){
//json格式中文會跳脫 所以用JSON_UNESCAPED_UNICODE不讓他跳脫才能顯示中文
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    // var_dump($_FILES['picture[]']['name']);
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
// foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
//     $file_name = $key.$_FILES['files']['name'][$key];
//     $file_size =$_FILES['files']['size'][$key];
//     $file_tmp =$_FILES['files']['tmp_name'][$key];
//     $file_type=$_FILES['files']['type'][$key];
// }

// if (!empty($_FILES['picture'])) {
//     var_dump($_FILES['picture']);
//     foreach($_FILES['picture']['name'] as $v ){
//         $picture[] = $v;   
//      }
// }
//     $pic=json_encode($picture, JSON_UNESCAPED_UNICODE);

if (!empty($_FILES['picture'])) {
    // var_dump($_FILES['picture']['name'][$key]);
    foreach($_FILES['picture']['name'] as $key=>$v ){
         $new_filename = sha1(uniqid() . $_FILES['picture']['name'][$key]); //加密圖片檔（轉碼）
         $new_ext = $allowed_connection[$_FILES['picture']['type'][$key]]; //副檔名
         move_uploaded_file($_FILES['picture']['tmp_name'][$key], $upload_dir . $new_filename . $new_ext);  //串接 資料夾檔名+資料庫裡的轉碼檔名+副檔名
         $Pic_array[]=$new_filename . $new_ext;
         $Pic=json_encode($Pic_array, JSON_UNESCAPED_UNICODE);
     }
}

     
    //  echo $Pic;
// if (!empty($_FILES['picture'])) {
//     //var_dump($_FILES['picture']);
//     if (in_array($_FILES['picture']['type'], $allowed_types)) {
//         $new_filename = sha1(uniqid() . $_FILES['picture']['name']); //加密圖片檔（轉碼）
//         $new_ext = $allowed_connection[$_FILES['picture']['type']]; //副檔名
//         move_uploaded_file($_FILES['picture']['tmp_name'], $upload_dir . $new_filename . $new_ext);  //串接 資料夾檔名+資料庫裡的轉碼檔名+副檔名
//     }
// }

// NOW()是SQL function
/* 法二   盡量用prepare
$sql = sprintf("INSERT INTO `address_book`(
            `name`, `email`, `mobile`, `birthday`, `address`, `created_at`
            ) VALUES (%s, %s, %s, %s, %s, NOW())",
    $pdo->quote($_POST['name']),
    $pdo->quote($_POST['email']),
    $pdo->quote($_POST['mobile']),
    $pdo->quote($_POST['birthday']),
    $pdo->quote($_POST['address'])
);
echo $sql;
$stmt = $pdo->query($sql);
*/
// TODO: 檢查必填欄位, 欄位值的格式

$sql = "INSERT INTO `activity`(
        `organizer`,`organizer_Email`, `contact_number`, 
        `picture`, `name`,`activity_start_Date`, `activity_end_Date`, `location`, 
        `Introduction`,`price`,`Number_limit`, `created_at`
            ) VALUES (?,?, ?,?,?, ?,?, ?, ?,?, ?, NOW())";

$stmt = $pdo->prepare($sql);
// SQL injection後端資安(隱碼攻擊)
// prepare是去準備SQL樣板 還沒給值不會執行 會幫你做跳脫符號(資安) XSS
$stmt->execute([
        $_POST['organizer'],
        $_POST['organizer_Email'],
        $_POST['contact_number'],     
        // $new_filename . $new_ext,   //資料庫裡顯示的檔案名子 （不顯示資料夾名）
        $Pic,
        $_POST['name'],
        $_POST['activity_start_Date'],
        $_POST['activity_end_Date'],
        $_POST['location'],
        $_POST['Introduction'],
        $_POST['price'],
        $_POST['Number_limit'],        
]);

// echo $stmt->rowCount();
// rowCount(資料列數) 是1代表成功 0代表失敗
if($stmt->rowCount()==1){
    $result['success'] = true;
    $result['code'] = 200;
    $result['info'] = '新增成功';
} else {
    $result['code'] = 420;
    $result['info'] = '新增失敗';
}

echo json_encode($result, JSON_UNESCAPED_UNICODE);








