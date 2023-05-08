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
                                <h4 class="header-title">入料逾期明細表</h4>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label class="col-form-label">排行月份(年)</label>
                                        <select id="searchtype" class="form-control" style="padding: 0;">
                                            <option>select</option>
                                            <option value="MaterialDeliveryDate">入料逾期明細表</option>
                                            <option value="UnconfirmedDeliveryDate">交期未回覆明細</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="data-tables datatable-dark">
                                    <table id="ListData" class="display text-center" style="width:100%">
                                        <thead class="text-capitalize" style=" background: darkgrey;">
                                            <tr>
                                                <th>DAT_BUY</th>
                                                <th>NUM_BUY</th>
                                                <th>NAM_FACT</th>
                                                <th>DAT_REQ</th>
                                                <th>DAT_POR</th>
                                                <th>DIFF_DAYS</th>
                                                <th>COD_ITEM</th>
                                                <th>UNT_BUY</th>
                                                <th>QTY_BUY</th>
                                                <th>QTY_DEL</th>
                                                <th>QTY_BACK</th>
                                                <th>UN_QTY</th>
                                                <th>NAM_ITEM</th>
                                                <th>DAT_NEED</th>
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
        let Model;
        let work_no;
        var table = $('#ListData').DataTable({

            columns: [{
                "data": "DAT_BUY",
                "title": "採購日期"
            }, {
                "data": "NUM_BUY",
                "title": "採購單號"
            }, {
                "data": "NAM_FACT",
                "title": "廠商"
            }, {
                "data": "DAT_REQ",
                "title": "預定到貨日"
            }, {
                "data": "DAT_POR",
                "title": "廠商回覆交期"
            }, {
                "data": "DIFF_DAYS",
                "title": "逾期天數"
            }, {
                "data": "COD_ITEM",
                "title": "料號"
            }, {
                "data": "UNT_BUY",
                "title": "單位"
            }, {
                "data": "QTY_BUY",
                "title": "數量"
            }, {
                "data": "QTY_DEL",
                "title": "已交數量"
            }, {
                "data": "QTY_BACK",
                "title": "退貨數"
            }, {
                "data": "UN_QTY",
                "title": "未交數量"
            }, {
                "data": "NAM_ITEM",
                "title": "產品名稱"
            }, {
                "data": "DAT_NEED",
                "title": "需求日"
            }, ],
            columnDefs: [{
                targets: [4, 5, 11], // 所在的 index（從 0 開始）
                render: function(data, type, row, meta) {
                    switch (meta.col) {
                        case 4:
                            return '<span style="color:Purple">' + data + '</span>';
                        case 5:
                            return '<span style="color:red">' + data + '</span>';
                            if (data < 0) {
                                return '<span style="color:red">' + data + '</span>';
                            } else {
                                return '<span style="color:blue">尚未回覆</span>';
                            }
                        case 11:
                            return '<span style="color:red">' + data + '</span>';
                        default:
                            return data;
                    }
                }
            }]
        });
        $('#searchtype').on('change', function() {
            var selectedValue = $(this).val();
            $('#loading').show();
            $.ajax({
                url: 'mesBuyDelayAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    searchtype: selectedValue
                },
                success: function(response) {
                    // 清空表格資料
                    table.clear();
                    // 將回應資料加入表格
                    table.rows.add(response);
                    // 重新繪製表格
                    table.order([0, 'desc']).draw();
                    $('#loading').hide();
                    // 處理 AJAX 請求成功後的回應
                    console.log(response);
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