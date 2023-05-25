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
            <div>
                <div class="row" style="margin: 0;">
                    <!-- Dark table start -->
                    <div class="col-12" style="padding: 8px;">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">出貨查詢</h4>
                                <div class="form-row">
                                    <div class="col-md-1 mb-3">
                                        <label class="col-form-label" style="padding-top: 0;">查詢類型 </label>
                                        <select id="searchtype" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option>選擇</option>
                                            <option value="NUM_CUST">客戶代號</option>
                                            <option value="NAM_ITEMS">品名</option>
                                            <option value="NUM_DEL">出貨單號</option>
                                            <option value="NUM_PO">訂單編號</option>
                                            <option value="COD_ITEM">料號</option>
                                            <option value="DAT_DEL">出貨日期</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04">查詢內容</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                        <div class="invalid-feedback">
                                            Please provide a valid state.
                                        </div>
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
                                    <div class="col-md-2" id="dateS">
                                        <div class="form-group">
                                            <label for="example-date-input" style="padding-top: 0;" class="col-form-label">Date</label>
                                            <input class="form-control" type="date" value="" id="rangS">
                                        </div>
                                    </div>
                                    <div class="col-md-2" id="dateE">
                                        <div class="form-group">
                                            <label for="example-date-input" style="padding-top: 0;" class="col-form-label">Date</label>
                                            <input class="form-control" type="date" value="" id="rangE">
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
                                        <th>DAT_DEL</th>
                                        <th>NAM_CUSTS</th>
                                        <th>NUM_CUST</th>
                                        <th id="col1">NAM_ITEMS</th>
                                        <th>NUM_DEL</th>
                                        <th>NUM_PO</th>
                                        <th>COD_ITEM</th>
                                        <th>QTY_DEL</th>
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

        table = $('#ListData').DataTable({
            ...tableConfig,
            columnDefs: [{
                    "data": "DAT_DEL",
                    "targets": 0,
                    "title": "出貨日期"
                },
                {
                    "data": "NAM_CUSTS",
                    "targets": 1,
                    "title": "客戶名稱"
                },
                {
                    "data": "NUM_CUST",
                    "targets": 2,
                    "title": "客戶代號"
                },
                {
                    "data": "NAM_ITEMS",
                    "targets": 3,
                    "title": "品名"
                },
                {
                    "data": "NUM_DEL",
                    "targets": 4,
                    "title": "出貨單號"
                },
                {
                    "data": "NUM_PO",
                    "targets": 5,
                    "title": "訂單編號"
                },
                {
                    "data": "COD_ITEM",
                    "targets": 6,
                    "title": "料號"
                },
                {
                    "data": "QTY_DEL",
                    "targets": 7,
                    "title": "數量"
                }
            ]
        });
        $('#loading').hide();
        $('#rang').hide();
        $('#dateS').hide();
        $('#dateE').hide();
        $('#searchtype').on('change', function() {
            if ($(this).val() == 'DAT_DEL') {
                $('#rang').show();
                $('#dateS').show();
                $('#dateE').show();
                $('#searchBox').hide();

            } else {
                $('#dateS').hide();
                $('#dateE').hide();
                $('#rang').hide();
                $('#searchBox').show();
            }
        });
        setButtonClickEvent(1);
        setButtonClickEvent(7);
        setButtonClickEvent(30);
        $('#submit').click(function() {
            var search = $('#search').val();
            var searchtype = $('#searchtype').val();
            var rangS = $('#rangS').val().replace(/-/g, '');
            var rangE = $('#rangE').val().replace(/-/g, '');
            loadData(search, searchtype, rangS, rangE);
        });

    });

    function loadData(search, searchtype, rangS, rangE) {
        $('#loading').show();
        $.ajax({
            url: 'mesShipmentListAjax',
            type: 'GET',
            dataType: 'json',
            data: {
                search: search,
                searchtype: searchtype,
                rangS: rangS,
                rangE: rangE
            },
            success: function(response) {
                table.clear().rows.add(response).draw();
                $('#col1').css('width', '500px');
                $('#loading').hide();
            },
            error: function(xhr, status, error) {
                console.log('no data');
                $('#loading').hide();
            }
        });
    }

    function setButtonClickEvent(days) {
        $('#' + days + 'ds').click(function() {
            var dateRange = setDateRange(days);
            var search = $('#search').val();
            var searchtype = 'DAT_DEL';
            var rangS = dateRange.startFormatted;
            var rangE = dateRange.endFormatted;
            loadData(search, searchtype, rangS, rangE);
        });
    }

    function setDateRange(days) {
        var today = new Date();
        var startDate = new Date(today);
        var endDate = new Date(today);
        startDate.setDate(startDate.getDate() - days);
        var startFormatted = formatDate(startDate);
        var endFormatted = formatDate(endDate);
        return {
            startFormatted: startFormatted,
            endFormatted: endFormatted
        };
    }

    function formatDate(date) {
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var day = String(date.getDate()).padStart(2, '0');
        return year + month + day;
    }
</script>

</html>