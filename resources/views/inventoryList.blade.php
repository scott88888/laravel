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
                                <h4 class="header-title">{{$country}}:{{ $langArray->庫存查詢 }}，{{ $langArray->更新時間 }}:{{$time}}</h4>
                                <div class="col-md-2 mb-3">
                                    <div class="col" style="text-align: center;">
                                    <a href="{{ asset('csv_files/' . $country . 'inventory.csv') }}" download="{{ $country }}inventory.csv">
                                            <button type="button" id="submit" class="btn btn-primary btn-block">download</button>
                                        </a>
                                    </div>
                                </div>
                                <div class="data-tables datatable-dark">
                                    <table id="ListData" class="display text-center" style="width:100%">
                                        <thead class="text-capitalize" style=" background: darkgrey;">
                                            <tr>
                                                <th>{{ $langArray->產品型號 }}</th>
                                                <th>{{ $langArray->庫存 }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($inventoryList as $ListData)
                                            <tr>

                                                <td>{{$ListData->modal}}</td>
                                                <td>{{$ListData->stock}}</td>

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
            [0, "desc"]
        ]
    })
</script>

</html>