<?php
require __DIR__. '/__admin_required.php';
require __DIR__.'/__connect_db.php';
$page_name = 'business_list'; //設定變數 給__navbar.php呼叫
$page_title = '資料列表';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; //用戶要看第幾頁 檢查有無變數 如果有設定就給值 沒有就設為1
$per_page = 999; //顯示筆數

switch ($_SESSION['loginUser']['m_level']) {
    case 'business':
        $sql = sprintf(
            "SELECT * FROM `business` WHERE `uid`=%s ORDER BY sid DESC LIMIT %s, %s",
            $pdo->quote($_SESSION['loginUser']['sid']),
            ($page - 1) * $per_page,
            $per_page
        // SQL語法裡的sid看是哪張表裡的對應欄位名稱
        );
        break;

    case 'admin':
        $sql = sprintf(
            "SELECT * FROM `business` WHERE `uid`=%s ORDER BY sid DESC LIMIT %s, %s",
            $pdo->quote($_SESSION['loginUser']['sid']),
            ($page - 1) * $per_page,
            $per_page
        // SQL語法裡的sid看是哪張表裡的對應欄位名稱
        );
        break;
}
$t_sql = "SELECT COUNT(1) FROM `business` "; //sql算出總筆數
$t_stmt = $pdo->query($t_sql);
$totalRows = $t_stmt->fetch(PDO::FETCH_NUM)[0];
$totalPages = ceil($totalRows/$per_page); //ceil無條件進位 總筆數/10=拿到總頁數
$sql = sprintf("SELECT * FROM `business` ORDER BY `sid` DESC LIMIT %s, %s", //LIMIT 限制筆數 {資料起始的index}, {要顯示幾筆資料}
              ($page-1)*$per_page, $per_page
);  //10筆資料為一分頁
$stmt = $pdo->query($sql);
?>


<!-- 讓瀏覽器清除暫存檔 -->
<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");?>

