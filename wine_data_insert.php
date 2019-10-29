<?php
require __DIR__ . '/__admin_required.php';
require __DIR__ . '/__connect_db.php';
$page_name = 'wine_data_insert';
$page_title = '新增資料';
?>

<?php include __DIR__ . '/__html_head.php' ?>
<?php include __DIR__ . '/__navbar.php' ?>

<style>
small {
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
            <form name="form1" onsubmit="return checkForm()" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">酒名</label>
                    <input type="text" class="form-control" id="name" name="name">
                    <small id="nameHelp" class="form-text"></small>
                </div>
                <div class="form-group">
                    <label for="kind">種類</label>
                    <input type="text" class="form-control" id="kind" name="kind">
                    <small id="kindHelp" class="form-text"></small>
                </div>
                <div class="form-group">
                    <label for="producing_countries">生產國</label>
                    <input type="text" class="form-control" id="producing_countries" name="producing_countries">
                    <small id="producing_countriesHelp" class="form-text"></small>
                </div>
                <div class="form-group">
                    <label for="brand">酒莊/品牌</label>
                    <input type="text" class="form-control" id="brand" name="brand">
                    <small id="brandHelp" class="form-text"></small>
                </div>
                <div class="form-group">
                    <label for="Production_area">產區</label>
                    <input type="text" class="form-control" id="Production_area" name="Production_area">
                    <small id="Production_areaHelp" class="form-text"></small>
                </div>
                <div class="form-group">
                    <label for="years">年份</label>
                    <input type="text" class="form-control" id="years" name="years">
                    <small id="yearsHelp" class="form-text"></small>
                </div>
                <div class="form-group">
                    <label for="capacity">容量</label>
                    <input type="text" class="form-control" id="capacity" name="capacity">
                    <small id="capacityHelp" class="form-text"></small>
                </div>
                <div class="form-group">
                    <label for="concentration">濃度</label>
                    <input type="text" class="form-control" id="concentration" name="concentration">
                    <small id="concentrationHelp" class="form-text"></small>
                </div>
                <div class="form-group">
                    <label for="price">價錢</label>
                    <input type="text" class="form-control" id="price" name="price">
                    <small id="priceHelp" class="form-text"></small>
                </div>
                <div class="form-group">
                    <label for="Product_brief">商品簡述</label>
                    <input type="text" class="form-control" id="Product_brief" name="Product_brief">
                    <small id="Product_briefHelp" class="form-text"></small>
                </div>
                <div class="form-group">
                    <label for="Brand_story">品牌故事</label>
                    <input type="text" class="form-control" id="Brand_story" name="Brand_story">
                    <small id="Brand_storyHelp" class="form-text"></small>
                </div>
                <div class="form-group">
                    <label for="classification">產品分類</label>
                    <input type="text" class="form-control" id="classification" name="classification">
                    <small id="classificationHelp" class="form-text"></small>
                </div>
                <!-- 上傳圖片 -->
                <div class="form-group">
                    <label for="my_file">選擇上傳的圖檔</label>
                    <input type="file" class="form-control-file" id="my_file" name="my_file" onchange="previewFile()">
                    <img id="img_t" src="" class="img_change" style="width:100px;"><br>
                    <small id="my_fileHelp" class="form-text"></small>
                </div>
                <button type="submit" class="btn btn-custom" id="submit_btn">新增</button>
                <input class="btn btn-custom" type="button" name="Submit" value="回上一頁" onClick="window.history.back();">
            </form>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>

<script>
//上傳圖片
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
let name = document.querySelector('#name');

function checkForm() {
    // TODO: 檢查必填欄位, 欄位值的格式
    if (name.value.length < 2) {
        name.style.border = '1px solid red';
        name.closest('.form-group').querySelector('small').innerText = '請填寫正確資料';
        return false;
    }

    let fd = new FormData(document.form1);

    fetch('wine_data_insert_api.php', {
            method: 'POST',
            // method: 'FILES',
            body: fd,
        })
        .then(response => {
            return response.json();
            console.log(response)
        })
        .then(json => {
            console.log(json);
            submit_btn.style.display = 'none'; //防止訊號不好重複按鍵新增
            info_bar.style.display = 'none'; //顯示提示訊息
            info_bar.innerHTML = json.info;
            if (json.success) {
                info_bar.className = 'alert alert-success';
                setTimeout(function() { //成功後跳轉頁面
                    location.href = 'wine_data_insert.php';
                }, 500); //成功執行 .5秒後刷新頁面
            } else {
                info_bar.className = 'alert alert-danger';
            }
        });

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
                    setTimeout(function() { //成功後跳轉頁面
                        location.href = 'wine_data_insert.php';
                    }, 100); //成功執行 0.1秒後刷新頁面
                }); //end then 
    })
});
</script>

<?php include __DIR__ . '/__html_foot.php' ?>