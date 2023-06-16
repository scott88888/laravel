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
    .backup-icon {
        display: none;
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
                                <h4 class="header-title">韌體下載查詢</h4>
                                <div class="form-row">
                                    <div class="col-md-1 mb-3">
                                        <label class="col-form-label" style="padding-top: 0;">查詢類型 </label>
                                        <select id="searchtype" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option>選擇</option>
                                            <option value="fw_id">ID</option>
                                            <option value="model_no">MOD</option>
                                            <option value="model_customer">客戶型號</option>
                                            <option value="version">版本</option>
                                            <option value="upload_date">上傳時間</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04">查詢內容</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2" id="dateS">
                                        <div class="form-group">
                                            <label for="example-date-input" style="padding-top: 0;" class="col-form-label">上傳時間(起)</label>
                                            <input class="form-control" type="date" value="" id="rangS">
                                        </div>
                                    </div>
                                    <div class="col-md-2" id="dateE">
                                        <div class="form-group">
                                            <label for="example-date-input" style="padding-top: 0;" class="col-form-label">上傳時間(迄)</label>
                                            <input class="form-control" type="date" value="" id="rangE">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label>快速查詢</label>
                                        <div class="col" style="text-align: center;">
                                            <button id="3ds" class="btn btn-primary">3天</button>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label style="color: white;">快查</label>
                                        <div class="col" style="text-align: center;">
                                            <button id="30ds" class="btn btn-primary">30天</button>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label style="color: white;">快查</label>
                                        <div class="col" style="text-align: center;">
                                            <button id="allds" class="btn btn-primary" value="getlist">取得全部資料</button>
                                        </div>
                                    </div>
                                     <div class="col-2" style="margin-left: 3rem;">
                                        <label for="">查詢</label>
                                        <div class="col" style="text-align: center;">
                                        <button type="button" id="submit" class="btn btn-primary btn-block">送出</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="data-tables datatable-dark">
                                <table id="ListData" class="display text-center" style="width:100%">
                                    <thead class="text-capitalize" style=" background: darkgrey;">
                                        <tr>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                           <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                        <td></td>
                                        <td></td>
                                        <td></td>
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
<Script>
    var table;
    let Backup_icon = '<img src=' + '{{ asset("images/icon/Backup_Blue_64x64px.png")}} style="width: 1.5rem;"">';
    let pdf_icon = '<img src=' + '{{ asset("images/icon/pdf_download.png")}} style="width: 1.5rem;"">';
    $(document).ready(function() {
        table = $('#ListData').DataTable({
            ...tableConfig,
            columnDefs: [{
                    "targets": "_all",
                    "className": "dt-center"
                },
                {
                    "data": "fw_id",
                    "targets": 0,
                    "title": "ID",
                },
                {
                    "data": "customer",
                    "targets": 1,
                    "title": "客戶類別"
                },
                {
                    "data": "model_no",
                    "targets": 2,
                    "title": "MOD"
                },
                {
                    "data": "model_customer",
                    "targets": 3,
                    "title": "客戶型號"
                },
                {
                    "data": "product_type",
                    "targets": 4,
                    "title": "產品類型"
                },
                {
                    "data": "model_name",
                    "targets": 5,
                    "title": "LILIN名稱"
                },
                {
                    "data": "customer_oem",
                    "targets": 6,
                    "title": "客戶名稱"
                },
                {
                    "data": "version",
                    "targets": 7,
                    "title": "版本"
                },
                {
                    "data": "file_kernel_url",
                    "targets": 8,
                    "title": "韌體OS"
                },
                {
                    "data": "file_app_url",
                    "targets": 9,
                    "title": "韌體執行檔"
                },
                {
                    "data": "file_note_pdf_url",
                    "targets": 10,
                    "title": "發行文件"
                },
                {
                    "data": "file_report_url",
                    "targets": 11,
                    "title": "驗證報告"
                },
                {
                    "data": "file_other_url",
                    "targets": 12,
                    "title": "其他檔案"
                },
                {
                    "data": "pantilt_ver",
                    "targets": 13,
                    "title": "迴轉台"
                },
                {
                    "data": "lens_ver",
                    "targets": 14,
                    "title": "鏡頭MCU"
                },
                {
                    "data": "lens_parameter",
                    "targets": 15,
                    "title": "鏡頭ISP"
                },
                {
                    "data": "p_ver",
                    "targets": 16,
                    "title": "Event"
                },
                {
                    "data": "ai_ver",
                    "targets": 17,
                    "title": "AI版本"
                },
                {
                    "data": "upload_date",
                    "targets": 18,
                    "title": "韌體上傳時間"
                },
                {
                    "data": "upload_man",
                    "targets": 19,
                    "title": "韌體上傳人員"
                },
                {
                    "data": "Remark",
                    "targets": 20,
                    "title": "送驗需求單"
                },
                {
                    "data": "upload_date2",
                    "targets": 21,
                    "title": "發行通知上傳時間"
                },

                {
                    targets: [0,8, 9, 10, 11, 12, 20], // 所在的 index（從 0 開始）
                    render: function(data, type, row, meta) {
                        switch (meta.col) {
                            case 0:
                                return  '<a href="{{ asset("/editFirmware?id=") }}'+ data +'"  target="_blank">' + data + '</a>';
                            case 8:
                                if (data != null) {
                                    return '<a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/' + data + '" target="_blank">' + Backup_icon + '</a>';
                                } else {
                                    return '';
                                }
                            case 9:
                                if (data != null) {
                                    return '<a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/' + data + '" target="_blank">' + Backup_icon + '</a>';
                                } else {
                                    return '';
                                }
                            case 10:
                                if (data == null) {
                                    return '<a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/' + data + '" target="_blank">' + pdf_icon + '</a>';
                                } else {
                                    return '';
                                }
                            case 11:
                                if (data != null) {
                                    return '<a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/' + data + '" target="_blank">' + pdf_icon + '</a>';
                                } else {
                                    return '';
                                }
                            case 12:
                                if (data != null) {
                                    return '<a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/' + data + '" target="_blank">' + Backup_icon + '</a>';
                                } else {
                                    return '';
                                }
                            case 20:
                                if (data != null) {
                                    return '<a href="' + data + '" target="_blank"><i class="fa fa-link" style="font-size: large;color: blue;"></i></a>';
                                } else {
                                    return '';
                                }

                            default:
                                return data;
                        }
                    }
                }
            ]
        });

        $('#loading').hide();
        $('#rang').hide();
        $('#dateS').hide();
        $('#dateE').hide();
        $('#searchtype').on('change', function() {
            if ($(this).val() == 'upload_date') {
                $('#rang').show();
                $('#dateS').show();
                $('#dateE').show();
                $('#searchBox').hide();

            } else {
                $('#dateS').hide();
                $('#dateE').hide();
                $('#rang').hide();
                $('#searchBox').show();
            }
        });
        setButtonClickEvent(3);
        setButtonClickEvent(30);
        $('#allds').click(function() {
            var search = $('#search').val();
            var searchtype = 'upload_date';
            var rangS = 00000000;
            var today = new Date();
            var rangE = formatDate(new Date(today));
            loadData(search, searchtype, rangS, rangE);
        });
        $('#submit').click(function() {
            var search = $('#search').val();
            var searchtype = $('#searchtype').val();
            var rangS = $('#rangS').val().replace(/-/g, '');
            var rangE = $('#rangE').val().replace(/-/g, '');
            loadData(search, searchtype, rangS, rangE);
        });

    });

    function loadData(search, searchtype, rangS, rangE) {
        $('#loading').show();
        $.ajax({
            url: 'mesUploadListAjax',
            type: 'GET',
            dataType: 'json',
            data: {
                search: search,
                searchtype: searchtype,
                rangS: rangS,
                rangE: rangE
            },
            success: function(response) {
                table.clear().rows.add(response).draw();
                $('#loading').hide();
            },
            error: function(xhr, status, error) {
                console.log('no data');
                table.clear();
                $('#loading').hide();
            }
        });
    }

    function setButtonClickEvent(days) {
        $('#' + days + 'ds').click(function() {
            var dateRange = setDateRange(days);
            var search = $('#search').val();
            var searchtype = 'upload_date';
            var rangS = dateRange.startFormatted;
            var rangE = dateRange.endFormatted;
            loadData(search, searchtype, rangS, rangE);
        });
    }

    function setDateRange(days) {
        var today = new Date();
        var startDate = new Date(today);
        var endDate = new Date(today);
        startDate.setDate(startDate.getDate() - days);
        var startFormatted = formatDate(startDate);
        var endFormatted = formatDate(endDate);
        return {
            startFormatted: startFormatted,
            endFormatted: endFormatted
        };
    }

    function formatDate(date) {
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var day = String(date.getDate()).padStart(2, '0');
        return year + month + day;
    }
</Script>

</html>