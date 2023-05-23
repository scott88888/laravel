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
                                <h4 class="header-title">ECN查詢</h4>
                                <div class="data-tables datatable-dark">
                                    <table id="ListData" class="display text-center" style="width:100%">
                                        <thead class="text-capitalize" style=" background: darkgrey;">
                                            <tr>
                                                <th class='hide_column'>ECR編號</th>
                                                <th>ECN編號</th>
                                                <th>通知日期</th>
                                                <th>機種</th>
                                                <th>事由</th>
                                                <th>核准</th>
                                                <th>擔當</th>
                                                <th>生管修改日期</th>
                                                <th>製造單號</th>
                                                <th>結案</th>
                                                <th>備註</th>
                                                <th>出廠序號</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($MesECNList as $ListData)
                                            <tr>
                                                <td>
                                                    @if ($ListData->ecr_no == "x" || $ListData->ecr_no == "X" )
                                                    <div>{{$ListData->ecr_no}}</div>
                                                    @else
                                                    <div>
                                                        <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/upload/RD_ECRECN/ECR/{{$ListData->ecr_no}}" target="_blank">
                                                            {{$ListData->ecr_no}}
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ListData->ecn_no == "x" || $ListData->ecn_no == "X" )
                                                    {{$ListData->ecn_no}}
                                                    @else
                                                    <div>
                                                        <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/upload/RD_ECRECN/ECN/{{$ListData->ecn_no}}" target="_blank">
                                                            {{$ListData->ecn_no}}
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>{{$ListData->ecn_release_date}}</td>
                                                <td>{{$ListData->model}}</td>
                                                <td>{{$ListData->description}}</td>
                                                <td>{{$ListData->approve}}</td>
                                                <td>{{$ListData->rd_enginner}}</td>
                                                <td>{{$ListData->pc_get_date}}</td>
                                                <td>{{$ListData->work_no}}</td>
                                                <td>{{$ListData->status}}</td>
                                                <td>{{$ListData->remark}}</td>
                                                <td>{{$ListData->remark2}}</td>
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
        responsive: true,
        "order": [[3, "desc"]]
    })
</script>
</html>