<?php
require __DIR__.'/__admin_required.php';
require __DIR__.'/__connect_db.php';
$page_name = 'business_data_insert'; //設定變數 給__navbar.php呼叫
$page_title = '新增資料';

?>
<?php include __DIR__. '/__html_head.php' ?>
<?php include __DIR__. '/__navbar.php' ?>

<style>
    small.form-text{
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
                <!-- <form action="data_insert_api.php" method="post">  -->
                <!--<form>當提交表單時，發送表單數據到名為'data_insert_api.php'的文件-->
                <form name="form1" onsubmit="return checkForm()"> <!--不透過form傳送post 透過function傳送-->
                    <div class="form-group">
                        <label for="name">酒商名</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <small id="nameHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="sort">分類</label>
                        <input type="text" class="form-control" id="sort" name="sort">
                        <small id="sortHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="address">地址</label>
                        <input type="text" class="form-control" id="address" name="address">
                        <small id="addressHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="vat">統一編號</label>
                        <input type="text" class="form-control" id="vat" name="vat">
                        <small id="vatHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="principal">負責人</label>
                        <input type="text" class="form-control" id="principal" name="principal">
                        <small id="principalHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="phone">電話</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                        <small id="phoneHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="email">電子信箱</label>
                        <input type="text" class="form-control" id="email" name="email">
                        <small id="emailHelp" class="form-text"></small>
                    </div>

                    <button class="btn btn-custom" id="submit_btn">新增</button>
                    <input class="btn btn-custom" type="button" name="Submit" value="回上一頁" onClick="window.history.back();">
                </form>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>

    <script>
        let info_bar = document.querySelector('#info_bar');
        let i, s, item;

        //必填項目條件
        const required_fields = [
            {
                id: 'name',
                pattern: /^\S{2,}/,
                info: '請填寫正確的酒商名'
            },
            {
                id: 'email',
                pattern: /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i,
                info: '請填寫正確的 email 格式'
            },
            /*{
                id: 'mobile',
                pattern: /^09\d{2}\-?\d{3}\-?\d{3}$/, //正規表示法 用來檢查字串 \跳脫 ?可有可無 \-?代表中間-可有可無
                info: '請填寫正確的手機號碼格式'
            },*/
            //   /[A-Z]{2}\d{8}/i  統一發票
        ];
        
        // 拿到對應的 input element (el), 顯示訊息的 small element (infoEl)
        for(s in required_fields){
            item = required_fields[s];
            item.el = document.querySelector('#' + item.id); //選取條件陣列的ID
            item.infoEl = document.querySelector('#' + item.id + 'Help'); //選取small標籤
        }

        function checkForm() {
            // TODO: 先讓所有欄位外觀回復到原本的狀態
            for(s in required_fields) {
                item = required_fields[s];
                item.el.style.border = '1px solid #CCCCCC';
                item.infoEl.innerHTML = '';
            }

            // TODO: 檢查必填欄位, 欄位值的格式
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
                fetch('business_data_insert_api.php',{ //傳送給php, 使用參數設定值
                // fetch用來執行送出Request(要求)的工作，如果成功得到回應的話，
                //它會回傳一個帶有Response(回應)物件的已實現Promise物件
                    method:'POST',
                    body:fd,
                })
                    .then(response=>{
                        return response.json();
                    })
                    .then(json=>{
                        console.log(json);
                        submit_btn.style.display = 'none'; //防止訊號不好重複按鍵新增
                        info_bar.style.display = 'none'; //顯示提示訊息
                        info_bar.innerHTML = json.info; //將json資訊加入到訊息bar裡
                        if(json.success){
                            info_bar.className = 'alert alert-success'; //新增成功
                            setTimeout(function(){
                                location.href = 'business_list.php';
                            }, 2000); //登錄成功 1秒回首頁
                        } else {
                            info_bar.className = 'alert alert-danger'; //新增失敗
                        }
                    });
            }else {
                submit_btn.style.display = 'block'; //沒傳送成功 仍顯示按鈕
            }
            return false; // 表單不用傳統的 post 方式送出
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