<?php include __DIR__ . '/__html_head.php' ?>
<?php include __DIR__ . '/__navbar.php' ?>
                                    
    <div class="pull-left">
        <button type="button" class="btn btn-white" onclick="window.location.href='business_data_insert.php'">新增酒商</button>
    </div>
    <div class="clearfix">
        <div class="pull-right tableTools-container"></div>
    </div>
    <div class="table-header">
        酒商列表
    </div>
    <table id="data-table" class="table table-striped table-bordered table-hover">
        <thead>
            <tr> <!--不換行 class="text-nowrap"-->
                <th scope="col" class="center">
                    <label class="pos-rel checkboxeach">
                        <input type="checkbox" class="ace" id="checkAll" name="checkboxall" />
                        <span class="lbl"></span>
                    </label>
                </th>
                <th scope="col">#</th>
                <th scope="col">酒商名</th>
                <th scope="col">分類</th>
                <th scope="col">地址</th>
                <th scope="col">統一編號</th>
                <th scope="col">負責人</th>
                <th scope="col">電話</th>
                <th scope="col">電子信箱</th>
                <th scope="col">狀態</th>
                <th scope="col" style="text-align:center;">
                    <a class="red" href="javascript:delete_all()">
                        <i class="ace-icon fa fa-trash-o bigger-170"></i>
                    </a>
                </th> 
            </tr>
        </thead>

        <tbody>
        <?php while($r=$stmt->fetch()) { ?> <!--拿到第一筆資料 如果為true 開始執行-->
            <tr>
                <td class="center">
                    <label class="pos-rel checkboxeach">
                        <input type="checkbox" class="ace" id="<?= 'readtrue' . $r['sid'] ?>" name=<?= 'readtrue' . $r['sid'] . '[]' ?> value='<?= $r['sid'] ?>' />
                        <span class="lbl"></span>
                    </label>
                </td>
                <td><?= $r['sid'] ?></td>
                <td><?= htmlentities($r['name']) ?></td>
                <td><?= htmlentities($r['sort']) ?></td>
                <td><?= htmlentities($r['address']) ?></td>
                <td><?= htmlentities($r['vat']) ?></td>
                <td><?= htmlentities($r['principal']) ?></td>
                <td><?= htmlentities($r['phone']) ?></td>
                <td><?= htmlentities($r['email']) ?></td>
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
                        <a class="green" href="business_data_edit.php?sid=<?= $r['sid'] ?>">
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
                    location.href = 'business_data_block_api.php?name=' + name_b + '&value=' + '1'
                }
            } else {
                if (confirm(`確定要關閉${name_b}的活動功能嗎?`)) {
                    $('.label-info').css('display', 'none');
                    console.log('b' + ":" + $('.label-info'))
                    $('.label-inverse').css('display', 'inline-block');
                    location.href = 'business_data_block_api.php?name=' + name_b + '&value=' + '0'
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
            .DataTable( {
                bAutoWidth: true, //自適應寬度 
                "aoColumns": [ //初始化要顯示的列 
                    { "bSortable": false }, //此欄上的排序符號不顯示
                    null, null,null, null, null, null, null, null, null,
                    { "bSortable": false } //此欄上的排序符號不顯示
                ],
                "aaSorting": [1,'asc'], //排序asc或desc [1,'asc']
                select: {
                    style: 'multi' //樣式
                }, 
                // oSearch: {"sSearch": "Search..."},
                searching: true, //搜尋框，不顯示
                bPaginate: true,//分頁工具條顯示
                bLengthChange: true, //改變每頁顯示資料數量，不顯示
                aLengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]], //每頁顯示記錄選單選項
                iDisplayLength: 5,  //每頁預設顯示數量
                bProcessing: true, //開啟讀取伺服器資料時顯示正在載入中……
            } );

            $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
            
            new $.fn.dataTable.Buttons( myTable, {
                buttons: [
                    {
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
            } );
            myTable.buttons().container().appendTo( $('.tableTools-container') );
            
            //style the message box
            var defaultCopyAction = myTable.button(1).action();
            myTable.button(1).action(function (e, dt, button, config) {
                defaultCopyAction(e, dt, button, config);
                $('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
            });
            
            var defaultColvisAction = myTable.button(0).action();
            myTable.button(0).action(function (e, dt, button, config) {
                
                defaultColvisAction(e, dt, button, config);
                
                if($('.dt-button-collection > .dropdown-menu').length == 0) {
                    $('.dt-button-collection')
                    .wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
                    .find('a').attr('href', '#').wrap("<li />")
                }
                $('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
            });
        
            setTimeout(function() {
                $($('.tableTools-container')).find('a.dt-button').each(function() {
                    var div = $(this).find(' > div').first();
                    if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
                    else $(this).tooltip({container: 'body', title: $(this).text()});
                });
            }, 500);
            
            myTable.on( 'select', function ( e, dt, type, index ) {
                if ( type === 'row' ) {
                    $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
                }
            } );
            myTable.on( 'deselect', function ( e, dt, type, index ) {
                if ( type === 'row' ) {
                    $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
                }
            } );
        
            //table checkboxes
            $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
            
            //select/deselect all rows according to table header checkbox
            $('#data-table > thead > tr > th input[type=checkbox], #data-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
                var th_checked = this.checked;//checkbox inside "TH" table header
                
                $('#data-table').find('tbody > tr').each(function(){
                    var row = this;
                    if(th_checked) myTable.row(row).select();
                    else  myTable.row(row).deselect();
                });
            });
            
            //select/deselect a row when the checkbox is checked/unchecked
            $('#data-table').on('click', 'td input[type=checkbox]' , function(){
                var row = $(this).closest('tr').get(0);
                if(this.checked) myTable.row(row).deselect();
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
                location.href = 'business_data_delete.php?sid=' + sid;
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
                    location.href = 'business_data_delete_all.php?sids=' + sids.toString();
                }

            }
        }

    </script>

<?php include __DIR__ . '/__html_foot.php' ?>