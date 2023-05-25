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
                                        <label class="col-form-label" style="padding: 8px;">查詢類型 </label>
                                        <select id="searchtype" class="form-control" style="padding: 0;">
                                            <option>select</option>
                                            <option value="NUM_ONCA">報修單號</option>
                                            <option value="DAT_ACTB">實際開工</option>
                                            <option value="NUM_MTRM">派修單號</option>
                                            <option value="COD_ITEM">產品型號</option>
                                            <option value="NUM_SER">出廠序號</option>
                                            <option value="MTRM_PS">零件料號</option>
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
                                        <th>ONCA_IR</th>
                                        <th>NUM_ONCA</th>
                                        <th>NUM_MTRM</th>
                                        <th>NAM_CUSTS</th>
                                        <th>COD_ITEM</th>
                                        <th>NUM_SER</th>
                                        <th>DAT_ACTB</th>
                                        <th>DAT_ACTE</th>
                                        <th>PS1_1</th>
                                        <th>MTRM_PS</th>
                                        <th>PS1_2</th>
                                        <th>PS1_3</th>
                                        <th>OUT_LIST5</th>
                                        <th>EMP_ORD</th>
                                        <th>STS_ONCA</th>
                                        <th>DIFF_DAYS</th>
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
        let dateEnd;
        let work_no;
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
                    data: "ONCA_IR",
                    title: "類別",
                },
                {
                    targets: [2], // 所在的 index（從 0 開始）
                    data: "NUM_ONCA",
                    title: "報修單號"
                },
                {
                    targets: [3], // 所在的 index（從 0 開始）
                    data: "NUM_MTRM",
                    title: "派修單號"
                },
                {
                    targets: [4], // 所在的 index（從 0 開始）
                    data: "NAM_CUSTS",
                    title: "客戶"
                },
                {
                    targets: [5], // 所在的 index（從 0 開始）
                    data: "COD_ITEM",
                    title: "產品型號"
                },
                {
                    targets: [6], // 所在的 index（從 0 開始）
                    data: "NUM_SER",
                    title: "出廠序號"
                },
                {
                    targets: [7], // 所在的 index（從 0 開始）
                    data: "DAT_ACTB",
                    title: "實際開工"
                },
                {
                    targets: [8], // 所在的 index（從 0 開始）
                    data: "DAT_ACTE",
                    title: "實際完工"
                },
                {
                    targets: [9], // 所在的 index（從 0 開始）
                    data: "PS1_1",
                    title: "故障原因",
                },
                {
                    targets: [10], // 所在的 index（從 0 開始）
                    data: "MTRM_PS",
                    title: "零件料號",
                },
                {
                    targets: [11], // 所在的 index（從 0 開始）
                    data: "PS1_2",
                    title: "檢測結果",
                },
                {
                    targets: [12], // 所在的 index（從 0 開始）
                    data: "PS1_3",
                    title: "責任判定",
                },
                {
                    targets: [13], // 所在的 index（從 0 開始）
                    data: "PS1_4",
                    title: "保固期",
                },
                {
                    targets: [14], // 所在的 index（從 0 開始）
                    data: "EMP_ORD",
                    title: "維修人員",
                },
                {
                    targets: [15], // 所在的 index（從 0 開始）
                    data: "STS_ONCA",
                    title: "維修單狀況",
                },
                {
                    targets: [16], // 所在的 index（從 0 開始）
                    data: "DIFF_DAYS",
                    title: "處理時間 (天)",

                }, {
                    targets: [1, 8, 12, 13, 15, 16], // 所在的 index（從 0 開始）
                    render: function(data, type, row, meta) {
                        switch (meta.col) {
                            case 1:

                            case 8:
                                dateEnd = data;
                                return data;
                            case 12:
                                work_no = data;
                                if (data === '客戶') {
                                    return data;
                                } else if (data === '廠商') {
                                    return data;
                                } else {
                                    return '';
                                }
                            case 13:
                                if (data === '客戶' || data === '廠商') {
                                    return '';
                                }
                                return data;
                            case 15:
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
                }
            ]
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