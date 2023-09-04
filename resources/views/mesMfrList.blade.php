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
                    <div class="col-12 mt-1">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">借品未歸還一覽表</h4>
                            </div>
                            <div class="data-tables datatable-dark">
                                <table id="ListData" class="display text-center" style="width:100%">
                                    <thead class="text-capitalize" style=" background: darkgrey;">
                                        <tr>
                                            <th>借出單號</th>
                                            <th>部門</th>
                                            <th>業務員</th>
                                            <th>往來對象</th>
                                            <th>品名</th>
                                            <th>借出數量</th>
                                            <th>借出日期</th>
                                            <th>預定歸還日期</th>
                                            <th>逾期天數</th>
                                            <th>實際歸還日期</th>
                                            <th>實際歸還數量</th>
                                            <th>借出原因</th>
                                            
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($MesMfrList as $ListData)
                                        <tr>
                                            <td>{{$ListData->NUM_BROW}}</td>
                                            <td>{{$ListData->COD_DPT}}</td>
                                            <td>{{$ListData->NUM_BROW}}||{{$ListData->NAM_EMP}}</td>
                                            <td>{{$ListData->NAM_FACTS}}</td>
                                            <td>{{$ListData->COD_ITEM}}</td>
                                            <td>{{$ListData->QTY_BROW}}</td>
                                            <td>{{$ListData->DAT_BROW}}</td>
                                            <td>{{$ListData->DAT_RRTN}}</td>
                                            <td>
                                                @if ($ListData->DATE_GAP < 8 && $ListData->DATE_GAP >= 0 )
                                                <p style="color:red">即將逾期</p>
                                                @elseif ($ListData->DATE_GAP >= 8 )
                                                <p style="color:blue">未逾期</p>
                                                @else
                                                <p style="color:red">{{abs($ListData->DATE_GAP)}}</p>
                                                @endif
                                            </td>
                                            <td>{{$ListData->DAT_ARTN}}</td>
                                            <td>{{$ListData->CNT_ARTN}}</td>
                                            <td>
                                                @switch($ListData->CLS_BROW)
                                                @case('1')
                                                <p style="color:blue">TEST</p>
                                                @break
                                                @case('2')
                                                <p style="color:blue">R&D</p>
                                                @break
                                                @case('3')
                                                <p style="color:blue">訂單</p>
                                                @break
                                                @case('4')
                                                <p style="color:blue">展覽</p>
                                                @break
                                                @case('5')
                                                <p style="color:blue">安規檢測</p>
                                                @break
                                                @case('6')
                                                <p style="color:blue">退品</p>
                                                @break
                                                @case('7')
                                                <p style="color:blue">維修用料</p>
                                                @break
                                                @case('8')
                                                <p style="color:blue">不良品交換用</p>
                                                @break
                                                @case('9')
                                                <p style="color:blue">委外訂單</p>
                                                @break
                                                @case('10')
                                                <p style="color:blue">借換品</p>
                                                @break
                                                @case('11')
                                                <p style="color:blue">部門間的需求</p>
                                                @break
                                                @case('12')
                                                <p style="color:green">規修用料</p>
                                                @break
                                                @case('13')
                                                <p style="color:green">重烤漆或印刷</p>
                                                @break
                                                @case('14')
                                                <p style="color:green">廠商進貨不足待補</p>
                                                @break
                                                @case('15')
                                                <p style="color:green">重新加工</p>
                                                @break
                                                @default
                                                <p>{{$ListData->CLS_BROW}}</p>
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
    var table;
    table = $('#ListData').DataTable({
            ...tableConfig,   
        "autoWidth": false,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "info": true,
        responsive: true,
        "order": [],
    })
</script>

</html>