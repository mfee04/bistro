<?php
require __DIR__. '/__admin_required.php';
require __DIR__.'/__connect_db.php';
$page_name = 'activity_data_insert';
$page_title = '新增資料';
?>
<?php include __DIR__. '/__html_head.php' ?>
<?php include __DIR__. '/__navbar.php' ?>
<style>
    small.form-text {
        color: red;
    }
</style>

    <div class="row justify-content-center" style="display: none">
        <div class="col-md-12">
            <div class="alert alert-primary" role="alert" id="info_bar"></div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card-body">
                <h5 class="card-title">新增資料</h5>
                <!-- <form action="data_insert_api.php" method="post"> -->
                <!-- method="POST" 可有可無? -->
                <form name="form1" enctype="multipart/form-data" method="POST" onsubmit="return checkForm()"> 
                    <div class="form-group">
                        <label for="organizer">** 主辦單位</label>
                        <input type="text" class="form-control" id="organizer" name="organizer">
                        <small id="organizerHelp" class="form-text"></small><!-- 提示文字 -->
                    </div>
                    <div class="form-group">
                        <label for="organizer_Email">聯絡郵箱</label>
                        <input type="text" class="form-control" id="organizer_Email" name="organizer_Email">
                        <small id="organizer_EmailHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="contact_number">連絡電話</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number">
                        <small id="contact_numberHelp" class="form-text"></small>
                    </div>
                    <!-- <div class="form-group">
                        <label for="picture">圖片</label>
                        <input type="text" class="form-control" id="picture" name="picture">
                        <small id="pictureHelp" class="form-text"></small>
                    </div> -->
                    <!-- 上傳圖片 -->
                    <!-- empty($stmt['preview-pic'])? '' : $stmt['type']     -->

                    <div class="form-group">
                            <label for="picture">選擇上傳的圖檔</label>                  
                            <input type="file" class="form-control-file" id="picture" name="picture[]" onchange="previewFiles()" multiple>
                            <!-- <img src="" height="200" alt="Image preview...">     -->
                            <div id="img_t"></div>
                            <!-- 一個<img>只能放一張圖 所以要用<div> -->
                            
                            <!--
                            <img id="img_t" src="lib/images/activity/uploads/<?= empty($stmt['picture[]'])? '' : $stmt['type']  ?>"  class="img_change" height="200" alt="Image preview..."><br>                             
                            -->
                            <small id="pictureHelp" class="form-text"></small>
                    </div> 
                        <!-- *9 -->

                    <!-- <div class="form-group">
                        <input id="browse" type="file" onchange="previewFiles()" name="picture[]" multiple >
                        <div id="preview"></div>
                    </div> -->

                    <!-- <form enctype="multipart/form-data" >
                            <input type="file" name="my_file">
                        <input type="submit" value="上傳圖片">
                    </form> -->

                    <div class="form-group">
                        <label for="activity_name">活動名稱</label>
                        <input type="text" class="form-control" id="activity_name" name="activity_name">
                        <small id="activity_nameHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="activity_start_Date">開始時間</label>
                        <input type="text" class="form-control" id="activity_start_Date" name="activity_start_Date" value="2019-9-1 18:00:00">
                        <small id="activity_start_DateHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="activity_end_Date">結束時間</label>
                        <input type="text" class="form-control" id="activity_end_Date" name="activity_end_Date" value="2019-9-1 18:00:00">
                        <small id="activity_end_DateHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="location">活動地點</label>
                        <input type="text" class="form-control" id="location" name="location">
                        <small id="locationHelp" class="form-text"></small>
                    </div>
                    <!-- ************************************************************* -->
                    <div class="form-group">
                        <label for="Introduction">活動介紹</label>
                        <textarea  class="form-control" id="Introduction"
                                    name="Introduction" cols="30" rows="10"></textarea>
                        <small id="IntroductionHelp" class="form-text"></small>
                    </div>
                    <!-- ************************************************************* -->
                    <div class="form-group">
                        <label for="price">價錢</label>
                        <input type="number" class="form-control" id="price" name="price" value="0">
                        <small id="priceHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="Number_limit">人數限制</label>
                        <input type="number" class="form-control" id="Number_limit" name="Number_limit" value="0">
                        <small id="Number_limitHelp" class="form-text"></small>
                    </div>

                    <button type="submit" class="btn btn-custom" id="submit_btn">新增</button>
                    <input class="btn btn-custom" type="button" name="Submit" value="回上一頁" onClick="window.history.back();">

                </form>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>

    <script>
        function previewFiles() {
            // console.log("1111111111111111111111111111");
            var files   = document.querySelector('input[type=file]').files;
            var preview = document.querySelector('#img_t');

        function readAndPreview(file) {
        //  console.log("22");
        // Make sure `file.name` matches our extensions criteria
        if ( /\.(jpe?g|png|gif)$/i.test(file.name) ) {
        // console.log("33");
                var reader = new FileReader();

            reader.addEventListener("load", function () {
                var image = new Image();
                image.height = 100;
                image.title = file.name;
                image.src = this.result;
                preview.appendChild( image );
            }, false);

            reader.readAsDataURL(file);
        }

        } 
        
            if (files) {
                [].forEach.call(files, readAndPreview);
            }

        }
    </script>

    <script>
        let info_bar = document.querySelector('#info_bar');
        const submit_btn = document.querySelector('#submit_btn');
        let i, s, item;
        const required_fields = [ //必填的欄位設定
            {
                id: 'organizer',
                pattern: /^\S{2,}/,
                info: '請填寫正確的姓名'
            },
            {
                id: 'organizer_Email',
                pattern: /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i,
                info: '請填寫正確的 email 格式'
            },
            // {
            //     id: 'contact_number',
            //     pattern: /^09\d{2}\-?\d{3}\-?\d{3}$/,
            //     info: '請填寫正確的手機號碼格式'
            // },
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
            info_bar.style.display = 'none'; //新增失敗會把"新增成功"刪掉
            info_bar.innerHTML = '';
            submit_btn.style.display = 'none';
            // 檢查必填欄位, 欄位值的格式
            let isPass = true;

            for(s in required_fields) { //有幾個跑幾次 一個個檢查有無通過
                item = required_fields[s];
                //test 是正規表示法的方法 符合會回傳true
                if(! item.pattern.test(item.el.value)){
                    item.el.style.border = '1px solid red';
                    item.infoEl.innerHTML = item.info; //沒過就顯示本身的訊息
                    isPass = false;
                }
            }
            // FormData是沒外觀的表單 把現有表單放進去
            let fd = new FormData(document.form1);
            //fetch第一個參數是要發送給誰 第二法是發送方法, 資料放http的body
            //執行順序是呼叫checkForm,交代fetch,立刻返回return false,完成才呼叫then
            if(isPass) {
                fetch('activity_data_insert_api.php', {
                    method: 'POST',
                    body: fd,
                })
                    .then(response => { //收到data_insert_api 最後的echo
                        return response.json();
                    })
                    .then(json => {
                        console.log(json);
                        submit_btn.style.display = 'none';
                        info_bar.style.display = 'none';
                        info_bar.innerHTML = json.info;
                        if (json.success) {
                            info_bar.className = 'alert alert-success';
                            setTimeout(function(){
                                location.href = 'activity_list.php';
                            }, 2000); //登錄成功 1秒回首頁
                        } else {
                            info_bar.className = 'alert alert-danger';
                        }
                    });
                } else {
                    submit_btn.style.display = 'block';
            }
            return false; // 表單不透過傳統的 post 方式送出
        }
    </script>
    
    <!--引用SweetAlert2.js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.0/sweetalert2.all.js"></script>
    <script type="text/javascript">
        //自訂預設值
        swal.setDefaults({
            confirmButtonText: "確定",
            cancelButtonText: "取消"
        });
        //swal.resetDefaults();//清空自訂預設值

 
        $("#submit_btn").click(function (e) {
                //confirm dialog範例
                e.preventDefault();
            $(function(){
                swal({
                    title: "確定新增？",
                    html: "新增後仍可返回列表修改",
                    type: "question",
                    showCancelButton: true//顯示取消按鈕
                })
                .then(
                    function (result) {
                        console.log(result)
                        if (result.value) {
                            //使用者按下「確定」要做的事
                            swal("完成!", "資料已經新增", "success");
                            checkForm();
                        } else if (result.dismiss === "cancel")
                        {
                            //使用者按下「取消」要做的事
                            swal("取消", "資料未被新增", "error");
                        }//end else  
                    });//end then 
            })
        });
    </script>

<?php include __DIR__. '/__html_foot.php' ?>
