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

    #ListData tr.child {
        text-align: left;
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
                                <h4 class="header-title">出貨查詢</h4>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label class="col-form-label">查詢類型 </label>
                                        <select id="searchtype" class="form-control" style="padding: 0;">
                                            <option>select</option>
                                            <option value="NUM_CUST">客戶代號</option>
                                            <option value="NAM_ITEMS">品名</option>
                                            <option value="NUM_DEL">出貨單號</option>
                                            <option value="NUM_PO">訂單編號</option>
                                            <option value="DAT_DEL">出貨日期</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label>查詢內容</label>
                                            <input class="form-control form-control-sm" id="search">
                                        </div>
                                        <div id="rang" class="form-group">
                                            <label>出貨區間(開始/年月)</label>
                                            <input class="form-control form-control-sm" id="rangS" placeholder="EX:20220103">
                                            <label>出貨區間(結束/年月)</label>
                                            <input class="form-control form-control-sm" id="rangE" placeholder="EX:20220105">
                                        </div>
                                    </div>

                                </div>
                                <div class="form-row col-md-6 mb-3">
                                    <div class="col">
                                        <button id="submit" class="btn btn-primary">查詢</button>
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
                                        <th>DAT_TCKET</th>
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
        let Model;
        $('#loading').hide();
        $('#rang').hide();
        var table = $('#ListData').DataTable({
            responsive: true,
            columns: [{
                "data": "DAT_DEL",
                "title": "出貨日期"
            }, {
                "data": "NAM_CUSTS",
                "title": "客戶名稱"
            }, {
                "data": "NUM_CUST",
                "title": "客戶代號"
            }, {
                "data": "NAM_ITEMS",
                "title": "品名"
            }, {
                "data": "NUM_DEL",
                "title": "出貨單號"
            }, {
                "data": "NUM_PO",
                "title": "訂單編號"
            }, {
                "data": "COD_ITEM",
                "title": "料號"
            }, {
                "data": "DAT_TCKET",
                "title": "預定出貨日"
            }, {
                "data": "QTY_DEL",
                "title": "數量"
            }]
        });

        $('#searchtype').on('change', function() {
            if ($(this).val() == 'DAT_DEL') {
                $('#rang').show();
                $('#search').hide();

            } else {
                $('#search').show();
                $('#rang').hide();
            }
        });
        $('#submit').click(function() {
            var search = $('#search').val();
            var searchtype = $('#searchtype').val();
            var rangS = $('#rangS').val();
            var rangE = $('#rangE').val();
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
                    // console.log(response);
                    // 清空表格資料
                    table.clear();
                    // 將回應資料加入表格
                    table.rows.add(response);
                    // 重新繪製表格
                    table.draw();
                    $('#col1').css('width', '500px');
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