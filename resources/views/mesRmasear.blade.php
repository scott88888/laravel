<!DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>

    @include('layouts/head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<script>
    $(document).ready(function() {
        $('#ListData').DataTable();
    });
</script>

<style>
    @media print {
        .no-print {
            display: none;
        }
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
            <div>
                <div class="row" style="margin: 0;">
                    <!-- Dark table start -->
                    <div class="col-12" style="padding: 8px;">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">產品維修單明細表</h4>
                                <div class="form-row">
                                    <div class="">
                                        <label class="col-form-label" style="padding-top: 0;">字碼</label>
                                        <select id="numTitle" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option value="FA">FA</option>
                                            <option value="FE">FE</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="">單號</label>
                                        <input id="repairNum" type="number" class="form-control" placeholder="" required="">
                                    </div>

                                    <div class="col-2">
                                        <label>送修日期</label>
                                        <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="noticeDate">
                                    </div>
                                    <div class="col-2" style="margin-left: 3rem;">
                                        <label for="">查詢</label>
                                        <div class="col" style="text-align: center;">
                                            <button type="button" id="submit" class="btn btn-primary btn-block">送出</button>
                                        </div>
                                    </div>
                                    <div class="col-2" style="margin-left: 3rem;">
                                        <label for="">查詢</label>
                                        <div class="col" style="text-align: center;">
                                            <button type="button" id="submit30days" class="btn btn-primary btn-block">過去30天</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="data-tables datatable-dark">
                            <table id="ListData" class="display text-center" style="width:100%">
                                <thead class="text-capitalize" style=" background: darkgrey;">
                                    <th>修改</th>
                                    <th>報修單號</th>
                                    <th>客戶</th>
                                    <th>產品型號</th>
                                    <th>產品名稱</th>
                                    <th>工時</th>
                                    <th>收貨人員</th>
                                    <th>維修人員</th>
                                    <th>維修類別</th>
                                    <th>故障情形</th>
                                    <th>故障原因</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                        </td>
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
        <!-- <div id="autocomplete">
            <input type="text" id="input" placeholder="Type something...">
            <div id="suggestions"></div>
        </div> -->
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
        var tableConfig = {
            language: dataTableLanguage,
            dom: 'lBfrtip',
            buttons: [
                'csv',
                'excel',
                'copy',
                {
                    extend: 'print',
                    footer: true,
                    title: "產品維修單明細表",
                    autoPrint: false,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7,8,9,10]
                    }                    
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            order: [0, "desc"],
        };

        table = $('#ListData').DataTable({
            ...tableConfig,
            order: [
                [0, 'desc']

            ],
            columns: [{

                    "data": "num256",
                    "title": "修改",
                    "render": function(data, type, row) {
                        return '<a href=mesRmaEdit?num=' + data + ' target="_blank"><span class="ti-pencil"></span>';
                    }

                },
                {

                    "data": "NUM",
                    "title": "報修單號"
                },
                {

                    "data": "customerName",
                    "title": "客戶"
                },
                {

                    "data": "productNum",
                    "title": "產品型號"
                },
                {

                    "data": "productName",
                    "title": "產品名稱"
                },
                {

                    "data": "workingHours",
                    "title": "工時"
                },

                {

                    "data": "userName",
                    "title": "收貨人員"
                }, {

                    "data": "maintenanceStaff",
                    "title": "維修人員"
                }, {

                    "data": "repairType",
                    "title": "維修類別"
                }, {

                    "data": "faultSituation",
                    "title": "故障情形"
                },
                {

                    "data": "faultCause",
                    "title": "故障原因"
                }
            ]
        });

        $('#submit').click(function() {
            var numTitle = $('#numTitle').val();
            var repairNum = $('#repairNum').val();
            var noticeDate = $('#noticeDate').val();
            $('#loading').show();
            $.ajax({
                url: 'mesRmasearAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    numTitle: numTitle,
                    repairNum: repairNum,
                    noticeDate: noticeDate
                },
                success: function(response) {

                    table.clear();
                    table.rows.add(response);
                    table.draw();
                    console.log(response);
                    $('#loading').hide();
                },
                error: function(xhr, status, error) {
                    console.log('no data');
                    $('#loading').hide();
                }
            });

        });

        $('#submit30days').click(function() {
            $('#loading').show();
            $.ajax({
                url: 'mesRmasear30daysAjax',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    table.clear();
                    table.rows.add(response);
                    table.draw();
                    console.log(response);
                    $('#loading').hide();
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