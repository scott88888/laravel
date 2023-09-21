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
                                <h4 class="header-title">使用者列表</h4>
                                <div class="data-tables datatable-dark">
                                    <table id="ListData" class="display text-center" style="width:100%">
                                        <thead class="text-capitalize" style=" background: darkgrey;">
                                            <tr>

                                                <th></th>
                                                <th>員編</th>
                                                <th>姓名</th>
                                                <th>郵箱</th>
                                                <th>權限數</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($userEdit as $ListData)
                                            <tr>
                                                <td><a href="editUserPer?id={{$ListData->employee_id}}" target="_blank"><span class="ti-pencil"></span></td>
                                                <td>{{$ListData->employee_id}}</td>
                                                <td>{{$ListData->name}}</td>
                                                <td>{{$ListData->email}}</td>
                                                <td>{{$ListData->number_count}}</td>
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
            [1, "desc"]
        ]
    })
</script>

</html>