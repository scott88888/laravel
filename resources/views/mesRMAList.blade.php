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
                                <h4 class="header-title">RMA退貨授權查詢</h4>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label class="col-form-label" style="padding-top: 0;">查詢類型</label>
                                        <select id="searchtype" class="form-control" style="padding: 0;">
                                            <option>select</option>
                                            <option value="NUM_ONCA">報修單號</option>
                                            <option value="NUM_MTRM">派修單號</option>
                                            <option value="COD_ITEM">產品型號</option>
                                            <option value="NUM_SER">出廠序號</option>
                                            <option value="COD_CUST">客戶代碼</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label>查詢內容</label>
                                            <input class="form-control form-control-sm" id="search">
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
                                        <th>DAT_ONCA</th>
                                        <th>NUM_ONCA</th>
                                        <th>NUM_MTRM</th>
                                        <th>NAM_CUSTS</th>
                                        <th>COD_MODL</th>
                                        <th>NUM_SER</th>
                                        <th>DAT_ACTB</th>
                                        <th>DAT_ACTE</th>
                                        <th>EMP_ORD</th>
                                        <th>STS_ONCA</th>
                                        <th>date_gap</th>
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
        let Model;
        $('#loading').hide();
        $('#rang').hide();
        table = $('#ListData').DataTable({
            ...tableConfig,
            columnDefs: [{
                    targets: [0], // 所在的 index（從 0 開始）
                    data: "DAT_ONCA",
                    title: "報修日期"
                },
                {
                    targets: [1], // 所在的 index（從 0 開始）
                    data: "NUM_ONCA",
                    title: "報修單號"
                },
                {
                    targets: [2], // 所在的 index（從 0 開始）
                    data: "NUM_MTRM",
                    title: "派修單號"
                },
                {
                    targets: [3], // 所在的 index（從 0 開始）
                    data: "NAM_CUSTS",
                    title: "客戶"
                },
                {
                    targets: [4], // 所在的 index（從 0 開始）
                    data: "COD_ITEM",
                    title: "產品型號"
                },
                {
                    targets: [5], // 所在的 index（從 0 開始）
                    data: "NUM_SER",
                    title: "出廠序號"
                },
                {
                    targets: [6], // 所在的 index（從 0 開始）
                    data: "DAT_ACTB",
                    title: "實際開工"
                },
                {
                    targets: [7], // 所在的 index（從 0 開始）
                    data: "DAT_ACTE",
                    title: "實際完工"
                },
                {
                    targets: [8], // 所在的 index（從 0 開始）
                    data: "EMP_ORD",
                    title: "維修人員"
                },
                {
                    targets: [9], // 所在的 index（從 0 開始）
                    data: "STS_ONCA",
                    title: "維修單狀況",
                    render: function(data, type, row, meta) {
                        switch (data) {
                            case '00':
                                return '<span style="color:red">' + '尚未處理' + '</span>';
                            case '05':
                                return '<span style="color:blue">' + '已轉公文' + '</span>';
                            case '07':
                                return '<span style="color:blue">' + '報價中' + '</span>';
                            case '10':
                                return '<span style="color:blue">' + '已確認' + '</span>';
                            case '15':
                                return '<span style="color:blue">' + '通知生產' + '</span>';
                            case '20':
                                return '<span style="color:blue">' + '已派工' + '</span>';
                            case '25':
                                return '<span style="color:blue">' + '轉單' + '</span>';
                            case '30':
                                return '<span style="color:blue">' + '已完工' + '</span>';
                            case '35':
                                return '<span style="color:blue">' + '通知驗收' + '</span>';
                            case '40':
                                return '<span style="color:blue">' + '客戶驗收' + '</span>';
                            case '50':
                                return '<span style="color:blue">' + '已轉應收' + '</span>';
                            case '90':
                                return '<span style="color:blue">' + '撤銷' + '</span>';
                            case '99':
                                return '<span style="color:blue">' + '結案' + '</span>';
                            default:
                                return data;
                        }
                    }
                }
            ]
        });

        // $('#searchtype').on('change', function() {
        //     if ($(this).val() == 'CustomerCode') {
        //         $('#rang').show();
        //     } else {
        //         $('#rang').hide();
        //     }
        // });
        $('#submit').click(function() {
            var search = $('#search').val();
            var searchtype = $('#searchtype').val();
            var rangS = $('#rangS').val();
            var rangE = $('#rangE').val();
            $('#loading').show();
            $.ajax({
                url: 'mesRMAListAjax',
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