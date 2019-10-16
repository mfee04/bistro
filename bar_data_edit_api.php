<?php
require __DIR__. '/__admin_required.php';
require __DIR__ . '/__connect_db.php';
//json除錯
$result = [
    'success' => false,
    'code' => 404,
    'info' => '輸入錯誤',
    'post' => $_POST,
];

//判斷必要欄位沒填  Todo:前面js可擋(未寫)
if (
    empty($_POST['name']) or
    empty($_POST['phone']) or
    empty($_POST['address'])
) {
    $result['info'] = '必要欄位未填';
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}
//檢查post進來type傳進來的值
$arr=['日式','西式','義式','lounge_bar','專門調酒','居酒屋','漢堡店','運動酒吧','夜店舞廳'];              
for($i=0 ; $i<count($arr) ; $i++){

    if(! isset($_POST[$arr[$i]])){
        $_POST[$arr[$i]]='';
        }
}
//設定路徑
$upload_dir = 'lib/images/bar/uploads/';
//允許圖片格式
$allowed_type = [
    'image/jpg',
    'image/png',
    'image/jpeg'
];

//設定編碼檔案後的副檔名
$ext = [
    'image/png' => '.png',
    'image/jpeg' => '.jpg',
];

//判斷圖片是否有更改

if (!empty($_FILES['preview-pic']['name'])) {
    if (in_array($_FILES['preview-pic']['type'], $allowed_type)) {
        $new_filename = sha1(uniqid() . $_FILES['preview-pic']['name']);
        $new_ext = $ext[$_FILES['preview-pic']['type']];
        move_uploaded_file($_FILES['preview-pic']['tmp_name'], $upload_dir . $new_filename . $new_ext);


        //判斷type有沒有勾選
        // if (!empty($_POST['type'])) {
        //     // $str = implode(' ', $_POST['type']);
        //     $type_str = json_encode($_POST['type'], JSON_UNESCAPED_UNICODE);
        //     $sql = "UPDATE `allstore` SET `type`=?
        //         WHERE `sid`=?";
        //     $stmt = $pdo->prepare($sql);
        //     $stmt->execute([
        //         $type_str,
        //         $_POST['sid'],
        //     ]);
        // } else {
        //     $type_str = ' ';
        // }
        // 判斷有沒有勾選service
        if(! empty($_POST['service'])){
            $str=implode(' ',$_POST['service']);
            $service_str=json_encode($str,JSON_UNESCAPED_UNICODE);
        }else{
            $service_str=' ';
            $result['code']=480;
        };
            $sql="UPDATE `allstore` SET
                `name`=?, `phone`=?,`日式`=?,`西式`=?,`義式`=?, `lounge_bar`=?,
                `居酒屋`=?, `專門調酒`=?,`漢堡店`=?,`運動酒吧`=?,`夜店舞廳`=?, `address`=?, `preview-pic`=?,
                `company-id`=?, `owner`=?, `email`=?, 
                `how-much`=?, `service`=? WHERE `sid`=?";

            $stmt=$pdo->prepare($sql);
            $stmt->execute([
                $_POST['name'],
                $_POST['phone'],
                $_POST['日式'],
                $_POST['西式'],
                $_POST['義式'],
                $_POST['lounge_bar'],
                $_POST['居酒屋'],
                $_POST['專門調酒'],
                $_POST['漢堡店'],
                $_POST['運動酒吧'],
                $_POST['夜店舞廳'],
                $_POST['address'],
                $upload_dir.$new_filename.$new_ext,
                $_POST['company-id'],
                $_POST['owner'],
                $_POST['email'], 
                $_POST['how-much'], 
                $service_str,
                $_POST['sid'],
            ]);
        $day_sql = "UPDATE `store_information` SET
            `Monday`=?, `Tuesday`=?, `Wednesday`=?, `Thursday`=?, 
            `Friday`=?, `Saturday`=?, `Sunday`=?  WHERE `sid`=?";
        $d_stmt = $pdo->prepare($day_sql);
        $d_stmt->execute([
            $_POST['Mon'],
            $_POST['Tue'],
            $_POST['Wed'],
            $_POST['Tur'],
            $_POST['Fri'],
            $_POST['Sat'],
            $_POST['Sun'],
            $_POST['sid'],

        ]);

        if ($stmt or $d_stmt->rowCount() == 1) {
            $result['code'] = 220;
            $result['success'] = true;
            $result['info'] = '成功修改';
        } else {
            $result['info'] = "照片資料欄位不足";
            $result['code'] = 450;
        }
    }
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}else{

// 判斷有沒有勾選type
// if (!empty($_POST['type'])) {
//     $str = implode(' ', $_POST['type']);
//     $type_str = json_encode($_POST['type'], JSON_UNESCAPED_UNICODE);
//     $sql = "UPDATE `allstore` SET `type`=?
//             WHERE `sid`=?";
//     $stmt = $pdo->prepare($sql);
//     $stmt->execute([
//         $type_str,
//         $_POST['sid'],
//     ]);
// } else {
//     $type_str = '[]';
// }
// 判斷有沒有勾選service
if(! empty($_POST['service'])){
    $str=implode(' ',$_POST['service']);
    $service_str=json_encode($str,JSON_UNESCAPED_UNICODE);
}else{
    $service_str = ' ';
    $result['code']=420;
};
    $sql="UPDATE `allstore` SET
        `name`=?, `phone`=?,`日式`=?,`西式`=?,`義式`=?, `lounge_bar`=?
        ,`居酒屋`=?, `專門調酒`=?,`漢堡店`=?,`運動酒吧`=?,`夜店舞廳`=?, `address`=?, 
        `company-id`=?, `owner`=?, `email`=?, 
        `how-much`=?, `service`=? WHERE `sid`=?";

    $stmt=$pdo->prepare($sql);
    $stmt->execute([
        $_POST['name'],
        $_POST['phone'],
        $_POST['日式'],
        $_POST['西式'],
        $_POST['義式'],
        $_POST['lounge_bar'],
        $_POST['居酒屋'],
        $_POST['專門調酒'],
        $_POST['漢堡店'],
        $_POST['運動酒吧'],
        $_POST['夜店舞廳'],
        $_POST['address'],
        $_POST['company-id'],
        $_POST['owner'],
        $_POST['email'], 
        $_POST['how-much'], 
        $service_str,
        $_POST['sid'],

    ]);
$day_sql = "UPDATE `store_information` SET
        `Monday`=?, `Tuesday`=?, `Wednesday`=?, `Thursday`=?, 
        `Friday`=?, `Saturday`=?, `Sunday`=?  WHERE `sid`=?";
$d_stmt = $pdo->prepare($day_sql);
$d_stmt->execute([
    $_POST['Mon'],
    $_POST['Tue'],
    $_POST['Wed'],
    $_POST['Tur'],
    $_POST['Fri'],
    $_POST['Sat'],
    $_POST['Sun'],
    $_POST['sid'],

]);

if ($stmt or $d_stmt ->rowCount() == 1) {
    $result['success'] = true;
    $result['code'] = 210;
    $result['info'] = '成功修改';
} else {
    $result['info'] = '失敗';
}
//給後端看的json，沒上傳圖片但有更改內容
// if($stmt->rowCount()==1){
//     $result['code']=250;
//     $result['success']=true;
//     $result['info']='成功修改';
// }else{
//     $result['info']="資料欄位不足";
//     $result['code']=440;
// }
}
echo json_encode($result, JSON_UNESCAPED_UNICODE);
