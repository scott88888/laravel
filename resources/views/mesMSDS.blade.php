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

            <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="max-width: 70%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">BOM</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row align-items-center" style="margin: 2rem;">
                                <div class="col-4" id="">
                                    <label>料件名稱</label>
                                    <input id="partName" type="text" class="form-control" placeholder="" value="">
                                </div>
                                <div class="col-4" id="">
                                    <label>料件編號</label>
                                    <input id="partNumber" type="text" class="form-control" placeholder="" value="" readonly>
                                </div>
                                <div class="col-4" id="">
                                    <label>重量</label>
                                    <input id="customerNumber" type="text" class="form-control" placeholder="" value="">
                                </div>
                            </div>
                            <div class="form-row align-items-center" style="margin: 2rem;">

                                <div class="col-4">
                                    <label for="casCode" class="form-label">CAS No(代碼)</label>
                                    <input type="text" id="casCode" list="casCodes" class="form-control">
                                    <datalist id="casCodes">
                                        @foreach ($casCode as $casCode)
                                        <option value="{{ $casCode->CASNo}}">{{ $casCode->CASNo}}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="col-2" style="margin-left: 3rem;">
                                    <label for="">查詢</label>
                                    <div class="col" style="text-align: center;">
                                        <button type="button" id="casCodeSearch" class="btn btn-primary btn-block">送出</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row align-items-center" style="margin: 2rem;">
                                <div class="col-5">
                                    <label>化學物質(英)</label>
                                    <input id="CAS_NoE" type="text" class="form-control" placeholder="" value="" readonly>
                                </div>
                                <div class="col-5">
                                    <label>化學物質(中)</label>
                                    <input id="CAS_NoC" type="text" class="form-control" placeholder="" value="" readonly>
                                </div>
                                <div class="col-2" id="">
                                    <label>物質含量(%)</label>
                                    <input id="customerAdd" type="text" class="form-control" placeholder="" value="">
                                </div>
                            </div>                        
                            <div class="0" style="margin: 4% 25%;width: 50%;text-align: center;margin-bottom: 0.5rem;">
                                <button type="button" id="createRMA" class="btn btn-primary btn-block">
                                    <li class="fa fa-cloud-upload">新增</li>
                                </button>
                            </div>

                        </div>
                        <div class="data-tables datatable-dark" style="margin: 2rem;">
                            <table id="MSDSData" class="display text-center" style="width:100%">
                                <thead class="text-capitalize" style=" background: darkgrey;">
                                    <tr>
                                        <th>照片</th>
                                        <th>料件</th>
                                        <th>料號說明</th>
                                        <th>在庫庫存</th>
                                        <th>在途量</th>
                                        <th>交期</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 1px;"></td>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">確認</button>
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
                    "targets": 0,
                    "title": "料號",
                    "render": function(data, type, row) {
                        if (data.length > 0) {
                            return '<a href="#" id="openModalButton" data-modal-value="' + data + '" data-modal-name="' + row.NAM_ITEMF + '">' + data + '</a>';
                            return button[0].outerHTML;
                        } else {
                            return '';
                        }
                    }
                },
                {
                    "data": "NAM_ITEMF",
                    "title": "說明"
                },

            ]
        });
        MSDStable = $('#MSDSData').DataTable({
            ...tableConfig,
            "info": false,
            "lengthChange": false,
            "paging": false,
            "scrollCollapse": true, // 啟用捲動條收縮
            columnDefs: [{
                    "targets": "_all",
                    "className": "dt-center"
                },
                {
                    "data": "COD_ITEMS",
                    "targets": 0,
                    "title": "料件名稱",

                }, {
                    "data": "COD_ITEMS",
                    "targets": 1,
                    "title": "料件編號",

                },
                {
                    "data": "NAM_ITEM",
                    "targets": 2,
                    "title": "CAS No"
                },
                {
                    "data": "qty",
                    "targets": 3,
                    "title": "化學物質"
                },
                {
                    "data": "SUN_QTY",
                    "targets": 4,
                    "title": "物質含量(%)"
                },
                {
                    "data": "DAT_REQ",
                    "targets": 5,
                    "title": "重量"
                }
            ]


        });
        $('#ListData').on('click', '#openModalButton', function() {
            var modalValue = $(this).data('modal-value');
            var modalName = $(this).data('modal-name');
            selectBOM(modalValue, modalName);

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

        function selectBOM(modalValue, modalName) {
            $('#loading').show();
            $.ajax({
                url: 'mesBOMSelectAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    modalValue: modalValue,
                },
                success: function(response) {

                    $('#loading').hide();
                    var MSDStable = $('#MSDSData').DataTable();
                    MSDStable.clear().rows.add(response).draw();

                    $('#myModalLabel').text('料件明細表');
                    $('#partNumber').val(modalValue);
                    $('#partName').val(modalName);


                    $('#delModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.log('no data');
                    table.clear();
                    $('#loading').hide();
                }
            });

        }

        $('#casCodeSearch').click(function() {
            var casCode = $('#casCode').val();
            $('#loading').show();
            $.ajax({
                url: 'MesCasCodeSearchAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    casCode: casCode
                },
                success: function(response) {

                    console.log(response);
                    $('#CAS_NoE').val(response[0]['SubstanceName']);
                    $('#CAS_NoC').val(response[0]['SubstanceName2']);
                    $('#loading').hide();
                },
                error: function(xhr, status, error) {
                    console.log('no data');
                    $('#CAS_NoE').val('');
                    $('#CAS_NoC').val('');
                    $('#loading').hide();
                }
            });

        });

    });
</script>

</html>