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

<body>
    <div id="preloader">
        <div class="loader"></div>
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
                                <h4 class="header-title">產品型號查詢</h4>
                                <div class="data-tables datatable-dark">
                                    <table id="ListData" class="display text-center" style="width:100%">
                                        <thead class="text-capitalize" style=" background: darkgrey;">
                                            <tr>
                                                <th>客戶</th>
                                                <th>官網</th>
                                                <th>產品型號</th>
                                                <th>產品性質</th>
                                                <th>產品名稱</th>
                                                <th>上架時間</th>
                                                <th>終止使用</th>
                                                <th>終止銷售</th>
                                                <th>停產通知</th>
                                                <th>版本</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($MesModelList as $ListData)
                                            <tr>
                                                <td>
                                                    @if ($ListData->customer === 'NoBrand' && app()->getLocale() ==='zh_TW')
                                                    白牌
                                                    @else
                                                    {{$ListData->customer}}
                                                    @endif
                                                </td>
                                                <td text-align="center" valign="center">
                                                    @if ($ListData->is_enable != null & $ListData->urlTag != null & $ListData->fileGroup !=null)
                                                    <div style="width:30%">
                                                        <img src="{{ asset('images/icon/lilin.png') }}">
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ListData->is_enable != null & $ListData->urlTag != null & $ListData->fileGroup !=null)
                                                    <div>
                                                        <a href="https://www.meritlilin.com/index.php/tw/product/{{$ListData->COD_ITEM}}" target="_blank">{{$ListData->COD_ITEM}}
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>{{$ListData->DSC_ITEM}}</td>
                                                <td>{{$ListData->NAM_ITEM}}</td>
                                                <td>{{$ListData->DAT_FILE}}</td>
                                                <td>{{$ListData->DAT_USET}}</td>
                                                <td>{{$ListData->DAT_SALED}}</td>
                                                <td>
                                                    <!-- EOL-22-0005 用這個型號測試 -->
                                                    @if ($ListData->official_website2 ==='EOL')
                                                    {{$ListData->official_website2}}
                                                    @else
                                                    <div>
                                                        <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/upload/EOL/{{$ListData->official_website2}}.pdf" target="_blank">{{$ListData->official_website2}}
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ListData->version ==null || $ListData->version ==='not ready')
                                                    <div color='red'>{{$ListData->version}}</div>
                                                    @else
                                                    <div>
                                                        {{$ListData->version}}
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
<script>
    $(ListData).DataTable({
        "autoWidth": false,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "info": true,
    })
</script>
</html>