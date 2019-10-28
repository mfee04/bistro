<?php
require __DIR__ . '/__admin_required.php';
require __DIR__ . '/__connect_db.php';
$page_name = 'wine_data_list';
$page_title = '資料列表';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$per_page = 999; //顯示筆數

switch ($_SESSION['loginUser']['m_level']) {
    case 'wine_goods':
        $sql = sprintf(
            "SELECT * FROM `wine_goods` WHERE `uid`=%s ORDER BY sid DESC LIMIT %s, %s",
            $pdo->quote($_SESSION['loginUser']['sid']),
            ($page - 1) * $per_page,
            $per_page
            // SQL語法裡的sid看是哪張表裡的對應欄位名稱
        );
        break;

    case 'admin':
        $sql = sprintf(
            "SELECT * FROM `wine_goods` WHERE `uid`=%s ORDER BY sid DESC LIMIT %s, %s",
            $pdo->quote($_SESSION['loginUser']['sid']),
            ($page - 1) * $per_page,
            $per_page
            // SQL語法裡的sid看是哪張表裡的對應欄位名稱
        );
        break;
}

$t_sql = "SELECT COUNT(1) FROM `wine_goods` ";
$t_stmt = $pdo->query($t_sql);
$totalRows = $t_stmt->fetch(PDO::FETCH_NUM)[0]; // 拿到總筆數
$totalPages = ceil($totalRows / $per_page); // 取得總頁數
$sql = sprintf(
    "SELECT * FROM `wine_goods` ORDER BY `sid` ASC LIMIT %s, %s", //ASC 順序排列
    ($page - 1) * $per_page,
    $per_page
);
$stmt = $pdo->query($sql)
?>

<!-- 讓瀏覽器清除暫存檔 -->
<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache"); ?>

<?php include __DIR__ . '/__html_head.php' ?>
<?php include __DIR__ . '/__navbar.php' ?>

