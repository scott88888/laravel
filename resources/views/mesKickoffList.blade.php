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
                                <h4 class="header-title">客製化申請單查詢</h4>
                                <div class="data-tables datatable-dark">
                                    <table id="ListData" class="display text-center" style="width:100%">
                                        <thead class="text-capitalize" style=" background: darkgrey;">
                                            <tr>
                                                <th>單號</th>
                                                <th>客戶</th>
                                                <th>接收日期</th>
                                                <th>產品型號</th>
                                                <th>客戶型號</th>
                                                <th>業務</th>
                                                <th>數量</th>
                                                <th>實際出貨狀況</th>
                                                <th>需求</th>
                                                <th>客製單狀態</th>
                                                <th>表單更新日期</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($MesKickoffList as $ListData)
                                            <tr>      
                                                <td>
                                                <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/upload/kickoff/{{$ListData->kickoff_No}}.pdf" target="_blank">                                             
                                                {{$ListData->kickoff_No}}
                                                </td>
                                                
                                                <td>{{$ListData->customer}}</td>
                                                <td>{{$ListData->rec_date}}</td>
                                                <td>{{$ListData->model_name}}</td>
                                                <td>{{$ListData->model_customer}}</td>
                                                <td>{{$ListData->sales}}</td>
                                                <td>{{$ListData->qty}}</td>
                                                <td>{{$ListData->status}}</td>
                                                <td>{{$ListData->request}}</td>
                                                <td>   
                                                    @switch($ListData->kick_status)
                                                    @case('取消'||'不執行')
                                                    <p style="color:gray">{{$ListData->kick_status}}</p>
                                                    @break
                                                    @case('進行中')
                                                    <p style="color:green">{{$ListData->kick_status}}</p>
                                                    @break
                                                    @case('待確認'||'待客戶確認')
                                                    <<p style="color:red">{{$ListData->kick_status}}</p>
                                                    @break
                                                    @case('簽核中')
                                                    <p style="color:purple">{{$ListData->kick_status}}</p>
                                                    @break
                                                    @default
                                                    <p>{{$ListData->kick_status}}</p>
                                                    @endswitch</td>
                                                <td>{{$ListData->upload_date}}</td>
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