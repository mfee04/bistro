<?php
require __DIR__ . '/__admin_required.php';
require __DIR__ . '/__connect_db.php';

//json除錯
$result=[
    'success'=>false,
    'code'=>404,
    'info'=>'輸入錯誤',
    'post'=>$_POST
];
//判斷必要欄位沒填  Todo:前面js可擋(未寫)
if(empty($_POST['name']) or
    empty($_POST['phone']) or
    empty($_POST['address']
    )){ 
        $result['info']='必要欄位未填';
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
       exit;
}


//設定路徑
$upload_dir='lib/images/bar/uploads/';
//允許圖片格式
$allowed_type=[
    'image/jpg',
    'image/png',
    'image/jpeg'
];

//設定編碼檔案後的副檔名
$ext=[
    'image/png'=>'.png',
    'image/jpeg'=>'.jpg',
];

$arr=['日式','西式','義式','lounge_bar','專門調酒','居酒屋','漢堡店','運動酒吧', '夜店舞廳'];              
for($i=0 ; $i<count($arr) ; $i++){

    if(! isset($_POST[$arr[$i]])){
        $_POST[$arr[$i]]='';
        }
}

//判斷圖片上傳

if(! empty($_FILES['preview-pic']['name'])){
    if(in_array($_FILES['preview-pic']['type'],$allowed_type)){
        $new_filename=sha1(uniqid().$_FILES['preview-pic']['name']);
        $new_ext=$ext[$_FILES['preview-pic']['type']]; 
        move_uploaded_file($_FILES['preview-pic']['tmp_name'],$upload_dir.$new_filename.$new_ext);
            
            // if(! empty($_POST['type'])){
            //     $str=implode(' ',$_POST['type']);
            //     $type_str=json_encode($str,JSON_UNESCAPED_UNICODE);
   
            // }else{
            //     $type_str='[]';
            //     $result['code']=450;
            // };
            if(! empty($_POST['service'])){
                $str=implode(' ',$_POST['service']);
                $service_str=json_encode($str,JSON_UNESCAPED_UNICODE);
            }else{
                $service_str=' ';
                $result['code']=480;
            };
            $sql="INSERT INTO `allstore`(
                `name`, `phone`,`日式`,`西式`,`義式`, `lounge_bar`
                ,`居酒屋`, `專門調酒`,`漢堡店`,`運動酒吧`, `夜店舞廳`,`address`, `latlng`,
                `preview_pic`, `company_id`, `owner`, `email`, 
                `how_much`, `service`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

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
                $_POST['latlng'],
                $upload_dir.$new_filename.$new_ext,
                $_POST['company-id'],
                $_POST['owner'],
                $_POST['email'], 
                $_POST['how-much'], 
                $service_str
            ]);
        $day_sql="INSERT INTO `store_information`( 
                `Monday`, `Tuesday`, `Wednesday`, `Thursday`, 
                `Friday`, `Saturday`, `Sunday`) VALUES (?,?,?,?,?,?,?)";
            $d_stmt=$pdo->prepare($day_sql);
            $d_stmt->execute([
                $_POST['Mon'],
                $_POST['Tue'],
                $_POST['Wed'],
                $_POST['Tur'],
                $_POST['Fri'],
                $_POST['Sat'],
                $_POST['Sun'],
            ]);
            if($stmt or $d_stmt->rowCount()==1){
                $result['success']=true;
                $result['code']=210;
                $result['info']='新增成功';
            }else{
                $result['code']=440;
            };
            
    }
}else{

    // if(! empty($_POST['type'])){
    //     $str=implode(' ',$_POST['type']);
    //     $type_str=json_encode($str,JSON_UNESCAPED_UNICODE);
    // }else{
    //     $type_str = '[]';
    //     $result['code']=410;
    // };
    if(! empty($_POST['service'])){
        $str=implode(' ',$_POST['service']);
        $service_str=json_encode($str,JSON_UNESCAPED_UNICODE);
    }else{
        $service_str = ' ';
        $result['code']=420;
    };
    $sql="INSERT INTO `allstore`(
        `name`, `phone`,`日式`,`西式`,`義式`, `lounge_bar`
        ,`居酒屋`, `專門調酒`,`漢堡店`,`運動酒吧`,`夜店舞廳`, `address`, `latlng`,
        `company_id`, `owner`, `email`, 
        `how_much`, `service`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

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
        $_POST['latlng'],
        $_POST['company-id'],
        $_POST['owner'],
        $_POST['email'], 
        $_POST['how-much'], 
        $service_str
    ]);
    $day_sql="INSERT INTO `store_information`( 
        `Monday`, `Tuesday`, `Wednesday`, `Thursday`, 
        `Friday`, `Saturday`, `Sunday`) VALUES (?,?,?,?,?,?,?)";
    $d_stmt=$pdo->prepare($day_sql);
    $d_stmt->execute([
        $_POST['Mon'],
        $_POST['Tue'],
        $_POST['Wed'],
        $_POST['Tur'],
        $_POST['Fri'],
        $_POST['Sat'],
        $_POST['Sun'],
    ]);

    if($stmt or $d_stmt->rowCount()==1){
        $result['success']=true;
        $result['code']=210;
        $result['info']='新增成功';
    }else{
        $result['code']=490;
    };
}

//         if(! empty($_POST['type'])){
//             //$str=implode(' ', $_POST['type']);
//             $type_str=json_encode($_POST['type'], JSON_UNESCAPED_UNICODE);
            
//         } else {
//             $type_str = '[]';
//         }
//         if(! empty($_POST['service'])){
//             // $str=implode(' ', $_POST['service']);
//             $service_str=json_encode($_POST['service'],JSON_UNESCAPED_UNICODE);
//         }else{
//             $service_str='[]';
//         }
        
        
        
//         $sql="INSERT INTO `allstore`(
//         `sid`, `name`, `phone`, `opened-time`, `type`, `address`, 
//         `preview-pic`, `company-id`, `owner`, `email`, `how-much`, `service`) 
//         VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
      

  
//       $stmt=$pdo->prepare($sql);
//       $stmt->execute([
//           $_POST['sid'],
//           $_POST['name'],
//           $_POST['phone'],
//           $_POST['opened-time'],
//           $type_str,
//           $_POST['address'],
//           $upload_dir.$new_filename.$new_ext,
//           $_POST['company-id'],
//           $_POST['owner'],
//           $_POST['email'], 
//           120,//$_POST['how-much'], 
//           $service_str,
          
//          ]);
//          if($stmt->rowCount()==1){
//           $result['success']=true;
//           $result['code']=200;
//           $result['info']='成功修改';
//       }else{
//           $result['info']="資料欄位不足";
//       }

//     }
// }
//-------------------------------------------------
// else{
//     $sql="INSERT INTO `allstore`(
//         `sid`, `name`, `phone`, `opened-time`, `type`, `address`, 
//         `company-id`, `owner`, `email`, `how-much`, `service`) 
//         VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
    
//     $stmt=$pdo->prepare($sql);
//     $stmt->execute([
//         $_POST['name'],
//         $_POST['phone'],
//         $_POST['opened-time'],
//         $type_str,
//         $_POST['address'],
//         $_POST['company-id'],
//         $_POST['owner'],
//         $_POST['email'], 
//         120,//$_POST['how-much'], 
//         $service_str,
//         $_POST['sid']
//         ]);
//         if($stmt->rowCount()==1){
//             $result['success']=true;
//             $result['code']=210;
//             $result['info']='成功修改';
//         }else{
//             $result['info']='未修改';

//         }
// }


    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    
