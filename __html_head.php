<!-- php 預判有無登入的session -->
<?php
if(! isset($_SESSION)){
	session_start();
}?>

<!DOCTYPE html>
<html>

<head>
    <title>Bistro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="lib/images/x-icon.ico" type="image/x-icon"/>

    <link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/style.css">
    <link rel="stylesheet" type="text/css" href="lib/css/flat-bistro.css">
    <link rel="stylesheet" type="text/css" href="lib/css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
    <link rel="stylesheet" type="text/css" href="lib/vegas/vegas.min.css">
    <style>
        @import url(https://fonts.googleapis.com/earlyaccess/notosanstc.css);
        * {	font-family: 'Noto Sans TC', sans-serif;}
    </style>

    <script type="text/javascript" src="lib/js/jquery.min.js"></script>
    <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="lib/js/app.js"></script>
    <script type="text/javascript" src="lib/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="lib/js/ace-elements.min.js"></script>
    <script type="text/javascript" src="lib/js/ace.min.js"></script>
    <script type="text/javascript" src="lib/js/jquery.dataTables.min.js"></script> 
    <script type="text/javascript" src="lib/js/jquery.dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="lib/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="lib/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="lib/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="lib/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="lib/js/buttons.colVis.min.js"></script>
    <script type="text/javascript" src="lib/js/dataTables.select.min.js"></script>
</head>

