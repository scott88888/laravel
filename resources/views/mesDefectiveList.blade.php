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
            <div class="main5">
                <div class="row" style="margin-right:0px; margin-left:0px;">
                    <!-- Dark table start -->
                    <div class="col-12 mt-1">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">生產不良弱點分析</h4>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>查詢內容</label>
                                        <input class="form-control form-control-sm" id="search">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="col-form-label">查詢類型 </label>
                                    <select id="searchtype" class="form-control" style="padding: 0;">
                                        <option>select</option>
                                        <option value="PCB">PCB</option>
                                        <option value="PART_NO">零件料號</option>
                                        <option value="LOCATION">零件位置</option>
                                        <option value="COD_QC">不良現象代碼</option>
                                        <option value="STS_COMR">不良原因代碼</option>
                                        <option value="DAT_COMR">回報日期</option>
                                        <option value="runcard_no">流程卡號</option>
                                        <option value="work_no">工單</option>
                                        <option value="cod_item">產品名稱</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="col-md-2 my-1">
                                        <button id="submit" class="btn btn-primary">查詢</button>
                                    </div>
                                </div>
                            </div>
                            <div class="data-tables datatable-dark">
                                <table id="ListData" class="display text-center" style="width:100%">
                                    <thead class="text-capitalize" style=" background: darkgrey;">
                                        <tr>
                                            <th>Model</th>
                                            <th>NUM_COMR</th>
                                            <th>work_no</th>
                                            <th>runcard_no</th>
                                            <th>COD_QC</th>
                                            <th>STS_COMR</th>
                                            <th>DAT_COMR</th>
                                            <th>PS1</th>
                                            <th>TIM_BEG</th>
                                            <th>TIM_END</th>
                                            <th>ng_time</th>
                                            <th>TIMEDIFF</th>
                                            <th>PCB</th>
                                            <th>NO_SEQ_BAD</th>
                                            <th>NO_SEQ</th>
                                            <th>PART_NO</th>
                                            <th>LOCATION</th>
                                            <th>STATION</th>
                                            <th>ng_remark</th>
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
        table = $('#ListData').DataTable({
            ...tableConfig,
            responsive: true,
            columns: [{
                "data": "Model",
                "title": "產品名稱"
            }, {
                "data": "NUM_COMR",
                "title": "回報編號"
            }, {
                "data": "work_no",
                "title": "工單"
            }, {
                "data": "runcard_no",
                "title": "流程卡號"
            }, {
                "data": "COD_QC",
                "render": function(data, type, row) {
                    return row.COD_QC + " / " + row.pc_desc;
                },
                "title": "不良現象代碼"
            }, {
                "data": "STS_COMR",
                "render": function(data, type, row) {
                    return row.STS_COMR + " / " + row.comr_desc;
                },
                "title": "不良原因代碼"
            }, {
                "data": "DAT_COMR",
                "title": "回報日期"
            }, {
                "data": "PS1",
                "title": "維修人員"
            }, {
                "data": "TIM_BEG",
                "title": "開始時間"
            }, {
                "data": "TIM_END",
                "title": "結束時間"
            }, {
                "data": "ng_time",
                "title": "回報時間"
            }, {
                "data": "TIMEDIFF",
                "title": "維修時間"
            }, {
                "data": "PCB",
                "title": "PCB"
            }, {
                "data": "NO_SEQ_BAD",
                "title": "PCB(更換前)"
            }, {
                "data": "NO_SEQ",
                "title": "PCB(更換後)"
            }, {
                "data": "PART_NO",
                "title": "零件料號",
                "render": function(data, type, row) {
                    try {
                        var decodedData = atob(data);
                    } catch (e) {
                        console.error('Error decoding data: ' + e.message);
                        decodedData = data;
                    }
                    return decodedData;
                }
            }, {
                "data": "LOCATION",
                "title": "零件位置"
            }, {
                "data": "STATION",
                "title": "生產判定站別"
            }, {
                "data": "ng_remark",
                "title": "備註"
            }, ],
            columnDefs: [{
                targets: [0, 1, 3],
                render: function(data, type, row, meta) {
                    switch (meta.col) {
                        case 0:
                            Model = data;
                            return data;
                        case 1:
                            return '<a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/show_comr_form.php?=' + Model + '&' + data + '" target="_blank">' + data;
                        case 3:
                            return '<a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/show_runcard_view.php?=' + data + '" target="_blank">' + data;
                        default:
                            return data;
                    }
                }
            }],

        });


        $('#submit').click(function() {
            var search = $('#search').val();
            var searchtype = $('#searchtype').val();
            $('#loading').show();
            $.ajax({
                url: 'mesDefectiveListAjax',
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