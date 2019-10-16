<?php
require __DIR__ . '/__admin_required.php';
require __DIR__ . '/__connect_db.php';
$page_name = 'member_data_insert';
$page_title = '新增資料';
?>

<?php include __DIR__. '/__html_head.php' ?>
<?php include __DIR__. '/__navbar.php' ?>

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
                <form name="form1" onsubmit="return checkForm()">
                    <div class="form-group">
                        <label for="name">姓名</label>
                        <input type="name" class="form-control" id="name" name="name">
                        <small id="nameHelp" class="form-text "></small>
                    </div>

                    <fieldset class="form-group">
                        <div class="row" style="display:none;"><!-- 權限暫時關閉 -->
                            <legend class="col-form-label col-sm-2 pt-0">權限</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="m_level" value="member" checked>
                                    <label class="form-check-label" for="gridRadios1">
                                        一般會員
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="m_level" value="bar">
                                    <label class="form-check-label" for="gridRadios1">
                                        酒吧
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="m_level" value="business" >
                                    <label class="form-check-label" for="gridRadios1">
                                        酒商
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>


                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">性別</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="m_sex" value="男" checked>
                                    <label class="form-check-label" for="gridRadios1">
                                        男性
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="m_sex" value="女">
                                    <label class="form-check-label" for="gridRadios1">
                                        女性
                                    </label>
                                </div>

                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group">
                        <label for="id_card">身分證字號</label>
                        <input type="text" class="form-control" id="id_card" name="id_card">
                        <small id="id_cardHelp" class="form-text "></small>
                    </div>
                    <div class="form-group">
                        <label for="email">電子郵件</label>
                        <input type="text" class="form-control" id="email" name="email">
                        <small id="emailHelp" class="form-text "></small>
                    </div>
                    <div class="form-group">
                        <label for="mobile">手機</label>
                        <input type="text" class="form-control" id="mobile" name="mobile">
                        <small id="mobileHelp" class="form-text "></small>
                    </div>
                    <div class="form-group">
                        <label for="birthday">生日</label>
                        <input type="text" class="form-control" id="birthday" name="birthday" value="2019-08-21">
                        <small id="birthdayHelp" class="form-text "></small>
                    </div>
                    <div class="form-group">
                        <label for="address">地址</label>
                        <input type="text" class="form-control" id="address" name="address">
                        <!-- <textarea class="form-control" name="address" id="address" cols="30" rows="10"></!--> 
                    </div>

                    <button type="submit" class="btn btn-custom" id="submit_btn">新增</button>
                    <input class="btn btn-custom" type="button" name="Submit" value="回上一頁" onClick="window.history.back();">
                </form>
            </div>
            <div class="alert alert-danger" role="alert" id="info_bar" style="display: none "></div>
        </div>
        <div class="col-md-3"></div>
    </div>
                    
    <script>
        let info_bar = document.querySelector('#info_bar');
        const submit_btn = document.querySelector('#submit_btn');
        let i, s, item;

        const require_fields = [{
                id: 'name',
                pattern: /^\S{2,}/,
                info: '請填寫正確姓名'
            },
            {
                id: 'id_card',
                pattern: /^[A-Za-z][12]\d{8}$/,
                info: '請填寫正確身份證字號'
            },
            {
                id: 'email',
                pattern: /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i,
                info: '請填寫正確電子信箱'
            },
            {
                id: 'mobile',
                pattern: /^09\d{2}\-?\d{3}\-?\d{3}$/,
                info: '請填寫正確手機號碼'
            },
        ];

        for (s in require_fields) {
            item = require_fields[s];
            item.el = document.querySelector('#' + item.id);
            item.infoEl = document.querySelector('#' + item.id + 'Help');
        }
        //拿到對應的input element(el),顯示訊息的small element (infoEl)


        function checkForm() {

            // TODO:先讓所有欄位外觀回復到原本狀態
            for (s in require_fields) {
                item = require_fields[s];
                item.el.style.border = '1px solid #ccc';
                item.infoEl.innerHTML = '';
            }
            info_bar.style.display='none';
            info_bar.innerHTML='';

            submit_btn.style.display='none';

            // TODO:檢查必填欄位,欄位值的格式

            let isPass = true;

            for (s in require_fields) {
                item = require_fields[s];

                if (!item.pattern.test(item.el.value)) {
                    item.el.style.border = '1px solid red';
                    item.infoEl.innerHTML = item.info;
                    isPass = false;
                }
            }

            let fd = new FormData(document.form1);
            if (isPass) {
                fetch('member_data_insert_api.php', {
                        method: 'POST',
                        body: fd,
                    })
                    .then(response => {
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
                                location.href = 'member_list.php';
                            }, 2000); //登錄成功 1秒回首頁
                        } else {
                            info_bar.className = 'alert alert-danger';
                        }
                    });
            } else {
                submit_btn.style.display = 'block';
            }
            return false; //表單不用傳統的post方式送出
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

<?php include __DIR__ . '/__html_foot.php' ?>