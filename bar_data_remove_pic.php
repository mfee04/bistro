<?php
require __DIR__. '/__admin_required.php';
require __DIR__.'/__connect_db.php';

$sid=isset($_GET['sid'])?intval($_GET['sid']):0;

if(! empty($sid)){
    $sql="UPDATE `allstore` SET `preview-pic` = ? WHERE `sid` = ?";
    $stmt = $pdo->prepare($sql);
        $stmt->execute([ 
        'no_picture',
        $sid
        ]);
      unlink('lib/images/bar/uploads/'.$_POST['preview-pic'] ) ;
    }

// header('Location: '.$_SERVER['HTTP_REFERER']);