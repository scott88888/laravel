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
                                <h4 class="header-title">韌體下載查詢</h4>
                                <div class="form-row col-md-6 mb-3">
                                    <form action="./mesUploadList" method="GET">
                                        <div class="col">
                                            <button name="submit" class="btn btn-primary" value="getlist">取得資料</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="data-tables datatable-dark">
                                    <table id="ListData" class="display text-center" style="width:100%">
                                        <thead class="text-capitalize" style=" background: darkgrey;">
                                            <tr>
                                                <th class='hide_column'>ID</th>
                                                <th>客戶類別</th>
                                                <th>MOD</th>
                                                <th>客戶型號</th>
                                                <th>產品類型</th>
                                                <th>LILIN名稱</th>
                                                <th>客戶名稱</th>
                                                <th>版本</th>
                                                <th>韌體(OS)</th>
                                                <th>韌體(應用程式)</th>
                                                <th>發行文件</th>
                                                <th>官網下載</th>
                                                <th>驗證報告</th>
                                                <th>其他檔案</th>
                                                <th>迴轉台</th>
                                                <th>鏡頭MCU</th>
                                                <th>鏡頭ISP</th>
                                                <th>Event I/O</th>
                                                <th>救援檔案版本</th>
                                                <th>AI版本</th>
                                                <th>韌體上傳時間</th>
                                                <th>韌體上傳人員</th>
                                                <th>送驗需求單</th>
                                                <th>發行通知上傳時間</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($MesUploadList as $ListData)
                                            <tr>
                                                <td class="hide_column">{{$ListData->fw_id}}</td>
                                                <td>{{$ListData->customer}}</td>
                                                <td>{{$ListData->model_no}}</td>
                                                <td>{{$ListData->model_customer}}</td>
                                                <td>{{$ListData->product_type}}</td>
                                                <td>{{$ListData->model_name}}</td>
                                                <td>{{$ListData->customer_oem}}</td>
                                                <td>{{$ListData->version}}</td>
                                                <td>
                                                    @if ($ListData->file_kernel != null)
                                                    <div>
                                                        <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/{{$ListData->file_kernel_url}}" target="_blank">
                                                            <img src="{{ asset('images/icon/Backup_Blue_64x64px.png')}}" style="width: 1.5rem;" alt="{{$ListData->file_kernel_url}}">
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ListData->file_app != null)
                                                    <div>
                                                        <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/{{$ListData->file_app_url}}" target="_blank">
                                                            <img src="{{ asset('images/icon/Backup_Blue_64x64px.png')}}" style="width: 1.5rem;" alt="{{$ListData->file_app_url}}">
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ListData->file_note_pdf != null)
                                                    <div>
                                                        <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/{{$ListData->file_note_pdf_url}}" target="_blank">
                                                            <img src="{{ asset('images/icon/pdf_download.png')}}" style="width: 1.5rem;" alt="{{$ListData->file_note_pdf_url}}">
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ListData->ow_url != null)
                                                    <div>
                                                        <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/{{$ListData->ow_url}}" target="_blank">
                                                            <img src="{{ asset('images/icon/zip_ow.png')}}" style="width: 1.5rem;" alt="{{$ListData->ow_url}}">
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ListData->file_report_url != null)
                                                    <div>
                                                        <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/{{$ListData->file_report_url}}" target="_blank">
                                                            <img src="{{ asset('images/icon/QA_report.png')}}" style="width: 1.5rem;" alt="{{$ListData->file_report_url}}">
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ListData->file_other_url != null)
                                                    <div>
                                                        <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/{{$ListData->file_other_url}}" target="_blank">
                                                            <img src="{{ asset('images/icon/zip.png')}}" style="width: 1.5rem;" alt="{{$ListData->file_other_url}}">
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>{{$ListData->pantilt_ver}}</td>
                                                <td>{{$ListData->lens_ver}}</td>
                                                <td>{{$ListData->lens_parameter}}</td>
                                                <td>{{$ListData->p_ver}}</td>
                                                <td>{{$ListData->recovery_ver}}</td>
                                                <td>{{$ListData->ai_ver}}</td>
                                                <td>{{$ListData->upload_date}}</td>
                                                <td>{{$ListData->upload_man}}</td>
                                                <td>
                                                    @if ($ListData->Remark != null)
                                                    <div>
                                                        <a href="{{$ListData->Remark}}" target="_blank">
                                                            <i class='ti-link'></i>
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ListData->upload_date2 != '0000-00-00 00:00:00')
                                                    <div>
                                                        {{$ListData->upload_date2}}
                                                    </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
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
    $(ListData).DataTable({
        "autoWidth": false,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        responsive: true,
        "info": true,
    })
</Script>

</html>