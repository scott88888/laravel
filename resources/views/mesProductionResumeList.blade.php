<!DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>

    @include('layouts/head')
</head>

<script>
    $(document).ready(function() {
        $('#ListData').DataTable();
    });
</script>


<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div id="loading">
        <img src="{{ asset('images/icon/loading.gif') }}" alt="Loading...">
    </div>
    <div class="page-container">
        @include('layouts/sidebar')
        <div class="main-content">
            @include('layouts/headerarea')
            <div class="main5">
                <div class="row" style="margin: 0;">
                    <div class="col-12 mt-1" style="padding: 8px;">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">生產履歷查詢</h4>
                                <div class="form-row">
                                    <div class="col-md-2 mb-3">
                                        <label class="col-form-label" style="padding-top: 0;">查詢類型 </label>
                                        <select id="searchtype" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option>選擇</option>
                                            <option value="SEQ_ITEM">零件序號查詢</option>
                                            <option value="SEQ_MITEM">出廠序號查詢</option>
                                            <option value="PS2">MAC查詢</option>
                                            <option value="PS5">韌體版本 (ex: 4.2.92.71)</option>
                                            <option value="CLDS_COD_ITEM">產品型號查詢</option>
                                            <option value="NUM_PS">工單 (ex:GA200102026)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04">查詢內容</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-1">
                                        <label for="validationCustom04">快查</label>
                                        <div class="col">
                                            <button id="1ds" class="btn btn-primary">昨日</button>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="">快查</label>
                                        <div class="col">
                                            <button id="7ds" class="btn btn-primary">7天</button>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="">快查</label>
                                        <div class="col">
                                            <button id="30ds" class="btn btn-primary">30天</button>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <label for="">查詢</label>
                                        <button type="button" id="submit" class="btn btn-primary btn-block">送出</button>
                                    </div>
                                </div>
                            </div>
                            <div class="data-tables datatable-dark">
                                <table id="ListData" class="display text-center" style="width:100%">
                                    <thead class="text-capitalize" style=" background: darkgrey;">
                                        <tr>
                                            <th>NUM_PS</th>
                                            <th>NUM_ORD</th>
                                            <th>REMARK2</th>
                                            <th>DAT_BEGS</th>
                                            <th>DAT_BEGA</th>
                                            <th>DAT_DEL</th>
                                            <th>QTY_PCS</th>
                                            <th>CLDS_COD_ITEM</th>
                                            <th>SEQ_MITEM</th>
                                            <th>PS1</th>
                                            <th>PS2</th>
                                            <th>PS3</th>
                                            <th>SEQ_NO</th>
                                            <th>COMPQ_COD_ITEM</th>
                                            <th>SEQ_ITEM</th>
                                            <th>PS5</th>
                                            <th>PS6</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts/footer')
    </div>
    @include('layouts/settings')
</body>
@include('layouts/footerjs')

<script>
    var table;
    $(document).ready(function() {
        $('#loading').hide();
        table = $('#ListData').DataTable({
            ...tableConfig,
            columnDefs: [{
                    targets: [0],
                    data: "NUM_PS",
                    title: "工單"
                },
                {
                    targets: [1],
                    data: 'NUM_ORD',
                    title: "工令"
                },
                {
                    targets: [2],
                    data: 'REMARK2',
                    title: "客戶",
                },
                {
                    targets: [3],
                    data: 'DAT_BEGS',
                    title: "計畫日",
                },
                {
                    targets: [4],
                    data: 'DAT_BEGA',
                    title: "上線日",
                },
                {
                    targets: [5],
                    data: 'DAT_DEL',
                    title: "交貨日",
                },
                {
                    targets: [6],
                    data: 'QTY_PCS',
                    title: "數量",
                },
                {
                    targets: [7],
                    data: 'CLDS_COD_ITEM',
                    title: "產品型號",
                },
                {
                    targets: [8],
                    data: 'SEQ_MITEM',
                    title: "出廠序號",
                },
                {
                    targets: [9],
                    data: 'PS1',
                    title: "流程卡號",
                },
                {
                    targets: [10],
                    data: 'PS2',
                    title: "MAC",
                },
                {
                    targets: [11],
                    data: 'PS3',
                    title: "維修",
                },
                {
                    targets: [12],
                    data: 'SEQ_NO',
                    title: "流水號",
                },
                {
                    targets: [13],
                    data: 'COMPQ_COD_ITEM',
                    title: "零件料號",
                },
                {
                    targets: [14],
                    data: 'SEQ_ITEM',
                    title: "零件序號",
                },
                {
                    targets: [15],
                    data: 'PS5',
                    title: "韌體版本",
                },
                {
                    targets: [16],
                    data: 'PS6',
                    title: "倉位",
                }
            ]

        });

        $('#submit').click(function() {
            var search = $('#search').val();
            var searchtype = $('#searchtype').val();
            $('#loading').show();
            $.ajax({
                url: 'mesProductionResumeListAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    search: search,
                    searchtype: searchtype
                },
                success: function(response) {
                    // 清空表格資料
                    table.clear();
                    // 將回應資料加入表格
                    table.rows.add(response);
                    // 重新繪製表格
                    table.draw();
                    $('#loading').hide();
                    // 處理 AJAX 請求成功後的回應
                },
                error: function(xhr, status, error) {
                    // 處理 AJAX 請求失敗後的回應
                    console.log('no data');
                    $('#loading').hide();
                }
            });

        });


        setButtonClickEvent(1);
        setButtonClickEvent(7);
        setButtonClickEvent(30);

        function setButtonClickEvent(days) {
            $('#' + days + 'ds').click(function() {
                const today = new Date();
                const previousDate = new Date(today);
                previousDate.setDate(today.getDate() - days);


                loadData(getFormattedDate(previousDate));
            });
        }

        function getFormattedDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function loadData(date) {         
            var searchtype = 'DAT_BEGA';   
            $('#loading').show();         
            $.ajax({
                url: 'mesProductionResumeListDayAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    date: date,
                    searchtype: searchtype
                },
                success: function(response) {
                    console.log(response);
                    // 清空表格資料
                    table.clear();
                    // 將回應資料加入表格
                    table.rows.add(response);
                    // 重新繪製表格
                    table.draw();
                    $('#loading').hide();
                    // 處理 AJAX 請求成功後的回應
                },
                error: function(xhr, status, error) {
                    // 處理 AJAX 請求失敗後的回應
                    console.log('no data');
                    $('#loading').hide();
                }
            });
        }

    });
</script>

</html>