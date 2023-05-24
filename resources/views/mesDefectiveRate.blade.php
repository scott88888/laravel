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
                <div class="row">
                    <!-- Dark table start -->
                    <div class="col-12 mt-1">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">產品維修不良率分析</h4>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label class="col-form-label">分析月份(年)</label>
                                        <select id="launchDate" class="form-control" style="padding: 0;">
                                            <option>select
                                            </option>
                                            @foreach ($date as $item)
                                            <option value="{{ $item->year}}{{ $item->month}}">{{ $item->year}}.{{ $item->month}}
                                            </option>
                                            @endforeach
                                            @foreach ($lastyear as $item)
                                            <option value="{{ $item->lastyear}}">{{ $item->lastyear}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="data-tables datatable-dark">
                                    <table id="ListData" class="display text-center" style="width:100%">
                                        <thead class="text-capitalize" style=" background: darkgrey;">
                                            <tr>
                                                <th>work_no</th>
                                                <th>GANO</th>
                                                <th>model</th>
                                                <th>version</th>
                                                <th>order_qty</th>
                                                <th>ng_pcs</th>
                                                <th>ngRate</th>
                                                <th>ngRate</th>
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
        let Model;
        let work_no;
        
        var table = $('#ListData').DataTable({
            "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        responsive: true,
            columns: [{
                "data": "work_no",
                "title": "工令"
            }, {
                "data": "model",
                "title": "產品名稱"
            }, {
                "data": "GANO",
                "title": "工單"
            }, {
                "data": "version",
                "title": "版本"
            }, {
                "data": "order_qty",
                "title": "訂單數量"
            }, {
                "data": "ng_pcs",
                "title": "維修數量"
            }, {
                "data": "ngRate",
                "title": "工單不良率"
            }, {
                "data": "ngRate",
                "title": "直通率(FPY)"
            }, ],
            columnDefs: [{
                targets: [0, 1, 2, 6, 7],
                render: function(data, type, row, meta) {
                    switch (meta.col) {
                        case 0:
                            work_no = data;
                            return data;
                        case 1:
                            Model = data;
                            return '<a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/db_query_ngRate.php?=' + data + '&' + work_no + '" target="_blank">' + data;

                        case 2:
                            return '<a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/db_query_GAngRate.php?=' + Model + '&' + data + '" target="_blank">' + data;
                        case 6:
                            if (data >= 3) {
                                return '<span style="color:red">' + data + '</span>';
                            } else {
                                return '<span style="color:blue">' + data + '</span>';
                            }
                        case 7:
                            if (data != null ) {
                                num = 100;
                                return '<span style="color:blue">' + (num - data) + '</span>';
                            } else {                               
                                return data;
                            }
                            

                        default:
                            return data;
                    }
                }
            }],
        });
        $('#launchDate').on('change', function() {
            var selectedValue = $(this).val();
            $('#loading').show();
            $.ajax({
                url: 'mesDefectiveRateAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    launchDate: selectedValue
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


    });
</script>

</html>