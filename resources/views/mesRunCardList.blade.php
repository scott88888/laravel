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
                                <h4 class="header-title">生產流程卡查詢</h4>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label class="col-form-label">回報日期(月)</label>
                                        <select id="launchDate" class="form-control" style="padding: 0;">
                                            <option>select
                                            </option>
                                            @foreach ($date as $item)
                                            <option value="{{ $item->year}}-{{ $item->month}}">{{ $item->year}}.{{ $item->month}}
                                            </option>
                                            @endforeach
                                            @foreach ($lastyear as $item)
                                            <option value="{{ $item->lastyear}}">{{ $item->lastyear}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-3 mb-3">
                                        <label>查詢類型(1)</label>
                                        <div class="input-group">
                                            <select id="searchtype" class="form-control" style="padding: 0;">
                                                <option>select</option>
                                                <option value="NUM_PS">工單</option>
                                                <option value="runcard_no">流程卡號</option>
                                                <option value="SEQ_ITEM">零件序號查詢</option>
                                                <option value="SEQ_MITEM">出廠序號查詢</option>
                                                <option value="PS2">MAC查詢</option>                                     
                                                <option value="model_no">產品型號查詢</option>                                             
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="form-group align-items-center">
                                            <label>查詢內容(2)</label>
                                            <input class="form-control" style="padding: 0.5rem 0.8rem;" id="search">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>送出查詢(3)</label>
                                        <div class="text-left">
                                            <button id="submit" class="btn btn-primary btn-block" style="height: 38px;">查詢</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="data-tables datatable-dark">
                                    <table id="ListData" class="display text-center" style="width:100%">
                                        <thead class="text-capitalize" style=" background: darkgrey;">
                                            <tr>
                                                <th>NUM_PS</th>
                                                <th>PS1</th>
                                                <th>COD_MITEM</th>
                                                <th>SEQ_MITEM</th>
                                                <th>PS2</th>
                                                <th>version</th>
                                                <th>PS3</th>
                                                <th>P2PKey</th>
                                                <th>LPR_Key</th>
                                                <th>COD_ITEM</th>
                                                <th>SEQ_ITEM</th>
                                                <th>SEQ_NO</th>
                                                <th>startTime</th>
                                                <th>productionLine</th>
                                                <th>operation</th>
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
            ...tableConfig,
            columns: [{
                "data": "NUM_PS",
                "title": "工單"
            }, {
                "data": "PS1",
                "title": "流程卡號"
            }, {
                "data": "COD_MITEM",
                "title": "產品型號"
            }, {
                "data": "SEQ_MITEM",
                "title": "出廠序號"
            }, {
                "data": "PS2",
                "title": "MAC"
            }, {
                "data": "version",
                "title": "韌體版本"
            }, {
                "data": "PS3",
                "title": "維修"
            }, {
                "data": "P2PKey",
                "title": "P2PKey"
            }, {
                "data": "LPR_Key",
                "title": "LPR_Key"
            }, {
                "data": "COD_ITEM",
                "title": "零件料號"
            }, {
                "data": "SEQ_ITEM",
                "title": "零件序號"
            }, {
                "data": "SEQ_NO",
                "title": "流水號"
            }, {
                "data": "startTime",
                "title": "回報日期"
            }, {
                "data": "productionLine",
                "title": "線別"
            }, {
                "data": "operation",
                "title": "製程代號"
            }, ],
            columnDefs: [{
                targets: 14, // 所在的 index（從 0 開始）
                render: function(data, type, row, meta) {
                    switch (data) {
                        case "A0":
                            return '<span style="color:blue">' + '前置作業' + '</span>';
                            break;
                        case "B0":
                            return '<span style="color:blue">' + '組裝' + '</span>';
                            break;
                        case "B1":
                            return '<span style="color:blue">' + '組裝:補填MAC' + '</span>';
                            break;
                        case "C0":
                            return '<span style="color:blue">' + '測試' + '</span>';
                            break;
                        case "D0":
                            return '<span style="color:blue">' + '包裝' + '</span>';
                            break;
                        case "D1":
                            return '<span style="color:blue">' + '包裝:僅輸入出廠序號' + '</span>';
                            break;
                        case "E0":
                            return '<span style="color:blue">' + '維修' + '</span>';
                            break;
                        default:
                            return data
                            break;
                    }
                }
            }]

        });
        $('#launchDate').on('change', function() {
            var launchDate = $(this).val();
            $('#loading').show();
            $.ajax({
                url: 'mesRunCardListAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    launchDate: launchDate
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
                    console.log('no');
                    $('#loading').hide();
                }
            });

        });
        $('#submit').click(function() {
            var search = $('#search').val();
            var searchtype = $('#searchtype').val();
            $('#loading').show();
            $.ajax({
                url: 'mesRunCardListAjax',
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
                    console.log('good');
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