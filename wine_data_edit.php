<?php
require __DIR__. '/__admin_required.php';
require __DIR__.'/__connect_db.php';
$page_name = 'wine_data_edit';
$page_title = '編輯資料';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: wine_list.php');
    exit;
}

$sql = "SELECT * FROM `wine_goods` WHERE `sid`=$sid";
$row = $pdo->query($sql)->fetch();
if (empty($row)) {
    header('Location: wine_list.php');
    exit;
}
?>

<?php include __DIR__ . '/__html_head.php' ?>
<?php include __DIR__ . '/__navbar.php' ?>

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
                <h5 class="card-title">編輯資料</h5>
                <form name="form1" onsubmit="return checkForm()" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="sid" value="<?= $row['sid'] ?>">
                    <div class="form-group">
                        <label for="name">酒名</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlentities($row['name']) ?>">
                        <small id="nameHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="kind">種類</label>
                        <input type="text" class="form-control" id="kind" name="kind" value="<?= htmlentities($row['kind']) ?>">
                        <small id="kindHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="producing_countries">生產國</label>
                        <input type="text" class="form-control" id="producing_countries" name="producing_countries" value="<?= htmlentities($row['producing_countries']) ?>">
                        <small id="producing_countriesHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="brand">酒莊/品牌</label>
                        <input type="text" class="form-control" id="brand" name="brand" value="<?= htmlentities($row['brand']) ?>">
                        <small id="brandHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="Production_area">產區</label>
                        <input type="text" class="form-control" id="Production_area" name="Production_area" value="<?= htmlentities($row['Production_area']) ?>">
                        <small id="Production_areaHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="years">年份</label>
                        <input type="text" class="form-control" id="years" name="years" value="<?= htmlentities($row['years']) ?>">
                        <small id="yearsHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="capacity">容量</label>
                        <input type="text" class="form-control" id="capacity" name="capacity" value="<?= htmlentities($row['capacity']) ?>">
                        <small id="capacityHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="concentration">濃度</label>
                        <input type="text" class="form-control" id="concentration" name="concentration" value="<?= htmlentities($row['concentration']) ?>">
                        <small id="concentrationHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="price">價錢</label>
                        <input type="text" class="form-control" id="price" name="price" value="<?= htmlentities($row['price']) ?>">
                        <small id="priceHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="Product_brief">商品簡述</label>
                        <input type="text" class="form-control" id="Product_brief" name="Product_brief" value="<?= htmlentities($row['Product_brief']) ?>">
                        <small id="Product_briefHelp" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="Brand_story">品牌故事</label>
                        <input type="text" class="form-control" id="Brand_story" name="Brand_story" value="<?= htmlentities($row['Brand_story']) ?>">
                        <small id="Brand_storyHelp" class="form-text"></small>
                    </div>
                    <!-- classification -->
                    <div class="form-group">
                        <label for="classification">產品分類</label>
                        <input type="text" class="form-control" id="classification" name="classification" value="<?= htmlentities($row['classification']) ?>">
                        <small id="classificationHelp" class="form-text"></small>
                    </div>
                    <!-- 上傳圖片 -->
                    <!-- <div class="form-group">
                            <label for="my_file">選擇上傳的圖檔</label>
                            <input type="file" class="form-control-file" id="my_file" name="my_file">
                        </div> -->

                    <!-- -------------------------------------------------------------------------------------- -->
                    <!-- 預覽當前資料庫圖片 及 更換圖片後即時預覽上傳檔案 -->
                    <input type="checkbox" id="enableUpload">
                    <input type="file" name="my_file" class="form-control-file" id="my_file" onchange="previewFile()" disabled><br>
                    <img class="img" id="img_t" src="<?= empty($row['my_file']) ? '' : 'lib/images/wine/uploads/' . $row['my_file'] ?>" style="margin:10px 0px; width:100px;"><br>

                    <button type="submit" class="btn btn-custom" id="submit_btn">修改</button>
                    <input class="btn btn-custom" type="button" name="Submit" value="回上一頁" onClick="window.history.back();">
                </form>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>

<script>
    let enableUpload = document.querySelector('#enableUpload');
    enableUpload.addEventListener('click', function(event) {
        if (event.target.checked) {
            document.querySelector('input[type=file]').removeAttribute('disabled');
        } else {
            document.querySelector('input[type=file]').setAttribute('disabled', 'disabled');
        }
    });

    function previewFile() {
        var preview = document.querySelector('#img_t');
        var file = document.querySelector('input[type=file]').files[0];
        var reader = new FileReader();

        reader.addEventListener("load", function() {
            preview.src = reader.result;
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>

<script>
    let info_bar = document.querySelector('#info_bar');
    const submit_btn = document.querySelector('#submit_btn');
    let i, s, item;
    const required_fields = [{
            id: 'name',
            pattern: /^\S{2,}/,
            info: '請填寫正確的酒名資料'
        },

    ];

    // 拿到對應的 input element (el), 顯示訊息的 small element (infoEl)
    for (s in required_fields) {
        item = required_fields[s];
        item.el = document.querySelector('#' + item.id);
        item.infoEl = document.querySelector('#' + item.id + 'Help');
    }

    //   /[A-Z]{2}\d{8}/i  統一發票

    function checkForm() {
        // 先讓所有欄位外觀回復到原本的狀態
        for (s in required_fields) {
            item = required_fields[s];
            item.el.style.border = '1px solid #CCCCCC';
            item.infoEl.innerHTML = '';
        }
        info_bar.style.display = 'none';
        info_bar.innerHTML = '';

        submit_btn.style.display = 'none';

        // 檢查必填欄位, 欄位值的格式
        let isPass = true;

        for (s in required_fields) {
            item = required_fields[s];

            if (!item.pattern.test(item.el.value)) {
                item.el.style.border = '1px solid red';
                item.infoEl.innerHTML = item.info;
                isPass = false;
            }
        }

        let fd = new FormData(document.form1);

        if (isPass) {
            fetch('wine_data_edit_api.php', {
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
                    info_bar.innerHTML = json.info;
                    //成功執行後跳轉頁面 1秒回酒類類表
                    if (json.success) {
                        info_bar.className = 'alert alert-success';
                        setTimeout(function() {     
                            location.href = 'wine_list.php';
                        }, 2000); 
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
                title: "確定修改？",
                html: "修改後仍可返回列表修改",
                type: "question",
                showCancelButton: true//顯示取消按鈕
            })
            .then(
                function (result) {
                    console.log(result)
                    if (result.value) {
                        //使用者按下「確定」要做的事
                        swal("完成!", "資料已經修改", "success");
                        checkForm();
                    } else if (result.dismiss === "cancel")
                    {
                        //使用者按下「取消」要做的事
                        swal("取消", "資料未被修改", "error");
                    }//end else  
                });//end then 
        })
    });
</script>

<?php include __DIR__ . '/__html_foot.php' ?>