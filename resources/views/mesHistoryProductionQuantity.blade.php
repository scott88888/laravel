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
            <div class="main-content-inner">
                <div class="row">
                    <!-- Dark table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">歷史產品生產數量</h4>
                            </div>
                            <div class="data-tables datatable-dark">
                                <table id="ListData" class="display text-center" style="width:100%">
                                    <thead class="text-capitalize" style=" background: darkgrey;">
                                        <tr>
                                            <th>產品名稱</th>
                                            <th>產品敘述</th>
                                            <th>最早開工日</th>
                                            <th>最晚開工日</th>
                                            <th>數量</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($MesHistoryProductionQuantity as $ListData)
                                        <tr>
                                            <td>
                                                <div>
                                                    <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/db_query_resumemodel.php?={{$ListData->COD_ITEM}}" target="_blank">{{$ListData->COD_ITEM}}
                                                </div>
                                            </td>                                      
                                            <td>{{$ListData->NAM_ITEM}}</td>
                                            <td>{{$ListData->MIN_CLDS_DAT_BEGA}}</td>
                                            <td>{{$ListData->MAX_CLDS_DAT_BEGA}}</td>
                                            <td>{{$ListData->SUM_CLDS_QTY_PCS}}</td>
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