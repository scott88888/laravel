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
                                <h4 class="header-title">ECN查詢</h4>
                                <div class="data-tables datatable-dark">
                                    <table id="ListData" class="display text-center" style="width:100%">
                                        <thead class="text-capitalize" style=" background: darkgrey;">
                                            <tr>
                                            <th></th>
                                                <th>ECR編號</th>
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
                                                <th>送驗單號</th>
                                                <th>規修單號</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($MesECNList as $ListData)
                                            <tr>
                                                <td><a href="editECRN?id={{$ListData->id}}" target="_blank"><span class="ti-pencil"></span>
                                                    </td>
                                                <td>                                                 
                                                    <div>
                                                        <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/upload/RD_ECRECN/ECR/{{$ListData->ECRNum}}.pdf" target="_blank">
                                                            {{$ListData->ECRNum}}
                                                    </div>                                                   
                                                </td>
                                                <td>
                                                    <div>
                                                        <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/upload/RD_ECRECN/ECN/{{$ListData->ECNNum}}.pdf" target="_blank">
                                                            {{$ListData->ECNNum}}
                                                    </div>                                              
                                                </td>
                                                <td>{{$ListData->noticeDate}}</td>
                                                <td>{{$ListData->model}}</td>
                                                <td>{{$ListData->reason}}</td>
                                                <td>{{$ListData->approved}}</td>
                                                <td>{{$ListData->charge}}</td>
                                                <td>{{$ListData->modificationDate}}</td>
                                                <td>{{$ListData->orderNumber}}</td>
                                                <td>{{$ListData->closeCase}}</td>
                                                <td>{{$ListData->remark}}</td>
                                                <td>{{$ListData->serialNumber}}</td>
                                                <td>{{$ListData->deliveryOrder}}</td>
                                                <td>{{$ListData->repairOrderNum}}</td>
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
        "order": [[3, "desc"]]
    })
</script>

</html>