<?php
require __DIR__ . '/__admin_required.php';
require __DIR__ . '/__connect_db.php';
$page_name = 'bar_list';
$page_title = '資料列表';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$per_page = 999; //每頁呈現筆數
// $t_sql = "SELECT COUNT(1)FROM `allstore`"; //原本select後面接星號現在改為count(形式參數)，count會去找出資料總比數用()參數代替
// $t_stm = $pdo->query($t_sql);
// $totalRows = $t_stm->fetch(PDO::FETCH_NUM)[0]; //抓到每一欄以"1"的參數(陣列里1=>"所有欄位")
// //其索引值給[0]就可拿出筆數
// $totalPages = ceil($totalRows / $per_page); //(ceil無條件進位)

//店面type類型欄位
$arr = ['日式', '西式', '義式', 'lounge_bar', '專門調酒', '居酒屋', '漢堡店','運動酒吧','夜店舞廳'];

// if (empty($_GET['type'])) {
//     $t_sql = "SELECT COUNT(1)FROM `allstore`"; //原本select後面接星號現在改為count(形式參數)，count會去找出資料總比數用()參數代替
//     $sql = sprintf("SELECT * FROM `allstore` WHERE `uid`=%s LIMIT %s,%s",
//     $pdo->quote($_SESSION['loginUser']['sid']), ($page - 1) * $per_page, $per_page);

// } else if (!empty($_GET['type'])) {
//     $type=$_GET['type'];
//     $t_sql = "SELECT COUNT(1)FROM `allstore` WHERE $type=1"; //原本select後面接星號現在改為count(形式參數)，count會去找出資料總比數用()參數代替
//     $sql = sprintf("SELECT * FROM `allstore` ORDER BY %s=1 WHERE `uid`=%s DESC LIMIT %s,%s ",
//     $pdo->quote($_SESSION['loginUser']['sid']), $type, ($page - 1) * $per_page, $per_page);
//     }

//判斷身分是誰在用哪種SQL語法抓資料,抓資料的條件是用登入帳號的sid去撈擁有相同sid資料出來，再判斷是否有做搜尋type
switch ($_SESSION['loginUser']['m_level']) {
    case 'bar':
        if (empty($_GET['type'])) {
            $t_sql = "SELECT COUNT(1)FROM `allstore`"; //原本select後面接星號現在改為count(形式參數)，count會去找出資料總比數用()參數代替
            $sql = sprintf(
                "SELECT * FROM `allstore` WHERE `uid`=%s LIMIT %s,%s",
                $pdo->quote($_SESSION['loginUser']['sid']),
                ($page - 1) * $per_page,
                $per_page
            );
        } else if (!empty($_GET['type'])) {
            $type = $_GET['type'];
            $t_sql = "SELECT COUNT(1)FROM `allstore` WHERE $type=1"; //原本select後面接星號現在改為count(形式參數)，count會去找出資料總比數用()參數代替
            $sql = sprintf(
                "SELECT * FROM `allstore` ORDER BY %s=1 WHERE `uid`=%s DESC LIMIT %s,%s ",
                $pdo->quote($_SESSION['loginUser']['sid']),
                $type,
                ($page - 1) * $per_page,
                $per_page
            );
        }
        break;

    case 'admin':
        if (empty($_GET['type'])) {
            $t_sql = "SELECT COUNT(1)FROM `allstore`"; //原本select後面接星號現在改為count(形式參數)，count會去找出資料總比數用()參數代替
            $sql = sprintf("SELECT * FROM `allstore` LIMIT %s,%s", ($page - 1) * $per_page, $per_page);
        } else if (!empty($_GET['type'])) {
            $type = $_GET['type'];
            $t_sql = "SELECT COUNT(1)FROM `allstore` WHERE $type=1"; //原本select後面接星號現在改為count(形式參數)，count會去找出資料總比數用()參數代替
            $sql = sprintf("SELECT * FROM `allstore` ORDER BY %s=1 DESC LIMIT %s,%s ", $type, ($page - 1) * $per_page, $per_page);
        }

        break;
}
$t_stm = $pdo->query($t_sql);
$totalRows = $t_stm->fetch(PDO::FETCH_NUM)[0]; //抓到每一欄以"1"的參數(陣列里1=>"所有欄位")
$totalPages = ceil($totalRows / $per_page); //(ceil無條件進位)
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll();
//   echo $_SESSION['loginUser']['m_level']
?>

