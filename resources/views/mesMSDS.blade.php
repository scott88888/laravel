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

<style>
    @media print {
        .no-print {
            display: none;
        }
    }
</style>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div id="loading">
        <img src="{{ asset('images/icon/loading.gif') }}" alt="Loading...">
    </div>

    <div class="page-container">
        @include('layouts/sidebar')
        <div class="main-content">
            @include('layouts/headerarea')
            <div>
                <div class="row" style="margin: 0;">
                    <!-- Dark table start -->
                    <div class="col-12" style="padding: 8px;">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">MSDS表</h4>
                                <div class="form-row">

                                    <div class="col-md-2 mb-3">
                                        <label for="">廠商編號</label>
                                        <input id="COD_FACT" type="texy" class="form-control" placeholder="" required="">
                                    </div>


                                    <div class="col-2" style="margin-left: 3rem;">
                                        <label for="">查詢</label>
                                        <div class="col" style="text-align: center;">
                                            <button type="button" id="submit" class="btn btn-primary btn-block">送出</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="data-tables datatable-dark">
                            <table id="ListData" class="display text-center" style="width:100%">
                                <thead class="text-capitalize" style=" background: darkgrey;">
                                    <th>照片</th>
                                    <th>廠商編號</th>
                                    <th>廠商名稱</th>
                                    <th>料號</th>
                                    <th>說明</th>


                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
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
    $(document).ready(function() {

        let Model;
        $('#loading').hide();

        var tableConfig = {
            language: dataTableLanguage,
            dom: 'lBfrtip',
            buttons: [
                'csv',
                'excel',
                'copy'

            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            order: [0, "desc"],
        };

        table = $('#ListData').DataTable({
            ...tableConfig,
            order: [
                [0, 'desc']

            ],
            columns: [{
                    "data": "COD_ITEM",
                    "title": "照片",
                    "render": function(data, type, row) {
                        if (data.length > 0) {
                            var imageUrl = '{{ asset("/show-image/mesitempartlist/") }}' + '/' + data + '/' + data + '.jpg';
                            var imageUrls = '{{ asset("/show-image/mesitempartlist/") }}' + '/' + data + '/' + data + '-s.jpg';
                            return '<a href="' + imageUrl + '" target="_blank"><img style="max-width:50px;" src="' + imageUrls + '"></a>';
                        } else {
                            return '';
                        }
                    }
                },
                {
                    "data": "COD_FACT",
                    "title": "廠商編號"
                },
                {
                    "data": "NAM_FACT",
                    "title": "廠商名稱"
                },
                {
                    "data": "COD_ITEM",
                    "title": "料號"
                },
                {
                    "data": "NAM_ITEMF",
                    "title": "說明"
                },

            ]
        });

        $('#submit').click(function() {
            var COD_FACT = $('#COD_FACT').val();
            $('#loading').show();
            $.ajax({
                url: 'mesMSDSAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    COD_FACT: COD_FACT
                },
                success: function(response) {
                    table.clear();
                    table.rows.add(response);
                    table.draw();
                    console.log(response);
                    $('#loading').hide();
                },
                error: function(xhr, status, error) {
                    console.log('no data');
                    $('#loading').hide();
                }
            });

        });


    });
</script>

</html>