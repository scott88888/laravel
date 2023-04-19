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
                                <h4 class="header-title">生產履歷查詢</h4>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>查詢內容</label>
                                        <input class="form-control form-control-sm" id="search">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="col-form-label">查詢類型 </label>
                                    <select id="searchtype" class="form-control" style="padding: 0;">
                                        <option>select</option>
                                        <option value="SEQ_ITEM">零件序號查詢</option>
                                        <option value="SEQ_MITEM">出廠序號查詢</option>
                                        <option value="PS2">MAC查詢</option>
                                        <option value="PS5">韌體版本 (ex: 4.2.92.7739)</option>
                                        <option value="CLDS_COD_ITEM">產品型號查詢</option>
                                        <option value="NUM_PS">工單</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="col-md-2 my-1">
                                        <button id="submit" class="btn btn-primary">查詢</button>
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
    $(document).ready(function() {


        $('#loading').hide();
        var table = $('#ListData').DataTable({
            columns: [{
                    "data": "NUM_PS",
                    "title": "工單"
                },
                {
                    'data': 'NUM_ORD',
                    "title": "工令"
                },
                {
                    'data': 'REMARK2',
                    "title": "客戶",
                },
                {
                    'data': 'DAT_BEGS',
                    "title": "計畫日",
                },
                {
                    'data': 'DAT_BEGA',
                    "title": "上線日",
                },
                {
                    'data': 'DAT_DEL',
                    "title": "交貨日",
                },
                {
                    'data': 'QTY_PCS',
                    "title": "數量",
                },
                {
                    'data': 'CLDS_COD_ITEM',
                    "title": "產品型號",
                },
                {
                    'data': 'SEQ_MITEM',
                    "title": "出廠序號",
                },
                {
                    'data': 'PS1',
                    "title": "流程卡號",
                },
                {
                    'data': 'PS2',
                    "title": "MAC",
                },
                {
                    'data': 'PS3',
                    "title": "維修",
                },
                {
                    'data': 'SEQ_NO',
                    "title": "流水號",
                },
                {
                    'data': 'COMPQ_COD_ITEM',
                    "title": "零件料號",
                },
                {
                    'data': 'SEQ_ITEM',
                    "title": "零件序號",
                },
                {
                    'data': 'PS5',
                    "title": "韌體版本",
                },
                {
                    'data': 'PS6',
                    "title": "倉位",
                },
            ],
            // columnDefs: [{
            //     targets: [16], // 所在的 index（從 0 開始）
            //     render: function(data, type, row, meta) {
            //         var ecn = "ECN"
            //         if (data.indexOf(ecn) !== -1) {
            //             return '<a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/upload/RD_ECRECN/ECN/' + data + '.pdf" target="_blank">' + data
            //         } else {
            //             return '<a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/upload/RD_ECRECN/ECN/ECN-' + data + '.pdf" target="_blank">' + data
            //         }
            //     }
            // }]

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

    });
</script>

</html>