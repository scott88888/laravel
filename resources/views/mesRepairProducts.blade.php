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
                                <h4 class="header-title">維修不良查詢</h4>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group align-items-center">
                                            <label>機種(型號)</label>
                                            <input class="form-control" style="padding: 0.5rem 0.8rem;" id="model">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group align-items-center">
                                            <label>版號</label>
                                            <input class="form-control" style="padding: 0.5rem 0.8rem;" id="plateNumber">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group align-items-center">
                                            <label>不良現象</label>
                                            <input class="form-control" style="padding: 0.5rem 0.8rem;" id="phenomenon">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group align-items-center">
                                            <label>不良原因</label>
                                            <input class="form-control" style="padding: 0.5rem 0.8rem;" id="reason">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">

                                    <div class="col-md-4 mb-3">
                                        <label>送出查詢</label>
                                        <div class="text-left">
                                            <button id="submit" class="btn btn-primary btn-block" style="height: 38px;">查詢</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="data-tables datatable-dark">
                                <table id="ListData" class="display text-center" style="width:100%">
                                    <thead class="text-capitalize" style=" background: darkgrey;">
                                        <th>DAT_ONCA</th>
                                        <th>TYPE</th>
                                    </thead>
                                    <tbody>
                                        <tr>
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
            "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
            responsive: true,
            columns: [{
                "data": "DAT_ONCA",
                "title": "報修日期	"
            }, {
                "data": "TYPE",
                "title": "類別"
            }],
            columnDefs: [{
                targets: [16], // 所在的 index（從 0 開始）
                render: function(data, type, row, meta) {
                    switch (meta.col) {
                        case 16:
                            if (data === '00') {
                                return '<span style="color:red">' + '尚未處理' + '</span>';
                            } else if (data === '05') {
                                return '<span style="color:blue">' + '已轉公文' + '</span>';
                            } else if (data == '07') {
                                return '<span style="color:blue">' + '報價中' + '</span>';
                            } else if (data === '10') {
                                return '<span style="color:blue">' + '已確認' + '</span>';
                            } else if (data === '15') {
                                return '<span style="color:blue">' + '通知生產' + '</span>';
                            } else if (data === '20') {
                                return '<span style="color:blue">' + '已派工' + '</span>';
                            } else if (data === '25') {
                                return '<span style="color:blue">' + '轉單' + '</span>';
                            } else if (data === '30') {
                                return '<span style="color:blue">' + '已完工' + '</span>';
                            } else if (data === '35') {
                                return '<span style="color:blue">' + '通知驗收' + '</span>';
                            } else if (data === '40') {
                                return '<span style="color:blue">' + '客戶驗收' + '</span>';
                            } else if (data === '50') {
                                return '<span style="color:blue">' + '已轉應收' + '</span>';
                            } else if (data === '90') {
                                return '<span style="color:blue">' + '撤銷' + '</span>';
                            } else if (data === '99') {
                                return '<span style="color:blue">' + '結案' + '</span>';
                            } else {
                                return data
                            }
                        default:
                            return data;
                    }
                }
            }]
        });

        $('#searchtype').on('change', function() {
            if ($(this).val() == 'cod_cust') {
                $('#rang').show();
            } else {
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
                url: 'mesRMAAnalysisAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    search: search,
                    searchtype: searchtype,
                    rangS: rangS,
                    rangE: rangE
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
                    console.log(response);
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