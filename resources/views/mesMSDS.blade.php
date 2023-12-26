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
                                    <label>重量(mg)</label>
                                    <input id="weight" type="number" class="form-control" placeholder="" value="">
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
                                    <input id="content" type="number" class="form-control" placeholder="" value="">
                                </div>
                            </div>
                            <div class="0" style="margin: 4% 25%;width: 50%;text-align: center;margin-bottom: 0.5rem;">
                                <button type="button" id="insertCOS" class="btn btn-primary btn-block">
                                    <li class="fa fa-cloud-upload">新增</li>
                                </button>
                            </div>

                        </div>
                        <div class="data-tables datatable-dark" style="margin: 2rem;">
                            <table id="MSDSData" class="display text-center" style="width:100%">
                                <thead class="text-capitalize" style=" background: darkgrey;">
                                    <tr>
                                        <th>料件名稱</th>
                                        <th>料件編號</th>
                                        <th>No</th>
                                        <th>化學物質(英)</th>
                                        <th> 化學物質(中)</th>
                                        <th>物質含量</th>
                                        <th>重量</th>
                                        <th>選取</th>
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
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="delMSDS">刪除</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">確認</button>
                        </div>
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
                    "targets": 0,
                    "data": "check",
                    "title": "選取",
                    "type": "checkbox",
                    "render": function(data, type, row, meta) {
                        // 如果欄位值為 true，則顯示勾選圖示
                        if (data === true) {
                            return '<input type="checkbox" data-id="' + row.id + '">';
                        } else {
                            // 如果欄位值為 false，則顯示未勾選圖示
                            return '<input type="checkbox" data-id="' + row.id + '">';
                        }
                    }
                },
                {
                    "data": "partName",
                    "targets": 1,
                    "title": "料件名稱",

                }, {
                    "data": "partNumber",
                    "targets": 2,
                    "title": "料件編號",

                },
                {
                    "data": "casCode",
                    "targets": 3,
                    "title": "CAS No"
                },
                {
                    "data": "CAS_NoE",
                    "targets": 4,
                    "title": "化學物質(英)"
                },
                {
                    "data": "CAS_NoC",
                    "targets": 5,
                    "title": "化學物質(中)"
                },
                {
                    "data": "content",
                    "targets": 6,
                    "title": "物質含量(%)"
                },
                {
                    "data": "weight",
                    "targets": 7,
                    "title": "重量(mg)"
                },


            ]


        });
        $('#ListData').on('click', '#openModalButton', function() {
            var modalValue = $(this).data('modal-value');
            var modalName = $(this).data('modal-name');
            selectMSDS(modalValue, modalName);

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
        $('#delMSDS').click(function() {
           
            delMSDSAjax();

        });
        function selectMSDS(modalValue, modalName) {
            $('#loading').show();
            $.ajax({
                url: 'mesSelectMSDSAjax',
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
                    console.log(response);

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
                url: 'mesCasCodeSearchAjax',
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
        $('#insertCOS').click(function() {
            var addDataArray = [];
            addDataArray['partName'] = $('#partName').val();
            addDataArray['partNumber'] = $('#partNumber').val();
            addDataArray['casCode'] = $('#casCode').val();
            addDataArray['CAS_NoE'] = $('#CAS_NoE').val();
            addDataArray['CAS_NoC'] = $('#CAS_NoC').val();
            addDataArray['content'] = $('#content').val();
            addDataArray['weight'] = $('#weight').val();


            addData(addDataArray);
            MesCasInsertAjax(addDataArray);
        });

        function addData(addDataArray) {
            var data = {
                partName: addDataArray['partName'],
                partNumber: addDataArray['partNumber'],
                casCode: addDataArray['casCode'],
                CAS_NoE: addDataArray['CAS_NoE'],
                CAS_NoC: addDataArray['CAS_NoC'],
                content: addDataArray['content'],
                weight: addDataArray['weight'],
                check: false
            };

            MSDStable.row.add(data).draw();
        }

        function MesCasInsertAjax(addDataArray) {

            $.ajax({
                url: 'mesCasInsertAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    partName: addDataArray['partName'],
                    partNumber: addDataArray['partNumber'],
                    casCode: addDataArray['casCode'],
                    CAS_NoE: addDataArray['CAS_NoE'],
                    CAS_NoC: addDataArray['CAS_NoC'],
                    content: addDataArray['content'],
                    weight: addDataArray['weight']
                },
                success: function(response) {

                    console.log(response);
                    $('#loading').hide();
                },
                error: function(xhr, status, error) {
                    console.log(response);
                    $('#loading').hide();
                }
            });
        }

        function delMSDSAjax() {
            // 選擇所有 checkbox 元素
            var checkboxes = $(document).find('input[type="checkbox"]');
            var result = [];
            // 遍歷所有 checkbox 元素
            checkboxes.each(function() {
                // 如果 checkbox 元素的 checked 屬性為 true
                if ($(this).prop('checked')) {
                    // 獲取該元素的 data-modal-value 屬性值
                    var delID = $(this).attr('data-id');

                    // 將 data-modal-value 值加入到結果集合中
                    result.push(delID);
                }
            });
            var partNumber = $('#partNumber').val();
            $.ajax({
                url: 'mesDelMSDSAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    result: result,
                    partNumber:partNumber
                },
                success: function(response) {

                    var MSDStable = $('#MSDSData').DataTable();
                    MSDStable.clear().rows.add(response).draw();
                    $('#loading').hide();
                    alert('刪除成功');
                },
                error: function(xhr, status, error) {
                    console.log(response);
                    $('#loading').hide();
                }
            });
        }
    });
</script>

</html>