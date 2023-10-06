<!DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>

    @include('layouts/head')
</head>

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
                <div class="row">
                    <!-- Dark table start -->
                    <div class="col-12 mt-1">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">入料逾期明細表</h4>
                                <div class="form-row">
                                    <div class="col-md-3 mb-3">
                                        <label class="col-form-label">排行月份(年)</label>
                                        <select id="searchtype" class="form-control" style="padding: 0;">
                                            <option value="MaterialDeliveryDate">入料逾期明細表</option>
                                            <option value="UnconfirmedDeliveryDate">交期未回覆明細</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="validationCustom04">快查</label>
                                        <div class="col">
                                            <button id="1ds" class="btn btn-primary">明天</button>
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
            ...tableConfig,
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
                "title": "廠商回覆交期",
                "render": function(data, type, row) {
                    if (data > 0) {
                        return '<span style="color:red">' + data + '</span>';
                    } else {
                        return '<span style="color:blue">尚未回覆</span>';
                    }
                }
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
                "title": "未交數量",
                "render": function(data, type, row) {
                    return '<span style="color:red">' + data + '</span>';
                }
            }, {
                "data": "NAM_ITEM",
                "title": "產品名稱"
            }, {
                "data": "DAT_NEED",
                "title": "需求日"
            }, ],

        });
        loadData('20999999');
        setButtonClickEvent(1);
        setButtonClickEvent(7);
        setButtonClickEvent(30);
        $('#submit').click(function() {
            loadData('20999999');
        });

        function setButtonClickEvent(days) {
            $('#' + days + 'ds').click(function() {
                const today = new Date();
                const previousDate = new Date(today);
                previousDate.setDate(today.getDate() + days);
            
                console.log(getFormattedDate(previousDate));
                 loadData(getFormattedDate(previousDate));
            });
        }

        function getFormattedDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}${month}${day}`;
        }

        function loadData(date) {
            var selectedValue = $('#searchtype').val();
            $('#loading').show();
            $.ajax({
                url: 'mesBuyDelayAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    date: date,
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

                },
                error: function(xhr, status, error) {
                    // 處理 AJAX 請求失敗後的回應
                    console.log('no');
                    $('#loading').hide();
                }
            });
        }
    });
</script>


</html>