<?php
require __DIR__. '/__admin_required.php';
require __DIR__.'/__connect_db.php';

$result = [
    'success' => false,
    'code' => 400,
    'info' => '資料欄位不足',
    'post' => $_POST,
];

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
        $new_filename = sha1(uniqid() . $_FILES['my_file']['name']);
        $new_ext = $allowed_connection[$_FILES['my_file']['type']];
        move_uploaded_file($_FILES['my_file']['tmp_name'], $upload_dir . $new_filename . $new_ext);

        $sql = "UPDATE `wine_goods` SET
        `name`=?,
        `kind`=?,
        `producing_countries`=?,
        `brand`=?,
        `Production_area`=?,
        `years`=?,
        `capacity`=?,
        `concentration`=?,
        `price`=?,
        `Product_brief`=?,
        `Brand_story`=?,
        `classification`=?,
        `my_file`=? 
         WHERE `sid`=?";
       
       $stmt = $pdo->prepare($sql);
       
       $stmt->execute([
           $_POST['name'],
           $_POST['kind'],
           $_POST['producing_countries'],
           $_POST['brand'],
           $_POST['Production_area'],
           $_POST['years'],
           $_POST['capacity'],
           $_POST['concentration'],
           $_POST['price'],
           $_POST['Product_brief'],
           $_POST['Brand_story'],
           $_POST['classification'],
           $new_filename . $new_ext,  //資料庫圖片名   （編碼圖片名+副檔名）
           $_POST['sid'],
       ]);
       if ($stmt->rowCount() == 1) {
            $result['success'] = true;
            $result['code'] = 200;
            $result['info'] = '修改成功';
        } else {
            $result['code'] = 520;
            $result['info'] = '資料沒有修改';
        }

    } else {
        $result['code'] = 470;
        $result['info'] = '資料欄位不足';
    }

}else{
    $sql = "UPDATE `wine_goods` SET
    `name`=?,
    `kind`=?,
    `producing_countries`=?,
    `brand`=?,
    `Production_area`=?,
    `years`=?,
    `capacity`=?,
    `concentration`=?,
    `price`=?,
    `Product_brief`=?,
    `Brand_story`=?,
    `classification`=?
     WHERE `sid`=?";
   
   $stmt = $pdo->prepare($sql);
   
   $stmt->execute([
       $_POST['name'],
       $_POST['kind'],
       $_POST['producing_countries'],
       $_POST['brand'],
       $_POST['Production_area'],
       $_POST['years'],
       $_POST['capacity'],
       $_POST['concentration'],
       $_POST['price'],
       $_POST['Product_brief'],
       $_POST['Brand_story'],
       $_POST['classification'],
       $_POST['sid'],
   ]);
   if ($stmt->rowCount() == 1) {
        $result['success'] = true;
        $result['code'] = 200;
        $result['info'] = '修改成功';
    } else {
        $result['code'] = 420;
        $result['info'] = '資料沒有修改';
    }

}
echo json_encode($result, JSON_UNESCAPED_UNICODE);