<!DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>

    @include('layouts/head')
</head>

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
                                <h4 class="header-title">產品型號查詢</h4>
                                <div class="data-tables datatable-dark">
                                    <table id="ListData" class="display text-center" style="width:100%">
                                        <thead class="text-capitalize" style=" background: darkgrey;">
                                            <tr>
                                                <th>產品型號</th>
                                                <th>產品性質</th>
                                                <th>產品名稱</th>
                                                <th>部別</th>
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
                                                    <div>
                                                        <a href="https://www.meritlilin.com/index.php/tw/product/{{$ListData->COD_ITEM}}" target="_blank">{{$ListData->COD_ITEM}}
                                                    </div>                                                   
                                                </td>
                                                <td>{{$ListData->DSC_ITEM}}</td>
                                                <td>{{$ListData->NAM_ITEM}}</td>
                                                <td>{{$ListData->TYP_ITEM}}</td>
                                                <td>{{$ListData->DAT_FILE}}</td>
                                                <td>{{$ListData->DAT_USET}}</td>
                                                <td>{{$ListData->DAT_SALED}}</td>
                                                <td>   
                                                    <div>
                                                        <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/upload/EOL/{{$ListData->DSC_ITEM_EOL}}.pdf" target="_blank">{{$ListData->DSC_ITEM_EOL}}
                                                    </div>
                                                </td>
                                                <td>
                                                  
                                                    <div>
                                                        {{$ListData->MAX_PS5}}
                                                    </div>
                                                   
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
        ...tableConfig,
        "order": [[0, "asc"]]
    })
</script>
</html>