<!-- 讓瀏覽器清除暫存檔 -->
<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); ?>

<?php include __DIR__ . '/__html_head.php' ?>
<?php include __DIR__ . '/__navbar.php' ?>

    <div class="pull-left mr-3">
        <button type="button" class="btn btn-white" onclick="window.location.href='bar_data_insert.php'">新增酒吧</button>
    </div>
    <div class="pull-left mt-1">
        <form name="form2">
            <select name="type" id="type">
                <option value="*">請選擇餐廳類型</option>
                <option value="日式">日式</option>
                <option value="西式">西式</option>
                <option value="義式">義式</option>
                <option value="lounge_bar">lounge bar</option>
                <option value="專門調酒">專門調酒</option>
                <option value="居酒屋">居酒屋</option>
                <option value="漢堡店">漢堡店</option>
            </select>
        </form>
    </div>
    <div class="clearfix">
        <div class="pull-right tableTools-container"></div>
    </div>
    <div class="table-header">
        酒吧列表
    </div>

    <table id="data-table" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <!--不換行 class="text-nowrap"-->
                <th scope="col" class="center">
                    <label class="pos-rel checkboxeach">
                        <input type="checkbox" class="ace" id="checkAll" name="checkboxall" />
                        <span class="lbl"></span>
                    </label>
                </th>
                <th scope="col" class="box_td">#</th>
                <th scope="col" class="box_td">店名</th>
                <th scope="col" class="box_td">手機</th>
                <?php
                for ($i = 0; $i < count($arr); $i++) : ?>
                    <th scope="col" class="box_td">
                        <?= $arr[$i]; ?>
                    </th>
                <?php endfor; ?>
                <th scope="col" class="box_td">地址</th>
                <th scope="col" class="box_td">圖片</th>
                <th scope="col" class="box_td">營業人</th>
                <th scope="col" class="box_td">統編</th>
                <!-- <th scope="col" class="box_td">店面服務項目</th> -->
                <th scope="col" class="box_td">狀態</th>
                <th scope="col" style="text-align:center;" class="box_td">
                    <a class="red" href="javascript:delete_all()">
                        <i class="ace-icon fa fa-trash-o bigger-170"></i>
                    </a>
                </th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($rows as $r) { ?>
                <tr>
                    <td class="center">
                        <label class="pos-rel checkboxeach">
                            <input type="checkbox" class="ace" id="<?= 'readtrue' . $r['sid'] ?>" name=<?= 'readtrue' . $r['sid'] . '[]' ?> value='<?= $r['sid'] ?>' />
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td class="sid"><?= htmlentities($r['sid']) ?></td>
                    <td><?= htmlentities($r['name']) ?></td>
                    <td><?= htmlentities($r['phone']) ?></td>
                    <?php
                        for ($i = 0; $i < count($arr); $i++) : ?>
                        <td class="<?= $arr[$i] ?> text"><?= htmlentities($r[$arr[$i]]) == 1 ? '<i class="fa fa-check fa-sm"></i>' : '<i class="fa fa-times fa-xs"></i>'; ?>
                        </td>
                    <?php endfor; ?>
                    <td><?= htmlentities($r['address']) ?></td>
                    <td><img src="<?= htmlentities($r['preview_pic']) == true ? htmlentities($r['preview_pic']) : 'lib/images/bar/uploads/no_serve.jpg' ?>" alt="" height="60"></td>
                    <td><?= htmlentities($r['owner']) ?></td>
                    <td><?= htmlentities($r['company_id']) ?></td>
                    <!-- <td><? //= htmlentities(json_decode($r['service'])) 
                                    ?></td> -->
                    <td><!-- 上下架判斷 -->
                        <?php if ($r['block']) { ?>
                            <a href="javascript:event_pre('<?= htmlentities($r['name']) ?>',false)"><span class="label label-sm label-info arrowed ">
                                    允許中</a></span>
                        <?php } else { ?>
                            <a href="javascript:event_pre('<?= htmlentities($r['name']) ?>',true)"><span class="label label-sm label-inverse arrowed">
                                    關閉中
                            </a></span>
                        <?php } ?>
                        <!-- <span class="label label-sm label-success">C</span>
                                <span class="label label-sm label-warning">D</span> -->
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a class="green" href="bar_data_edit.php?sid=<?= $r['sid'] ?>">
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
    <!-- 上下架:1.dom裡面遷入javascript((放入店名或是sid),(1或0))來呼叫此fn ，第2步驟新增php的api檔案 裡面寫入就看各位資料庫欄怎麼設計 -->
    <script>
        function event_pre(name_b, value) {
            if (value) {
                if (confirm(`確定要開啟${name_b}的活動功能嗎?`)) {
                    $('.label-info').css('display', 'inline-block');
                    $('.label-inverse').css('display', 'none');
                    console.log('a' + ":" + $('.label-inverse'))
                    location.href = 'bar_data_block_api.php?name=' + name_b + '&value=' + '1'
                }
            } else {
                if (confirm(`確定要關閉${name_b}的活動功能嗎?`)) {
                    $('.label-info').css('display', 'none');
                    console.log('b' + ":" + $('.label-info'))
                    $('.label-inverse').css('display', 'inline-block');
                    location.href = 'bar_data_block_api.php?name=' + name_b + '&value=' + '0'
                }
            }
        };
    </script>

    <!-- type類型篩選  -->
    <script>
        $('#type').change(function() {
            $(this).closest("form").submit()
        })
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
                        null,
                        null,
                        null,
                        {
                            "bSortable": false
                        },
                        {
                            "bSortable": false
                        },
                        {
                            "bSortable": false
                        },
                        {
                            "bSortable": false
                        },
                        {
                            "bSortable": false
                        },
                        {
                            "bSortable": false
                        },
                        {
                            "bSortable": false
                        },
                        {
                            "bSortable": false
                        },
                        {
                            "bSortable": false
                        },
                        null,
                        {
                            "bSortable": false
                        }, //圖片
                        null,
                        null,
                        null,
                        {
                            "bSortable": false
                        } //此欄上的排序符號不顯示
                    ],
                    
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
                    iDisplayLength: 10, //每頁預設顯示數量
                    bProcessing: true, //開啟讀取伺服器資料時顯示正在載入中……

                })


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
                        "text": "<i class='fa fa-files-o bigger-110 pink'></i> <span class='hidden'>複製到剪貼簿</span>",
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

            setTimeout(function() {
                $($('.tableTools-container')).find('a.dt-button').each(function() {
                    var div = $(this).find(' > div').first();
                    if (div.length == 1) div.tooltip({
                        container: 'body',
                        title: div.parent().text()
                    });
                    else $(this).tooltip({
                        container: 'body',
                        title: $(this).text()
                    });
                });
            }, 500);

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
            $('#data-table > thead > tr > th input[type=checkbox], #data-table_wrapper input[type=checkbox]').eq(0).on('click', function() {
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

    <!-- 刪除 -->
    <script>
        // 單筆刪除
        function delete_one(sid) {
            if (confirm(`確定要刪除編號為 ${sid} 的資料嗎?`)) {
                location.href = 'bar_data_delete.php?sid=' + sid;
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
                if(confirm('確定要刪除這些資料嗎？')){
                    location.href = 'bar_data_delete_all.php?sids=' + sids.toString();
                }

            }
        }

    </script>

    <?php include __DIR__ . '/__html_foot.php' ?>
