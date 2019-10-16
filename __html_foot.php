                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    <div>

    <!-- 批次選取器JQ -->
    <script>
        let checkAll = $('#checkAll'); //控制所有勾選的欄位
        let checkBoxes = $('tbody .checkboxeach input'); //其他勾選欄位

        checkAll.click(function() {
            for (let i = 0; i < checkBoxes.length; i++) {
                checkBoxes[i].checked = this.checked;
            }
        })
    </script>

    <!-- 麵包屑 -->
    <script> 
        let breadcrumb_parent = '';//span .title
        let breadcrumb_child = '';
    
        $('a[data-toggle]').click(function(){//麵包屑第一層
            console.log($(this).find('.title').text())
            breadcrumb_parent = '<li>'+$(this).find('.title').text()+'</li>';
            localStorage.setItem('item1' , breadcrumb_parent);
        })
        $('.panel-body>ul>li').click(function(){//麵包屑第二層
            console.log($(this).text())
            breadcrumb_child ='<li>'+$(this).text()+'</li>'; 
            localStorage.setItem('item2' , breadcrumb_child);
        })
        $('.navbar-brand').click(function(){//點選首頁清空storage
            localStorage.removeItem('item1');
            localStorage.removeItem('item2');
        })

        let show_BP = localStorage.getItem('item1');
        let show_BC = localStorage.getItem('item2');
        // console.log(show_bread)
        $('.breadcrumb').append(show_BP)
        .append(show_BC)
    </script>  

</body>
</html>
