<!DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>
    <title>Document</title>
    @include('layouts/head')
</head>

<script>
    $(document).ready(function() {
        $('#ListData').DataTable();
    });
</script>
<style>
    #loading {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        background-color: rgba(255, 255, 255, 0.8);
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        pointer-events: none;
    }

    #loading img {
        max-width: 100%;
        max-height: 100%;
    }
</style>

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
            <div class="main-content-inner">
                <div class="row">
                    <!-- Dark table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">回報MES工單查詢</h4>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label class="col-form-label">上線日 </label>
                                        <select id="launchDate" class="form-control" style="padding: 0;">
                                            <option>select
                                            </option>
                                            @foreach ($date as $item)
                                            <option value="{{ $item->year}}{{ $item->month}}">{{ $item->year}}.{{ $item->month}}
                                            </option>
                                            @endforeach
                                            @foreach ($lastyear as $item)
                                            <option value="{{ $item->lastyear}}">{{ $item->lastyear}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="col-form-label">交貨日 </label>
                                        <select id="deliveryDate" class="form-control" style="padding: 0;">
                                            <option>select
                                            </option>
                                            @foreach ($date as $item)
                                            <option value="{{ $item->year}}{{ $item->month}}">{{ $item->year}}.{{ $item->month}}
                                            </option>
                                            @endforeach
                                            @foreach ($lastyear as $item)
                                            <option value="{{ $item->lastyear}}">{{ $item->lastyear}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="data-tables datatable-dark">
                                    <table id="ListData" class="display text-center" style="width:100%">
                                        <thead class="text-capitalize" style=" background: darkgrey;">
                                            <tr>
                                                <th>remark2</th>
                                                <th>num_po</th>
                                                <th>num_ps</th>
                                                <th>cod_item</th>
                                                <th>Product</th>
                                                <th>PS5</th>
                                                <th>nam_items</th>
                                                <th>remark</th>
                                                <th>qty_pcs</th>
                                                <th>dat_begs</th>
                                                <th>dat_bega</th>
                                                <th>data_gap</th>
                                                <th>dat_ends</th>
                                                <th>sts_pcs</th>
                                                <th>sts_line</th>
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
    $(document).ready(function() {
        // 建立 Date 物件，自動獲取當前日期和時間
        var today = new Date();

        // 使用 getFullYear()、getMonth() 和 getDate() 方法取得年、月和日
        var year = today.getFullYear();
        var month = today.getMonth() + 1; // 月份是從 0 開始的，所以要加 1
        var day = today.getDate();

        // 根據需要格式化日期，例如：YYYYMMDD
        var formattedDate = '' + year + (month < 10 ? '0' + month : month) + (day < 10 ? '0' + day : day);

        // 在控制台中輸出日期
        console.log(formattedDate);

        $('#loading').hide();
        var table = $('#ListData').DataTable({
            columns: [{
                    "data": "remark2",
                    "title": "客戶"
                },
                {
                    'data': 'num_po',
                    "title": "訂單號碼"
                },
                {
                    'data': 'num_ps',
                    "title": "工單",
                },
                {
                    'data': 'cod_item',
                    "title": "產品型號",
                },
                {
                    'data': 'Product',
                    "title": "產品類型",
                },
                {
                    'data': 'PS5',
                    "title": "韌體版本",
                },
                {
                    'data': 'nam_items',
                    "title": "加工內容",
                },
                {
                    'data': 'remark',
                    "title": "規修",
                },
                {
                    'data': 'qty_pcs',
                    "title": "數量",
                },
                {
                    'data': 'dat_begs',
                    "title": "計畫日",
                },
                {
                    'data': 'dat_bega',
                    "title": "上線日",
                },
                {
                    'data': 'data_gap',
                    "title": "延遲天數",
                },
                {
                    'data': 'dat_ends',
                    "title": "交貨日",
                },
                {
                    'data': 'sts_pcs',
                    "title": "生產狀況",
                },
                {
                    'data': 'sts_line',
                    "title": "訂單狀況",
                },
                {
                    'data': 'PS6',
                    "title": "ECN",
                },
            ],
            columnDefs: [{
                targets: [7, 11, 12,13,14,15], // 所在的 index（從 0 開始）
                render: function(data, type, row, meta) {
                    switch (meta.col) {
                        case 7:
                            if (data === '0801') {
                                return '<span style="color:teal">' + data + '</span>';
                            } else {
                                return '<span style="color:red">' + data + '</span>';
                            }
                        case 11:
                            return '<span style="color:#EE7700">' + data + '</span>';
                        case 12:
                            if (data <= formattedDate) {
                                return '<span style="color:red">' + data + '</span>';
                            } else {
                                return '<span style="color:blue">' + data + '</span>';
                            }
                        case 13:
                            if (data === '30') {
                                return '<span style="color:blue">' + '生產中' + '</span>';
                            } else if (data === '90') {
                                return '<span style="color:blue">' + '完工' + '</span>';
                            } else if (data == '95') {
                                return '<span style="color:blue">' + '結案'+ '</span>';
                            } else if (data === '99') {
                                return '<span style="color:blue">' + '銷令'+ '</span>';
                            } else if (data === '10') {
                                return '<span style="color:blue">' + '計畫中'+ '</span>';
                            } else if (data === '00') {
                                return '<span style="color:blue">' + '尚未處理'+ '</span>';
                            } else if (data === '20') {
                                return '<span style="color:blue">' + '核定配料'+ '</span>';
                            } else {
                                return data
                            }
                        case 14:
                            if (data === '30') {
                                return '<span style="color:green">' + '通知生產' + '</span>';
                            } else if (data === '35') {
                                return '<span style="color:green">' + '已轉生產' + '</span>';
                            } else if (data === '95') {
                                return '<span style="color:green">' + '結案' + '</span>';
                            } else if (data === '99') {
                                return '<span style="color:green">' + '訂單結案' + '</span>';
                            } else if (data === '60') {
                                return '<span style="color:green">' + '全部驗收' + '</span>';
                            } else if (data === '00') {
                                return '<span style="color:green">' + '尚未處理' + '</span>';
                            } else if (data === '55') {
                                return '<span style="color:green">' + '已經出貨' + '</span>';
                            } else if (data === '48') {
                                return '<span style="color:green">' + '出貨通知' + '</span>';
                            } else if (data === '20') {
                                return '<span style="color:green">' + '訂單確認' + '</span>';
                            } else if (data === '52') {
                                return '<span style="color:green">' + '理貨完畢' + '</span>';
                            } else if (data === '90') {
                                return '<span style="color:green">' + '取消' + '</span>';
                            } else {
                                return data
                            }
                        case 15:
                            var ecn = "ECN"
                            if (data.indexOf(ecn) !== -1 ) {
                                return '<a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/upload/RD_ECRECN/ECN/' +data +'.pdf" target="_blank">' +data
            
                                
                            } else{
                                return '<a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/upload/RD_ECRECN/ECN/ECN-' +data +'.pdf" target="_blank">' +data                            }
               
                        default:
                            return data;
                    }
                }
            }]

        });
        $('#launchDate').on('change', function() {
            var selectedValue = $(this).val();
            $('#loading').show();
            $.ajax({
                url: 'mesRuncardListNotinAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    launch_date: selectedValue
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
                    console.log('no');
                    $('#loading').hide();
                }
            });

        });

        $('#deliveryDate').on('change', function() {
            var selectedValue = $(this).val();
            $('#loading').show();
            $.ajax({
                url: 'mesRuncardListNotinAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    delivery_date: selectedValue
                },
                success: function(response) {
                    console.log(response);
                    // 清空表格資料
                    table.clear();
                    // 將回應資料加入表格
                    table.rows.add(response);
                    // 重新繪製表格
                    table.draw();
                    // 處理 AJAX 請求成功後的回應
                    $('#loading').hide();
                },
                error: function(xhr, status, error) {
                    // 處理 AJAX 請求失敗後的回應
                    console.log('no');
                    $('#loading').hide();
                }
            });
        });
    });
</script>
</html>