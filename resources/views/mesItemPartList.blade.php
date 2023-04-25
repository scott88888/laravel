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
                                <h4 class="header-title">物料查詢</h4>
                                <div class="data-tables datatable-dark">
                                    <table id="ListData" class="display text-center" style="width:100%">
                                        <thead class="text-capitalize" style=" background: darkgrey;">
                                            <tr>
                                                <th>產品型號</th>
                                                <th>產品敘述</th>
                                                <th>庫存</th>
                                                <th>倉位</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($MesItemPartList as $ListData)
                                            <tr>
                                                <td>{{$ListData->COD_ITEM}}</td>
                                                <td>
                                                {{$ListData->NAM_ITEM}}
                                                </td>
                                                <td>{{$ListData->QTY_STK}}</td>
                                                <td>
                                                @switch($ListData->COD_LOC)
                                                    @case('GO-001')
                                                    <p style="color:blue">內銷成品倉</p>
                                                    @break
                                                    @case('WO-003')
                                                    <p style="color:green">外銷成品倉</p>
                                                    @break
                                                    @case('AO-111')
                                                    <p style="color:purple">共用料件倉</p>
                                                    @break
                                                    @case('LL-000')
                                                    <p style="color:red">內銷借品專用倉</p>
                                                    @break
                                                    @default
                                                    <p></p>
                                                    @endswitch
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
        "order": [[2, "desc"]]
    })
</script>

</html>