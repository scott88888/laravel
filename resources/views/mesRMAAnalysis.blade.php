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
                                <h4 class="header-title">RMA退貨授權查詢</h4>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label class="col-form-label">查詢類型 </label>
                                        <select id="searchtype" class="form-control" style="padding: 0;">
                                            <option>select</option>
                                            <option value="num_onca">報修單號</option>
                                            <option value="DAT_ACTB">實際開工</option>
                                            <option value="num_mtrm">派修單號</option>
                                            <option value="cod_modl">產品型號</option>
                                            <option value="num_ser">出廠序號</option>
                                            <option value="DD">零件料號</option>
                                            <option value="cod_cust">客戶代碼</option>
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
                                            <label>出廠區間(開始/年月)</label>
                                            <input class="form-control form-control-sm" id="rangS" placeholder="EX:1901">
                                            <label>出廠區間(結束/年月)</label>
                                            <input class="form-control form-control-sm" id="rangE" placeholder="EX:1903">
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
                                        <th>COD_CUST</th>
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
    $(document).ready(function() {
        let dateEnd;
        let work_no;
        $('#loading').hide();
        $('#rang').hide();
        var table = $('#ListData').DataTable({
            responsive: true,
            columns: [{
                "data": "DAT_ONCA",
                "title": "報修日期	"
            }, {
                "data": "ONCA_IR",
                "title": "類別"
            }, {
                "data": "NUM_ONCA",
                "title": "報修單號"
            }, {
                "data": "NUM_MTRM",
                "title": "派修單號"
            }, {
                "data": "NAM_CUSTS",
                "title": "客戶"
            }, {
                "data": "COD_CUST",
                "title": "產品型號"
            }, {
                "data": "NUM_SER",
                "title": "出廠序號"
            }, {
                "data": "DAT_ACTB",
                "title": "實際開工"
            }, {
                "data": "DAT_ACTE",
                "title": "實際完工"
            }, {
                "data": "PS1_1",
                "title": "故障原因"
            }, {
                "data": "MTRM_PS",
                "title": "零件料號"
            }, {
                "data": "PS1_2",
                "title": "檢測結果"
            }, {
                "data": "PS1_3",
                "title": "責任判定"
            }, {
                "data": "PS1_4",
                "title": "保固期"
            }, {
                "data": "EMP_ORD",
                "title": "維修人員"
            }, {
                "data": "STS_ONCA",
                "title": "維修單狀況"
            }, {
                "data": "DIFF_DAYS",
                "title": "處理時間 (天)"
            }],
            columnDefs: [{
                targets: [8, 12, 13, 15, 16], // 所在的 index（從 0 開始）
                render: function(data, type, row, meta) {
                    switch (meta.col) {
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
                            if (data === null) {
                                return work_no;
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