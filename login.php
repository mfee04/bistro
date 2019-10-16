<?php
require __DIR__. '/__connect_db.php';
$page_name = 'login';
$page_title = '登入';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Bistro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="lib/images/x-icon.ico" type="image/x-icon"/>

    <link rel="stylesheet" href="lib/css/animate.min.css">
    <link rel="stylesheet" href="lib/css/style.css">
    <!-- <link rel="stylesheet" href="lib/css/flat-blue.css"> -->
    <link rel="stylesheet" href="lib/css/flat-bistro.css">
    <link rel="stylesheet" href="lib/css/bootstrap.min.css" />
    <link rel="stylesheet" href="lib/font-awesome/4.5.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="lib/css/ace.min.css" />
    <!-- 思源黑體 -->
    <style>
        @import url(https://fonts.googleapis.com/earlyaccess/notosanstc.css);
        * {	font-family: 'Noto Sans TC', sans-serif;}
        small {
            color: red;
        }
        .login-footer {
            color: white;
            text-decoration: none;
        }
    </style>
    
</head>

<body class="flat-bistro login-page" style="background: url(lib/images/loading-bg.jpg) no-repeat center center fixed;background-size: cover;overflow:hidden;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="alert alert-primary" role="alert" id="info_bar" style="display: none"></div>
        </div>
    </div>

    <div class="container">
        <div class="login-box">
            <div class="login-form row">
                <div class="col-sm-12 text-center login-header" style="margin-bottom:-8px;">
                    <img src="lib/images/logo.png" width="87%" alt="">
                    <!-- <h4 class="login-title">Bistro</h4> -->
                </div>
                <div class="col-sm-12">
                    <div class="login-body">
                        <!-- <div class="progress hidden" id="login-progress">
                            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                Log In...
                            </div>
                        </div> -->
                        <form name="form1" action="login_api.php" autocomplete="off" onsubmit="return checkForm()">
                            <div class="control form-group">
                                <input id="email" name="email" type="text" class="form-control" placeholder="admin@gmail.com" />
                                <small id="emailHelp" class="form-text"></small>
                            </div>
                            <div class="control form-group">
                                <input id="password" name="password" type="password" class="form-control" placeholder="．．．．．．" />
                                <small id="passwordHelp" class="form-text"></small>
                            </div>
                            <div class="login-button text-center">
                                <input type="submit" class="btn btn-primary" value="Login" id="submit_btn">
                            </div>
                        </form>
                    </div>
                    <div class="login-footer">
                        <span class="text-right"><a href="#" class="color-white" style="color: #999;">Forgot password?</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascript Libs -->
    <script src="lib/js/jquery.min.js"></script>
    <script src="lib/js/app.js"></script>
    <script src="lib/js/jquery-2.1.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="lib/js/ace-elements.min.js"></script>
    <script src="lib/js/ace.min.js"></script>
    <script src="lib/js/jquery.dataTables.min.js"></script>
    <script src="lib/js/jquery.dataTables.bootstrap.min.js"></script>
    <script src="lib/js/dataTables.buttons.min.js"></script>
    <script src="lib/js/buttons.flash.min.js"></script>
    <script src="lib/js/buttons.html5.min.js"></script>
    <script src="lib/js/buttons.print.min.js"></script>
    <script src="lib/js/buttons.colVis.min.js"></script>
    <script src="lib/js/dataTables.select.min.js"></script>

    <script>
        let info_bar = document.querySelector('#info_bar');
        const submit_btn = document.querySelector('#submit_btn');
        let i, s, item;
        const required_fields = [
            {
                id: 'email',
                pattern: /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i,
                info: '請填寫正確的 email 格式'
            },
        ];

        // 拿到對應的 input element (el), 顯示訊息的 small element (infoEl)
        for(s in required_fields){
            item = required_fields[s];
            item.el = document.querySelector('#' + item.id);
            item.infoEl = document.querySelector('#' + item.id + 'Help');
        }

        //   /[A-Z]{2}\d{8}/i  統一發票

        function checkForm(){
            // 先讓所有欄位外觀回復到原本的狀態
            for(s in required_fields) {
                item = required_fields[s];
                item.el.style.border = '1px solid #CCCCCC';
                item.infoEl.innerHTML = '';
            }
            info_bar.style.display = 'none';
            info_bar.innerHTML = '';

            submit_btn.style.display = 'none';

            // 檢查必填欄位, 欄位值的格式
            let isPass = true;

            for(s in required_fields) {
                item = required_fields[s];

                if(! item.pattern.test(item.el.value)){
                    item.el.style.border = '1px solid red';
                    item.infoEl.innerHTML = item.info;
                    isPass = false;
                }
            }

            let fd = new FormData(document.form1);

            if(isPass) {
                fetch('login_api.php', {
                    method: 'POST',
                    body: fd,
                })
                    .then(response => {
                        return response.json();
                    })
                    .then(json => {
                        console.log(json);
                        submit_btn.style.display = 'block';
                        info_bar.style.display = 'block';
                        info_bar.innerHTML = json.info;
                        if (json.success) {
                            // document.getElementById('#show-notification').show;
                            info_bar.className = 'alert alert-success';
                            setTimeout(function(){
                                location.href = 'index.php';
                            }, 1000); //登錄成功 1秒回首頁
                        } else {
                            info_bar.className = 'alert alert-danger';
                        }
                    });
            } else {
                submit_btn.style.display = 'block';
            }
            return false; // 表單不出用傳統的 post 方式送出
        }
    </script>
</body>

</html>


