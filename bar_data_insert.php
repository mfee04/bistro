<?php
require __DIR__.'/__admin_required.php';
require __DIR__.'/__connect_db.php';
$page_name = 'page_name';
$page_title = '新增資料';
?>

<?php include __DIR__. '/__html_head.php' ?>
<?php include __DIR__. '/__navbar.php' ?>

    <div class="row">
        <div class="col">
            <div class="alert alert-primary" role="alert" id="info_bar" style="display: none"></div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card-body">
                <h5 class="card-title">新增資料</h5>
                <form name="form1" onsubmit="return checkForm()" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">酒bar名稱</label>
                        <input name="name" type="text" class="form-control" id="name">
                        <small id="nameHelp" class="form-text "></small>
                    </div>

                    <div class="form-group">
                        <label for="phone">電話</label>
                        <input name="phone" type="number" class="form-control" id="phone">
                        <small id="phoneHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="address">地址</label>
                        <input name="address" type="text" class="form-control" id="address">
                        <small id="addressHelp" class="form-text"></small>
                    </div>
                    <!-- 轉換經緯 -->
                    <input type="hidden" id="latlng" name="latlng">


                    <h5>餐廳類型</h5>
                    <div class="form-check form-check-inline">
                        <?php
                        $arr = ['日式', '西式', '義式', 'lounge_bar', '專門調酒', '居酒屋', '漢堡店','運動酒吧','夜店舞廳'];
                        for ($i = 0; $i < count($arr); $i++) : ?>
                            <div class="form-check form-check-inline type d-flex">
                                <input name="<?= $arr[$i] ?>" type="checkbox" id="inlineCheckbox<?= $i ?>" value="1">
                                <label class="form-check-label" for="inlineCheckbox<?= $i ?>"><?= $arr[$i] ?></label>
                            </div>
                        <?php endfor; ?>

                    </div>
                    <!-- <div class="form-check form-check-inline">
                            <input name="type[]" type="checkbox" id="inlineCheckbox2" value="西式">
                            <label class="form-check-label" for="inlineCheckbox2">西式</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="type[]" type="checkbox" id="inlineCheckbox3" value="專門調酒">
                            <label class="form-check-label" for="inlineCheckbox3">專門調酒</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="type[]" type="checkbox" id="inlineCheckbox4" value="launch bar">
                            <label class="form-check-label" for="inlineCheckbox4">launch bar</label>
                        </div> -->
                    <div class="form-group">
                        <label for="preview-pic">預覽圖(暫留位子)</label><br>
                        <input name="preview-pic" type="file" id="preview-pic" onchange="previewFile()">
                        <div style="width:60%">
                            <img src="" alt="" class="show_pic" style="object-fit:scale-down; width:100%" >
                        </div>
                    </div>
                    <!--營業時間  -->
                    <h5>營業時間</h5>
                    <label class='checkbox-inline checkboxeach'>
                        <input id='timeAll' type='checkbox'>套用此欄至所有欄位
                        <!--  onclick="fillAll" -->
                    </label>
                    <div class="form-group">
                        <label for="time">星期一</label>
                        <input name="Mon" type="text" class="form-control time">
                        <small id="timeHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="time">星期二</label>
                        <input name="Tue" type="text" class="form-control time">
                        <small id="timeHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="time">星期三</label>
                        <input name="Wed" type="text" class="form-control time">
                        <small id="timeHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="time">星期四</label>
                        <input name="Tur" type="text" class="form-control time">
                        <small id="timeHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="time">星期五</label>
                        <input name="Fri" type="text" class="form-control time">
                        <small id="timeHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="time">星期六</label>
                        <input name="Sat" type="text" class="form-control time">
                        <small id="timeHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="time">星期天</label>
                        <input name="Sun" type="text" class="form-control time">
                        <small id="timeHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="email">email</label>
                        <input name="email" type="text" class="form-control" id="email">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>

                    <div>--選填--</div>
                    <div class="form-group">
                        <label for="owner">營業人</label>
                        <input name="owner" type="text" class="form-control" id="owner">
                        <!-- 確認無效字元 -->
                    </div>

                    <div class="form-group">
                        <label for="company-id">統編</label>
                        <input name="company-id" type="number" class="form-control" id="company-id">
                        <small id="company-idHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="money">參考價位</label>
                        <input name="how-much" type="number" class="form-control" id="money">
                    </div>
                    <h2>服務項目</h2>
                    <div class="form-check form-check-inline">
                        <input name="service[]" type="checkbox" id="inlineCheckbox10" value="停車位">
                        <label class="form-check-label" for="inlineCheckbox10">停車位</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="service[]" type="checkbox" id="inlineCheckbox11" value="夜間叫車">
                        <label class="form-check-label" for="inlineCheckbox11">夜間叫車</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="service[]" type="checkbox" id="inlineCheckbox12" value="無障礙廁所">
                        <label class="form-check-label" for="inlineCheckbox12">無障礙廁所</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="service[]" type="checkbox" id="inlineCheckbox13" value="DJ">
                        <label class="form-check-label" for="inlineCheckbox13">DJ</label>
                    </div>
                    <div>
                        <input type="checkbox" id="inlineCheckbox" value="">
                        <label class="form-check-label" for="inlineCheckbox">我同意平台相關隱私政策</label>
                    </div>
                    <button type="submit" class="btn btn-custom mt-3" id="submit_btn">新增</button>
                    <input class="btn btn-custom" type="button" name="Submit" value="回上一頁" onClick="window.history.back();">
                </form>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>

    <script>
        let info_bar = document.querySelector('#info_bar');
        let btn = document.querySelector('#submit_btn');
        let i, s, item;
        let latlng = document.querySelector('#latlng');
        
        // 地址轉經緯度
        latlng.addEventListener('blur',function(){
            fetch('https://maps.googleapis.com/maps/api/geocode/json?address='+address.value
            +'&key=AIzaSyAadMvzelzRIjMSAZyGh8UoUpckWI-8Q6w')
                .then(response=>{
                return  response.json()
                })
                .catch(function(error){
                    alert(error + " ,此地址無效")
                })
                .then(json=>{
                    console.log(json.results[0].geometry.location)
                    console.log(json.results[0].geometry)
                    console.log(json.results[0])
                    console.log(json)
                    latlng.value =json.results[0].geometry.location.lat+',' + json.results[0].geometry.location.lng
                    
                })
            
    })

        
        // -------批次填入
        let time_value
        $('.time').keyup(function() {
            time_value = $(this).val();
            console.log(time_value)
        })

        $('#timeAll').click(function() {
            $('.time').each(function() {
                if ($(this).val() == '') {
                    console.log(time_value)
                    $(this).val(time_value)
                }
            })
        })

        //----------圖片預覽
        function upload() {
            document.querySelector('#preview-pic').click();
        }

        function previewFile() {
            var preview = document.querySelector('.show_pic');
            var file = document.querySelector('input[type=file]').files[0];
            var reader = new FileReader();

            reader.addEventListener("load", function() {
                preview.src = reader.result;
            }, false);
            if (file) {

                reader.readAsDataURL(file);
            }
        }

        //正確格式定義
        const required_fields = [{
                id: 'name',
                pattern: /^\S{1,}/,
                info: '請填寫正確的姓名',
            },
            {
                id: 'email',
                pattern: /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i,
                info: '請填寫正確的 email 格式',
            },
            {
                id: 'phone',
                pattern: /^\(?\d{2}\)?[\s\-]?\d{4}\-?\d{4}|\d{3}$/,
                info: '請填寫正確的市話號碼',
            },
        ];

        // 拿到對應的 input element (el), 顯示訊息的 small element (infoEl)
        for (s in required_fields) {
            item = required_fields[s];
            item.el = document.querySelector('#' + item.id);
            item.infoEl = document.querySelector('#' + item.id + 'Help');
            // console.log(item.el);
        }



        //----------ajax
        function checkForm() {

            // 先讓所有欄位外觀回復到原本的狀態
            for (s in required_fields) {
                item = required_fields[s];
                item.el.style.border = '1px solid #CCCCCC';
                item.infoEl.innerHTML = ' ';
            }
            info_bar.style.display = 'none';


            submit_btn.style.display = 'none';

            // 檢查必填欄位, 欄位值的格式

            let isPass = true;
            for (s in required_fields) {
                item = required_fields[s];
                if (!item.pattern.test(item.el.value)) {
                    item.el.style.border = '2px solid red';
                    item.infoEl.innerHTML = item.info;
                    isPass = false;
                }
            }
            //店面類型判斷
            $(".type :checkbox").each(function() {
                if ($(".type :checkbox").prop('checked') !== 'false') {
                    return false;
                } else {
                    $(".type input").parent().css('border-bottom', '2px solid red');
                    isPass = false;
                }
            })
            //時間判斷格式
            let t_reg = /^(20|21|22|23|[0-1]\d)\:?[0-5]\d[\s|\~](20|21|22|23|[0-1]\d)\:?[0-5]\d$/
            $('.time').css('border', '1px solid #CCC')
            $('.time').each(function() {
                if (!$(this).val().match(t_reg)) {
                    console.log($(this).val())
                    console.log(t_reg)
                    $(this).css('border', '2px solid red').focus()
                        .siblings('small').text('時間格式:1200~1300').css('font-color', 'red')
                    isPass = false;
                }
            })

            let fd = new FormData(document.form1);

            if (isPass) {
                fetch('bar_data_insert_api.php', {
                        method: 'POST',
                        body: fd,
                    })
                    .then(response => {
                        return response.json();
                    })
                    .then(json => {
                        console.log(json);
                        submit_btn.style.display = 'none'; //防止訊號不好重複按鍵新增
                        info_bar.style.display = 'none'; //顯示提示訊息
                        info_bar.innerHTML = json.info; //將json資訊加入到訊息bar裡
                        if (json.success) {
                            info_bar.className = 'alert alert-success';
                            setTimeout(function() {
                                location.href = 'bar_list.php';
                            }, 2000); //登錄成功 1秒回首頁
                        } else {
                            info_bar.className = 'alert alert-danger';
                        }
                    });
            } else {
                submit_btn.style.display = 'block';

            }
            return false;
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


        $("#submit_btn").click(function(e) {
            //confirm dialog範例
            e.preventDefault();
            $(function() {
                swal({
                        title: "確定新增？",
                        html: "新增後仍可返回列表修改",
                        type: "question",
                        showCancelButton: true //顯示取消按鈕
                    })
                    .then(
                        function(result) {
                            console.log(result)
                            if (result.value) {
                                //使用者按下「確定」要做的事
                                swal("完成!", "資料已經新增", "success");
                                checkForm();
                            } else if (result.dismiss === "cancel") {
                                //使用者按下「取消」要做的事
                                swal("取消", "資料未被新增", "error");
                            } //end else  
                        }); //end then 
            })
        });
    </script>

<?php include __DIR__ . '/__html_foot.php' ?>