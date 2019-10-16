<?php

require __DIR__.'/__admin_required.php';
require __DIR__.'/__connect_db.php';

$name_b=isset($_GET['name'])?$_GET['name']:'';
$value=isset($_GET['value'])?$_GET['value']:'';


$result=[
    'code'=>420,
    'info'=>'接收錯誤資料',
];


if(! empty($name_b) and isset($value)){
    $sql="UPDATE `business` SET `block`=? WHERE `name`=?";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([
       $value,
       $name_b
    ]);

    $result['code']=203;
    $result['info']='成功修改';
    
}else{
    $result['code']=480;
    $result['info']='只收到一筆資料';
}
// print_r($result);

header('Location: '.$_SERVER['HTTP_REFERER']);