<link href="lib/css/lightbox.min.css" rel="stylesheet" />
<script src="lib/js/lightbox.js"></script>
<style>
.box_td {
    max-width: 70px;
    max-height: 70px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.thumbImage {
    max-width: 25px;
    max-height: 25px;
}

.d-flex {
    display: flex;
}

.text-a {
    text-align: center;
}

.Flex_box {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<div class="pull-left">
    <button type="button" class="btn btn-white" onclick="window.location.href='wine_data_insert.php'">新增酒類</button>
</div>
<div class="clearfix">
    <div class="pull-right tableTools-container"></div>
</div>
<div class="table-header">
    酒類列表
</div>
<table id="data-table" class="table table-striped table-bordered table-hover"
    style='overflow:auto ! important;width:100%; '>
    <thead>
        <tr>
            <!--不換行 class="text-nowrap"-->
            <th scope="col" class="center">
                <label class="pos-rel checkboxeach">
                    <input type="checkbox" class="ace" id="checkAll" name="checkboxall" />
                    <span class="lbl"></span>
                </label>
            </th>
            <th class="box_td" scope="col">#</th>
            <th class="box_td" scope="col">酒名</th>
            <th class="box_td" scope="col">種類</th>
            <th class="box_td" scope="col">生產國</th>
            <th class="box_td" scope="col">酒莊/品牌</th>
            <th class="box_td" scope="col">產區</th>
            <th class="box_td" scope="col">年份</th>
            <th class="box_td" scope="col">容量</th>
            <th class="box_td" scope="col">濃度</th>
            <th class="box_td" scope="col">價錢</th>
            <th class="box_td" scope="col">商品簡述</th>
            <th class="box_td" scope="col">品牌故事</th>
            <th class="box_td" scope="col">產品分類</th>
            <th style="display:none" class="box_td" scope="col">產品圖片</th>
            <th scope="col">狀態</th>
            <th scope="col" style="text-align:center;">
                <a class="red" href="javascript:delete_all()">
                    <i class="ace-icon fa fa-trash-o bigger-170"></i>
                </a>
            </th>
        </tr>
    </thead>

    <tbody>
        <?php while ($r = $stmt->fetch()) { ?>
        <!--拿到第一筆資料 如果為true 開始執行-->
        <tr>
            <td class="center">
                <label class="pos-rel checkboxeach">
                    <input type="checkbox" class="ace" id="<?= 'readtrue' . $r['sid'] ?>"
                        name=<?= 'readtrue' . $r['sid'] . '[]' ?> value='<?= $r['sid'] ?>' />
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="box_td"><?= $r['sid'] ?></td>
            <td><?= htmlentities($r['name']) ?></td> <!-- htmlentities，將標籤轉換為HTML文字，防止執行標籤 -->
            <td class="box_td"><?= htmlentities($r['kind']) ?></td> <!-- htmlentities，將標籤轉換為HTML文字，防止執行標籤 -->
            <td class="box_td"><?= htmlentities($r['producing_countries']) ?></td>
            <!-- htmlentities，將標籤轉換為HTML文字，防止執行標籤 -->
            <td class="box_td"><?= htmlentities($r['brand']) ?></td> <!-- htmlentities，將標籤轉換為HTML文字，防止執行標籤 -->
            <td class="box_td"><?= htmlentities($r['Production_area']) ?></td> <!-- htmlentities，將標籤轉換為HTML文字，防止執行標籤 -->
            <td class="box_td"><?= htmlentities($r['years']) ?></td> <!-- htmlentities，將標籤轉換為HTML文字，防止執行標籤 -->
            <td class="box_td"><?= htmlentities($r['capacity']) ?></td> <!-- htmlentities，將標籤轉換為HTML文字，防止執行標籤 -->
            <td class="box_td"><?= htmlentities($r['concentration']) ?></td> <!-- htmlentities，將標籤轉換為HTML文字，防止執行標籤 -->
            <td class="box_td"><?= htmlentities($r['price']) ?></td> <!-- htmlentities，將標籤轉換為HTML文字，防止執行標籤 -->
            <td class="box_td"><?= htmlentities($r['Product_brief']) ?></td> <!-- htmlentities，將標籤轉換為HTML文字，防止執行標籤 -->
            <td class="box_td"><?= htmlentities($r['Brand_story']) ?></td> <!-- htmlentities，將標籤轉換為HTML文字，防止執行標籤 -->
            <td class="box_td"><?= htmlentities($r['classification']) ?></td> <!-- htmlentities，將標籤轉換為HTML文字，防止執行標籤 -->
            <td style="display:none">
                <!-- 產品圖片 -->
                <a href="<?= 'lib/images/wine/uploads/' . $r['my_file'] ?>"
                    data-lightbox="<?= 'lib/images/wine/uploads/' . $r['my_file'] ?>" data-title="My caption"><img
                        class="thumbImage " src="<?= 'lib/images/wine/uploads/' . $r['my_file'] ?>"></a>
            </td>
            <td>
                <!-- 上下架判斷 -->
                <?php if ($r['block']) { ?>
                <a href="javascript:event_pre('<?= htmlentities($r['name']) ?>',false)"><span
                        class="label label-sm label-info arrowed ">
                        允許中</a></span>
                <?php } else { ?>
                <a href="javascript:event_pre('<?= htmlentities($r['name']) ?>',true)"><span
                        class="label label-sm label-inverse arrowed">
                        關閉中
                </a></span>
                <?php } ?>
                <!-- <span class="label label-sm label-success">C</span>
                            <span class="label label-sm label-warning">D</span> -->
            </td>
            <td>
                <div class="action-buttons">
                    <a class="green" href="wine_data_edit.php?sid=<?= $r['sid'] ?>">
                        <i class="ace-icon fa fa-pencil bigger-140"></i>
                    </a>
                    <a class="red" href="javascript:delete_one(<?= $r['sid'] ?>)">
                        <i class="ace-icon fa fa-trash bigger-140"></i>
                    </a>
                </div>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<!-- 活動功能開啟關閉 -->
<!-- 上下架:1.dom裡面遷入javascript((放入店名或是sid),(1或0))來呼叫此fn，第2步驟新增php的api檔案 -->
<script>
function event_pre(name_b, value) {
    if (value) {
        if (confirm(`確定要開啟${name_b}的活動功能嗎?`)) {
            $('.label-info').css('display', 'inline-block');
            $('.label-inverse').css('display', 'none');
            console.log('a' + ":" + $('.label-inverse'))
            location.href = 'wine_data_block_api.php?name=' + name_b + '&value=' + '1'
        }
    } else {
        if (confirm(`確定要關閉${name_b}的活動功能嗎?`)) {
            $('.label-info').css('display', 'none');
            console.log('b' + ":" + $('.label-info'))
            $('.label-inverse').css('display', 'inline-block');
            location.href = 'wine_data_block_api.php?name=' + name_b + '&value=' + '0'
        }
    }
};
</script>

<!-- datatables tableTools-container -->
<script type="text/javascript">
jQuery(function($) {
    //初始化dataTables
    var myTable =
        $('#data-table')
        .DataTable({
            bAutoWidth: true, //自適應寬度 
            "aoColumns": [ //初始化要顯示的列 
                {
                    "bSortable": false
                }, //此欄上的排序符號不顯示
                null, null, null, null, null,
                null, null, null, null, null,
                null, null, null, null, null,
                {
                    "bSortable": false
                } //此欄上的排序符號不顯示
            ],
            "aaSorting": [1, 'asc'], //排序asc或desc [1,'asc']
            select: {
                style: 'multi' //樣式
            },
            // oSearch: {"sSearch": "Search..."},
            searching: true, //搜尋框，不顯示
            bPaginate: true, //分頁工具條顯示
            bLengthChange: true, //改變每頁顯示資料數量，不顯示
            aLengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"]
            ], //每頁顯示記錄選單選項
            iDisplayLength: 5, //每頁預設顯示數量
            bProcessing: true, //開啟讀取伺服器資料時顯示正在載入中……
        });

    $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';

    new $.fn.dataTable.Buttons(myTable, {
        buttons: [{
                "extend": "colvis",
                "text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>顯示/隱藏 欄位</span>",
                "className": "btn btn-white btn-bold",
                columns: ':not(:first):not(:last)'
            },
            {
                "extend": "copy",
                "text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>複製到剪貼簿</span>",
                "className": "btn btn-white btn-bold"
            },
            {
                "extend": "csv",
                "text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>輸出CSV</span>",
                "className": "btn btn-white btn-bold"
            },
            {
                "extend": "excel",
                "text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
                "className": "btn btn-white btn-bold"
            },
            {
                "extend": "pdf",
                "text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
                "className": "btn btn-white btn-bold"
            },
            {
                "extend": "print",
                "text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>列印</span>",
                "className": "btn btn-white btn-bold",
                autoPrint: false,
                message: '' //This print was produced using the Print button for DataTables
            }
        ]
    });
    myTable.buttons().container().appendTo($('.tableTools-container'));

    //style the message box
    var defaultCopyAction = myTable.button(1).action();
    myTable.button(1).action(function(e, dt, button, config) {
        defaultCopyAction(e, dt, button, config);
        $('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
    });

    var defaultColvisAction = myTable.button(0).action();
    myTable.button(0).action(function(e, dt, button, config) {

        defaultColvisAction(e, dt, button, config);

        if ($('.dt-button-collection > .dropdown-menu').length == 0) {
            $('.dt-button-collection')
                .wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
                .find('a').attr('href', '#').wrap("<li />")
        }
        $('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
    });

    // setTimeout(function() {
    //     $($('.tableTools-container')).find('a.dt-button').each(function() {
    //         var div = $(this).find(' > div').first();
    //         if (div.length == 1) div.tooltip({
    //             container: 'body',
    //             title: div.parent().text()
    //         });
    //         else $(this).tooltip({
    //             container: 'body',
    //             title: $(this).text()
    //         });
    //     });
    // }, 500);

    myTable.on('select', function(e, dt, type, index) {
        if (type === 'row') {
            $(myTable.row(index).node()).find('input:checkbox').prop('checked', true);
        }
    });
    myTable.on('deselect', function(e, dt, type, index) {
        if (type === 'row') {
            $(myTable.row(index).node()).find('input:checkbox').prop('checked', false);
        }
    });

    //table checkboxes
    $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

    //select/deselect all rows according to table header checkbox
    $('#data-table > thead > tr > th input[type=checkbox], #data-table_wrapper input[type=checkbox]').eq(0).on(
        'click',
        function() {
            var th_checked = this.checked; //checkbox inside "TH" table header

            $('#data-table').find('tbody > tr').each(function() {
                var row = this;
                if (th_checked) myTable.row(row).select();
                else myTable.row(row).deselect();
            });
        });

    //select/deselect a row when the checkbox is checked/unchecked
    $('#data-table').on('click', 'td input[type=checkbox]', function() {
        var row = $(this).closest('tr').get(0);
        if (this.checked) myTable.row(row).deselect();
        else myTable.row(row).select();
    });

    $(document).on('click', '#data-table .dropdown-toggle', function(e) {
        e.stopImmediatePropagation();
        e.stopPropagation();
        e.preventDefault();
    });
})
</script>

<!-- 批次選取器JQ -->
<!-- <script>
        let checkAll = $('#checkAll'); //控制所有勾選的欄位
        let checkBoxes = $('tbody .checkboxeach input'); //其他勾選欄位

        checkAll.click(function() {
            for (let i = 0; i < checkBoxes.length; i++) {
                checkBoxes[i].checked = this.checked;
            }
        })
    </script> -->

<!-- JQ 批次選取器 -->
<!-- <script>
        let dataCount = $("tbody tr").length;
        $("tbody :checkbox").click(function() {
            let checked = $(this).prop("checked");
            let checkedCount = $("tbody :checked").length;
            console.log(checkedCount)
            if (checked) {
                $(":checked").closest("tr").css("background", "lightblue").css("transition", ".5s");

            } else {
                $(this).closest("tr").css("background", "transparent").css("transition", ".5s");
            }
            if (checkedCount == dataCount) {
                $("#checkAll").prop("checked", true).css("background", "lightblue").css("transition", ".5s");
            } else {
                $("#checkAll").prop("checked", false).css("background", "transparent").css("transition", ".5s");
            }
        })
        $("#checkAll").click(function() {
            let checkAll = $(this).prop("checked")
            $("tbody :checkbox").prop("checked", checkAll)
            if (checkAll) {
                $("tbody tr").addClass("active").css("background", "lightblue").css("transition", ".5s");
            } else {
                $("tbody tr").removeClass("active").css("background", "transparent").css("transition", ".5s");
            }
        });
    </script> -->

<!-- 刪除 -->
<script>
// 單筆刪除
function delete_one(sid) {
    if (confirm(`確定要刪除編號為 ${sid} 的資料嗎?`)) {
        location.href = 'wine_data_delete.php?sid=' + sid;
    }
}

// 多重刪除 
function delete_all() {
    let sids = [];
    checkBoxes.each(function() {
        if ($(this).prop('checked')) {
            sids.push($(this).val())
        }
    });
    if (!sids.length) {
        alert('沒有選擇任何資料');
    } else {
        if (confirm('確定要刪除這些資料嗎？')) {
            location.href = 'wine_data_delete_all.php?sids=' + sids.toString();
        }
    }
}
</script>

<!-- 搜尋欄功能 -->
<script>
(function(document) {
    'use strict';

    // 建立 LightTableFilter
    var LightTableFilter = (function(Arr) {

        var _input;

        // 資料輸入事件處理函數
        function _onInputEvent(e) {
            _input = e.target;
            var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
            Arr.forEach.call(tables, function(table) {
                Arr.forEach.call(table.tBodies, function(tbody) {
                    Arr.forEach.call(tbody.rows, _filter);
                });
            });
        }

        // 資料篩選函數，顯示包含關鍵字的列，其餘隱藏
        function _filter(row) {
            var text = row.textContent.toLowerCase(),
                val = _input.value.toLowerCase();
            row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
        }

        return {
            // 初始化函數
            init: function() {
                var inputs = document.getElementsByClassName('light-table-filter');
                Arr.forEach.call(inputs, function(input) {
                    input.oninput = _onInputEvent;
                });
            }
        };
    })(Array.prototype);

    // 網頁載入完成後，啟動 LightTableFilter
    document.addEventListener('readystatechange', function() {
        if (document.readyState === 'complete') {
            LightTableFilter.init();
        }
    });

})(document);
</script>

<?php include __DIR__ . '/__html_foot.php' ?>