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
                                <h4 class="header-title">{{ $langArray->RMA不良原因查詢 }}</h4>
                                <div class="form-row">
                                    <div class="col-md-2 mb-3">
                                        <label class="col-form-label" style="padding-top: 0;">{{ $langArray->查詢類型 }} </label>
                                        <select id="searchtype" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option value="COD_ITEM">{{ $langArray->產品型號 }}</option>
                                            <option value="NUM_MTRM">{{ $langArray->派修單號 }}</option>
                                            <option value="NUM_SER" selected>{{ $langArray->出廠序號 }}</option>
                                            <option value="MTRM_PS">{{ $langArray->零件料號 }}</option>
                                            <option value="COD_CUST">{{ $langArray->客戶代碼 }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="form-group">
                                            <label>{{ $langArray->查詢內容 }}</label>
                                            <input class="form-control" id="search">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <label for="">{{ $langArray->查詢 }}</label>
                                        <button type="button" id="submit" class="btn btn-primary btn-block">{{ $langArray->送出 }}</button>
                                    </div>
                                    <div class="col-2">
                                        <label style="color:white;">{{ $langArray->查詢 }}</label>
                                        <button type="button" id="badPart" class="btn btn-primary btn-block">{{ $langArray->不良零件不良原因 }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="data-tables datatable-dark" id="hidetable">
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
            <div class="main-content-inner" id="badTable">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title" style="text-align: center;">{{ $langArray->不良原因 }}</h4>
                                <div class="single-table">
                                    <div class="table-responsive">
                                        <table class="table text-center" id="badReasonTable">
                                            <thead class="text-uppercase bg-dark">
                                                <tr class="text-white">
                                                    <th scope="col">{{ $langArray->不良原因 }}</th>
                                                    <th scope="col">{{ $langArray->次數 }}</th>
                                                </tr>
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
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title" style="text-align: center;">{{ $langArray->不良零件 }}</h4>
                                <div class="single-table">
                                    <div class="table-responsive">
                                        <table class="table text-center" id="badPartTable">
                                            <thead class="text-uppercase bg-dark">
                                                <tr class="text-white">
                                                    <th scope="col">{{ $langArray->不良零件 }}</th>
                                                    <th scope="col">{{ $langArray->次數 }}</th>
                                                </tr>
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
        </div>
    </div>
    @include('layouts/footer')
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
        $("#badTable").css("display", "none");
        $("#hidetable").css("display", "none");
        table = $('#ListData').DataTable({
            ...tableConfig,
            columnDefs: [{
                    targets: [0], // 所在的 index（從 0 開始）
                    data: "DAT_ONCA",
                    title: `{{ $langArray->報修日期 }}`
                },
                {
                    targets: [1], // 所在的 index（從 0 開始）
                    data: "ONCA_IR",
                    title: `{{ $langArray->類別}}`
                },
                {
                    targets: [2], // 所在的 index（從 0 開始）
                    data: "NUM_ONCA",
                    title: `{{ $langArray->報修單號 }}`
                },
                {
                    targets: [3], // 所在的 index（從 0 開始）
                    data: "NUM_MTRM",
                    title: `{{ $langArray->派修單號 }}`
                },
                {
                    targets: [4], // 所在的 index（從 0 開始）
                    data: "NAM_CUSTS",
                    title: `{{ $langArray->客戶 }}`
                },
                {
                    targets: [5], // 所在的 index（從 0 開始）
                    data: "COD_ITEM",
                    title: `{{ $langArray->產品型號 }}`
                },
                {
                    targets: [6], // 所在的 index（從 0 開始）
                    data: "NUM_SER",
                    title: `{{ $langArray->出廠序號 }}`
                },
                {
                    targets: [7], // 所在的 index（從 0 開始）
                    data: "DAT_ACTB",
                    title: `{{ $langArray->實際開工 }}`
                },
                {
                    targets: [8], // 所在的 index（從 0 開始）
                    data: "DAT_ACTE",
                    title: `{{ $langArray->實際完工 }}`
                },
                {
                    targets: [9], // 所在的 index（從 0 開始）
                    data: "PS1_1",
                    title: `{{ $langArray->故障原因 }}`
                },
                {
                    targets: [10], // 所在的 index（從 0 開始）
                    data: "MTRM_PS",
                    title: `{{ $langArray->零件料號 }}`
                },
                {
                    targets: [11], // 所在的 index（從 0 開始）
                    data: "PS1_2",
                    title: `{{ $langArray->檢測結果}}`
                },
                {
                    targets: [12], // 所在的 index（從 0 開始）
                    data: "PS1_3",
                    title: `{{ $langArray->責任判定}}`
                },
                {
                    targets: [13], // 所在的 index（從 0 開始）
                    data: "PS1_4",
                    title: `{{ $langArray->保固期}}`
                },
                {
                    targets: [14], // 所在的 index（從 0 開始）
                    data: "EMP_ORD",
                    title: `{{ $langArray->維修人員}}`
                },
                {
                    targets: [15], // 所在的 index（從 0 開始）
                    data: "STS_ONCA",
                    title: `{{ $langArray->維修單狀況}}`
                },
                {
                    targets: [1, 8, 12, 13, 15], // 所在的 index（從 0 開始）
                    render: function(data, type, row, meta) {
                        switch (meta.col) {
                            case 1:

                            case 8:
                                dateEnd = data;
                                return data;
                            case 12:
                                work_no = data;
                                if (data === '客戶') {
                                    return `{{ $langArray->客戶 }}`;
                                } else if (data === '廠商') {
                                    return `{{ $langArray->廠商 }}`;
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
                                    return '<span style="color:red">' + `{{ $langArray->尚未處理 }}` + '</span>';
                                } else if (data === '05') {
                                    return '<span style="color:red">' + `{{ $langArray->已轉公文 }}` + '</span>';
                                } else if (data == '07') {
                                    return '<span style="color:red">' + `{{ $langArray->報價中 }}` + '</span>';
                                } else if (data === '10') {
                                    return '<span style="color:red">' + `{{ $langArray->已確認 }}` + '</span>';
                                } else if (data === '15') {
                                    return '<span style="color:red">' + `{{ $langArray->通知生產 }}` + '</span>';
                                } else if (data === '20') {
                                    return '<span style="color:red">' + `{{ $langArray->已派工 }}` + '</span>';
                                } else if (data === '25') {
                                    return '<span style="color:red">' + `{{ $langArray->轉單 }}` + '</span>';
                                } else if (data === '30') {
                                    return '<span style="color:red">' + `{{ $langArray->已完工 }}` + '</span>';
                                } else if (data === '35') {
                                    return '<span style="color:red">' + `{{ $langArray->通知驗收 }}` + '</span>';
                                } else if (data === '40') {
                                    return '<span style="color:red">' + `{{ $langArray->客戶驗收 }}` + '</span>';
                                } else if (data === '50') {
                                    return '<span style="color:red">' + `{{ $langArray->已轉應收 }}` + '</span>';
                                } else if (data === '90') {
                                    return '<span style="color:red">' + `{{ $langArray->撤銷 }}` + '</span>';
                                } else if (data === '99') {
                                    return '<span style="color:red">' + `{{ $langArray->結案 }}` + '</span>';
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
            $("#hidetable").css("display", "block");
            $("#badTable").css("display", "none");
            var search = $('#search').val();
            var searchtype = $('#searchtype').val();
            var rangS = $('#rangS').val();
            var rangE = $('#rangE').val();
            $('#loading').show();
            $.ajax({
                url: 'RMAAnalysisAjax',
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
        $('#badPart').click(function() {
            $("#hidetable").css("display", "none");
            $("#badTable").css("display", "block");
            var search = $('#search').val();
            var searchtype = $('#searchtype').val();
            $('#loading').show();
            $.ajax({
                url: 'RMAbadPartAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    search: search,
                    searchtype: searchtype
                },
                success: function(response) {
                    $('#loading').hide();

                    var badPartData = response.badPart;
                    var badReasonData = response.badReason;

                    // 清空表格内容
                    var badPartTable = $('#badPartTable');
                    badPartTable.empty();

                    // 创建并添加 badPartTable 的 thead
                    var badPartThead = $('<thead class="text-uppercase bg-dark">');
                    var badPartHeaderRow = $('<tr class="text-white">');
                    var badPartReasonHeader = $('<th scope="col">').text('不良零件');
                    var badPartCountHeader = $('<th scope="col">').text('次數');
                    badPartHeaderRow.append(badPartReasonHeader, badPartCountHeader);
                    badPartThead.append(badPartHeaderRow);
                    badPartTable.append(badPartThead);

                    // 生成 badPartTable 的表格内容
                    badPartData.forEach(function(row) {
                        var newRow = $('<tr>');
                        var partCell = $('<td>').text(row.part);
                        newRow.append(partCell);
                        var countCell = $('<td>').text(row.count);
                        newRow.append(countCell);
                        badPartTable.append(newRow);
                    });

                    // 清空表格内容
                    var badReasonTable = $('#badReasonTable');
                    badReasonTable.empty();

                    // 创建并添加 badReasonTable 的 thead
                    var badReasonThead = $('<thead class="text-uppercase bg-dark">');
                    var badReasonHeaderRow = $('<tr class="text-white">');
                    var badReasonReasonHeader = $('<th scope="col">').text('不良原因');
                    var badReasonCountHeader = $('<th scope="col">').text('次數');
                    badReasonHeaderRow.append(badReasonReasonHeader, badReasonCountHeader);
                    badReasonThead.append(badReasonHeaderRow);
                    badReasonTable.append(badReasonThead);

                    // 生成 badReasonTable 的表格内容
                    badReasonData.forEach(function(row) {
                        var newRow = $('<tr>');
                        var reasonCell = $('<td>').text(row.reason);
                        newRow.append(reasonCell);
                        var countCell = $('<td>').text(row.count);
                        newRow.append(countCell);
                        badReasonTable.append(newRow);
                    });
                },
                error: function(xhr, status, error) {
                    console.log('no data');
                    $('#loading').hide();
                }
            });

        });
    });
</script>

</html>