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
                <div class="row" style=" margin-left:0;margin-right:0;">
                    <!-- Dark table start -->
                    <div class="col-12 mt-1">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">登入紀錄查詢</h4>
                                <div class="data-tables datatable-dark">
                                    <table id="ListData" class="display text-center" style="width:100%">
                                        <thead class="text-capitalize" style=" background: darkgrey;">
                                            <tr>
                                                <th>使用者</th>
                                                <th>頁面</th>
                                                <th>時間</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($value as $ListData)
                                            <tr>
                                                <td>{{$ListData->user_name}}</td>
                                                <td>{{$ListData->log_url}}</td>
                                                <td>{{$ListData->log_time}}</td>
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
        "order": [
            [2, "desc"]
        ]
    })
</script>

</html>