<!DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>

    @include('layouts/head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    .modal-footer .button-group {
        float: left;
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
        @include('layouts/VendorSidebar')
        <div class="main-content">
            @include('layouts/VendorHeaderarea')

            <div class="row" style="margin: 0;">
                <!-- Dark table start -->
                <div class="col-12" style="padding: 8px;">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">MSDS表(經銷)</h4>
                            <div class="form-row">
                                <div class="col-md-2 mb-3">
                                    <label class="col-form-label" style="padding-top: 0;">查詢類型</label>
                                    <select id="searchType" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);" disabled>
                                        <option value="COD_FACT" selected>廠商編號</option>
                                        <option value="COD_ITEM">料件編號</option>
                                    </select>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label class="col-form-label" style="padding-top: 0;">查詢內容</label>
                                    <input id="searchName" type="texy" class="form-control" value="{{$COD_FACT}}" readonly>
                                </div>


                                <div class="col-md-2 mb-3">
                                    <label for="" style="padding-top: 0;">查詢</label>
                                    <div class="col" style="text-align: center;">
                                        <button type="button" id="submit" class="btn btn-primary btn-block">送出</button>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="" style="padding-top: 0;">複製料號</label>
                                    <div class="col" style="text-align: center;">
                                        <button type="button" id="msdscopy" class="btn btn-primary btn-block">複製</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="data-tables datatable-dark">
                        <table id="ListData" class="display text-center" style="width:100%">
                            <thead class="text-capitalize" style=" background: darkgrey;">
                                <th>選取</th>
                                <th>照片</th>
                                <th>廠商編號</th>
                                <th>廠商名稱</th>
                                <th>料號</th>
                                <th>說明</th>
                                <th>加總</th>
                                <th>承認書</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
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
                </div>
            </div>

            <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="max-width: 70%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">料件明細表</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row align-items-center" style="margin: 2rem;">
                                <div class="col-4" id="">
                                    <label>料件編號</label>
                                    <input id="partNumber" type="text" class="form-control" placeholder="" value="" readonly>
                                </div>
                                <div class="col-4" id="">
                                    <label>料件名稱</label>
                                    <input id="partName" type="text" class="form-control" placeholder="" value="">
                                </div>

                                <div class="col-4" id="">
                                    <label>廠商料件名稱(可空白)</label>
                                    <input id="factoryPartName" type="text" class="form-control" placeholder="" value="">
                                </div>

                            </div>
                            <div class="form-row align-items-center" style="margin: 2rem;">
                                <div class="col-3" id="">
                                    <label>料件總重量(mg)</label>
                                    <input id="partWeight" type="number" class="form-control" placeholder="" value="" readonly>
                                </div>

                                <div class="col-2" style="margin-left: 3rem;">
                                    <label for="">更新</label>
                                    <div class="col" style="text-align: center;">
                                        <button type="button" id="editWeight" class="btn btn-info ">編輯重量</button>
                                        <button type="button" id="updateWeight" class="btn btn-primary ">更新重量</button>

                                    </div>
                                </div>
                                <div class="col-5" style="margin: 2rem;">
                                    <span class="ti-upload">承認書</span>
                                    <input id="certificateName" style="display: none;">
                                    <form id="certificateForm" enctype="multipart/form-data">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="certificateInput" id="certificateInput" accept=".pdf" onchange="updateFileName(this,'certificate')">
                                                <label class="custom-file-label" id="certificate">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button class="input-group-text" type="button" onclick="uploadFile('certificate')">Upload</button>
                                            </div>
                                        </div>
                                    </form>
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
                                <button type="button" id="editCOS" class="btn btn-info btn-block">
                                    <li class="fa fa-cloud-upload">確認修改</li>
                                </button>
                            </div>

                        </div>
                        <div class="data-tables datatable-dark" style="margin: 2rem;">
                            <table id="MSDSData" class="display text-center" style="width:100%">
                                <thead class="text-capitalize" style=" background: darkgrey;">
                                    <tr>
                                        <th>料件名稱</th>
                                        <th>料件編號</th>
                                        <th>CNo</th>
                                        <th>化學物質(英)</th>
                                        <th>化學物質(中)</th>
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

                        <div class="modal-footer" style="justify-content:center">
                            <button type="button" class="btn btn-info" id="editMSDS">修改</button>
                            <button type="button" class="btn btn-danger" style="margin-right: 60%;" id="delMSDS">刪除</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: 11.25px 7%;">確認</button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="copyModal" tabindex="-1" role="dialog" aria-labelledby="copyModalLabel">
                <div class="modal-dialog" role="document" style="max-width: 70%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="copyModalLabel">複製料號MSDS</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row align-items-center" style="margin: 2rem;">
                                <div class="col-4" id="">
                                    <label>來源料號</label>
                                    <input id="sourceItem" type="text" class="form-control" placeholder="" value="" readonly>
                                </div>

                            </div>
                            <div class="data-tables datatable-dark" style="margin: 2rem;">
                                <label>目的料號(請勾選)</label>
                                <table id="copyModalTable" class="display text-center" style="width:100%">
                                    <thead class="text-capitalize" style=" background: darkgrey;">
                                        <tr>
                                            <th>選取</th>
                                            <th>廠商編號</th>
                                            <th>廠商名稱</th>
                                            <th>料號</th>
                                            <th>說明</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: 1px;"></td>
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <button type="button" id="copyMSDSData" class="btn btn-success" data-dismiss="">確認</button>
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
@include('layouts/VendorFooterjs')

<script>
    var table;
    var COD_FACT_part = $("#COD_FACT_part");
    var rowData = '';
    var editCOSid;
    COD_FACT_part.css("visibility", "hidden");
    $(document).ready(function() {
        let Model;
        $('#loading').hide();
        $('#updateWeight').hide();
        $('#editCOS').hide();
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
        let Backup_icon = '<img src=' + '{{ asset("images/icon/Backup_Blue_64x64px.png")}} style="width: 1.5rem;"">';
        table = $('#ListData').DataTable({
            ...tableConfig,
            order: [
                [0, 'desc']

            ],
            columns: [{
                    "targets": 0,
                    "data": "check",
                    "title": "選取",
                    "type": "checkbox",
                    "render": function(data, type, row, meta) {
                        // 如果欄位值為 true，則顯示勾選圖示
                        if (data === true) {
                            return '<input type="checkbox" MSDSdata-id="' + row.id + '">';
                        } else {
                            // 如果欄位值為 false，則顯示未勾選圖示
                            return '<input type="checkbox" MSDSdata-id="' + row.id + '">';
                        }
                    }
                }, {
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
                            return '<a href="#" id="openModalButton" data-modal-value="' + data + '" data-modal-name="' + row.NAM_ITEMF + '"data-modal-fact="' + row.COD_FACT + '">' + data + '</a>';
                            return button[0].outerHTML;
                        } else {
                            return '';
                        }
                    }
                },
                {
                    "data": "NAM_ITEMF",
                    "title": "說明"
                }, {
                    "data": "total",
                    "title": "加總%"
                }, {
                    "data": "COD_ITEM",
                    "targets": 0,
                    "title": "承認書",
                    "render": function(data, type, row) {
                        if (data.length > 0) {
                            return '<a href="https://mes.meritlilin.com.tw/support/www/MES/lilin/upload/certificateMSDS/' + row.COD_FACT +'/'+ data + '.pdf" target="_blank">' + Backup_icon + '</a>';
                            
                        } else {
                            return '';
                        }
                    }

                }


            ]
        });

        $('#ListData').on('click', 'input[type="checkbox"]', function() {

            var isChecked = $(this).is(':checked');
            rowData = table.row($(this).closest('tr')).data();
            if (isChecked) {

            }
        });
        copyModalTable = $('#copyModalTable').DataTable({
            ...tableConfig,
            order: [
                [0, 'desc']

            ],
            columns: [{
                    "targets": 0,
                    "data": "check",
                    "title": "選取",
                    "type": "checkbox",
                    "render": function(data, type, row, meta) {
                        // 如果欄位值為 true，則顯示勾選圖示
                        if (data === true) {
                            return '<input type="checkbox" MSDSdata-id="' + row.id + '">';
                        } else {
                            // 如果欄位值為 false，則顯示未勾選圖示
                            return '<input type="checkbox" MSDSdata-id="' + row.id + '">';
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
                            return '<a href="#" id="openModalButton" data-modal-value="' + data + '" data-modal-name="' + row.NAM_ITEMF + '"data-modal-fact="' + row.COD_FACT + '">' + data + '</a>';
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

        $('#msdscopy').on('click', function() {
            if (rowData) {
                var searchType = $('#searchType').val();
                var searchName = $('#searchName').val();
                var sourceItem = rowData['COD_ITEM'];

                $('#loading').show();
                $.ajax({
                    url: 'VendorMSDSCopyListAjax',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        searchType: searchType,
                        searchName: searchName,
                        sourceItem: sourceItem
                    },
                    success: function(response) {
                        copyModalTable.clear();
                        copyModalTable.rows.add(response);
                        copyModalTable.draw();

                        $('#copyModal').modal('show');
                        $('#sourceItem').val(rowData['COD_ITEM']);
                        $('#loading').hide();
                    },
                    error: function(xhr, status, error) {
                        console.log('no data');
                        $('#loading').hide();
                    }
                });
            }
        });

        // 假设你的表格的 id 是 exampleTable
        $('#copyMSDSData').on('click', function() {

            var selectedCheckboxes = [];

            // 遍历表格中的每一行
            $('#copyModalTable tbody tr').each(function() {
                var checkbox = $(this).find('input[type="checkbox"]');
                if (checkbox.is(':checked')) {
                    var rowDataId = checkbox.attr('MSDSdata-id');
                    selectedCheckboxes.push(rowDataId);
                }
            });

            if (selectedCheckboxes.length > 0) {

                var searchType = $('#searchType').val();
                var searchName = $('#searchName').val();
                var sourceItem = $('#sourceItem').val();


                $('#loading').show();
                $.ajax({
                    url: 'VendorMSDSCopyAjax',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        searchType: searchType,
                        searchName: searchName,
                        sourceItem: sourceItem,
                        selectedCheckboxes: selectedCheckboxes
                    },
                    success: function(response) {
                        alert('複製成功' + response);
                        $('#loading').hide();
                    },
                    error: function(xhr, status, error) {
                        console.log('no data');
                        $('#loading').hide();
                    }
                });

            }

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
            var COD_FACT = $(this).data('modal-fact');
            $('#casCode').val('');
            $('#CAS_NoE').val('');
            $('#CAS_NoC').val('');
            $('#content').val('');
            $('#factoryPartName').val('');
            selectMSDS(modalValue, modalName, COD_FACT);

        });

        var FACT = '{{$COD_FACT}}';

        if (FACT.length > 1) {
            var searchType = 'COD_FACT';
            var searchName = FACT;
            $('#loading').show();
            $.ajax({
                url: 'VendorMSDSAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    searchType: searchType,
                    searchName: searchName
                },
                success: function(response) {
                    table.clear();
                    table.rows.add(response);
                    table.draw();

                    $('#loading').hide();
                },
                error: function(xhr, status, error) {
                    console.log('no data');
                    $('#loading').hide();
                }
            });
        }

        $('#submit').click(function() {
            var searchType = 'COD_FACT';
            var searchName = FACT;
            $('#loading').show();
            $.ajax({
                url: 'VendorMSDSAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    searchType: searchType,
                    searchName: searchName
                },
                success: function(response) {
                    table.clear();
                    table.rows.add(response);
                    table.draw();

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
        $('#editMSDS').click(function() {
            var selectedRowsData = [];

            // 找到被勾選的 checkbox
            $('#MSDSData tbody input[type="checkbox"]:checked').each(function() {
                var rowData = MSDStable.row($(this).closest('tr')).data();
                selectedRowsData.push(rowData);
            });
            if (selectedRowsData.length == 1) {
                $('#partName').val(selectedRowsData[0]['partName']);
                $('#factoryPartName').val(selectedRowsData[0]['partName']);
                $('#casCode').val(selectedRowsData[0]['casCode']);
                $('#CAS_NoE').val(selectedRowsData[0]['CAS_NoE']);
                $('#CAS_NoC').val(selectedRowsData[0]['CAS_NoC']);
                $('#content').val(selectedRowsData[0]['content']);
                editCOSid = selectedRowsData[0]['id'];
                $('#editCOS').show();
                $('#insertCOS').hide();
            } else {
                alert('請選擇單筆資料');
                return;
            }

            console.log(selectedRowsData);
            console.log(selectedRowsData.length);
        });
        $('#editCOS').click(function() {

            const casCode = $('#casCode').val();
            const partWeight = $('#partWeight').val();
            const CAS_NoE = $('#CAS_NoE').val();
            const content = $('#content').val();
            const isEmpty = casCode === '' || partWeight === '' || CAS_NoE === '' || content === '';
            var displayValue = $('#updateWeight').css('display');
            if (isEmpty === true) {
                alert('請選擇單筆資料');
            } else if (content > 100) {
                alert('物質含量超過100');
            } else if (displayValue !== 'none') {
                alert('請先更新重量');
                return;
            } else {
                var addDataArray = [];
                addDataArray['id'] = editCOSid;
                addDataArray['partName'] = $('#partName').val();
                addDataArray['partNumber'] = $('#partNumber').val();
                addDataArray['casCode'] = $('#casCode').val();
                addDataArray['CAS_NoE'] = $('#CAS_NoE').val();
                addDataArray['CAS_NoC'] = $('#CAS_NoC').val();
                addDataArray['content'] = $('#content').val();
                addDataArray['COD_FACT_part'] = window.COD_FACT;
                console.log(addDataArray);

                $('#loading').show();
                $.ajax({
                    url: 'VendorEditMSDSAjax',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        editCOSid: editCOSid,
                        partName: $('#partName').val(),
                        partNumber: $('#partNumber').val(),
                        casCode: $('#casCode').val(),
                        CAS_NoE: $('#CAS_NoE').val(),
                        CAS_NoC: $('#CAS_NoC').val(),
                        content: $('#content').val(),
                        COD_FACT_part: COD_FACT,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        MSDStable.clear();
                        MSDStable.rows.add(response);
                        MSDStable.draw();
                        $('#loading').hide();
                        alert('修改成功');
                        $('#partName').val('');
                        $('#factoryPartName').val('');
                        $('#casCode').val('');
                        $('#CAS_NoE').val('');
                        $('#CAS_NoC').val('');
                        $('#content').val('');

                    },
                    error: function(xhr, status, error) {
                        console.log(response);
                        $('#loading').hide();
                    }
                });
            }


        });

        function selectMSDS(modalValue, modalName, COD_FACT) {
            $('#loading').show();
            $.ajax({
                url: 'VendorSelectMSDSAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    modalValue: modalValue,
                    COD_FACT: COD_FACT
                },
                success: function(response) {

                    $('#loading').hide();
                    MSDStable.clear();
                    MSDStable.rows.add(response);
                    MSDStable.draw();
                    $('#myModalLabel').text('料件明細表');
                    $('#partNumber').val(modalValue);
                    $('#partName').val(modalName);

                    window.COD_FACT = COD_FACT;
                    if (response.length === 0) {
                        $('#partWeight').val('');
                    } else {
                        $('#partWeight').val(response[0]['partWeight']);
                    }
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

            if ($('#casCode').val() == '') {
                alert('CAS No(代碼)欄位沒有輸入');
                return;
            }

            var casCode = $('#casCode').val();
            $('#loading').show();
            $.ajax({
                url: 'VendorCasCodeSearchAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    casCode: casCode
                },
                success: function(response) {
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
            const casCode = $('#casCode').val();
            const partWeight = $('#partWeight').val();
            const CAS_NoE = $('#CAS_NoE').val();
            const content = $('#content').val();
            const isEmpty = casCode === '' || partWeight === '' || CAS_NoE === '' || content === '';
            var displayValue = $('#updateWeight').css('display');
            if (isEmpty === true) {
                alert('尚有欄位沒有輸入');
            } else if (content > 100) {
                alert('物質含量超過100');
            } else if (displayValue !== 'none') {
                alert('請先更新重量');
                return;
            } else {
                var product = $('#partWeight').val() * $('#content').val() / 100;
                var addDataArray = [];
                addDataArray['partName'] = $('#partName').val();
                addDataArray['partNumber'] = $('#partNumber').val();
                addDataArray['casCode'] = $('#casCode').val();
                addDataArray['CAS_NoE'] = $('#CAS_NoE').val();
                addDataArray['CAS_NoC'] = $('#CAS_NoC').val();
                addDataArray['content'] = $('#content').val();
                addDataArray['weight'] = product;
                addDataArray['COD_FACT_part'] = window.COD_FACT;
                addData(addDataArray);
                MesCasInsertAjax(addDataArray);
            }
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
            $('#loading').show();
            $.ajax({
                url: 'VendorCasInsertAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    partName: addDataArray['partName'],
                    partNumber: addDataArray['partNumber'],
                    casCode: addDataArray['casCode'],
                    CAS_NoE: addDataArray['CAS_NoE'],
                    CAS_NoC: addDataArray['CAS_NoC'],
                    content: addDataArray['content'],
                    weight: addDataArray['weight'],
                    COD_FACT_part: addDataArray['COD_FACT_part']
                },
                success: function(response) {
                    $('#casCode').val('');
                    $('#loading').hide();
                },
                error: function(xhr, status, error) {
                    console.log(response);
                    $('#loading').hide();
                }
            });
        }

        function delMSDSAjax() {
            var checkboxes = $(document).find('input[type="checkbox"]');
            var result = [];
            checkboxes.each(function() {
                if ($(this).prop('checked')) {
                    var delID = $(this).attr('data-id');
                    result.push(delID);
                }
            });
            var partNumber = $('#partNumber').val();
            $('#loading').show();
            $.ajax({
                url: 'VendorDelMSDSAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    COD_FACT: COD_FACT,
                    result: result,
                    partNumber: partNumber
                },
                success: function(response) {
                    MSDStable.clear();
                    MSDStable.rows.add(response);
                    MSDStable.draw();
                    $('#loading').hide();
                    alert('刪除成功');
                },
                error: function(xhr, status, error) {
                    console.log(response);
                    $('#loading').hide();
                }
            });
        }
        $('#editWeight').click(function() {
            $("#editWeight").hide();
            $("#updateWeight").show();
            $("#partWeight").add();
            $("#partWeight").prop("readonly", false);
        });

        $('#updateWeight').click(function() {
            $("#editWeight").show();
            $("#updateWeight").hide();
            $("#partWeight").prop("readonly", true);
            var COD_FACT = window.COD_FACT;
            var partNumber = $('#partNumber').val();
            var partWeight = $('#partWeight').val();

            updateWeightAjax(COD_FACT, partNumber, partWeight)
        });

        function updateWeightAjax(COD_FACT, partNumber, partWeight) {
            $('#loading').show();
            $.ajax({
                url: 'VendorMSDSupdateWeightAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    COD_FACT: COD_FACT,
                    partNumber: partNumber,
                    partWeight: partWeight
                },
                success: function(response) {
                    MSDStable.clear();
                    MSDStable.rows.add(response);
                    MSDStable.draw();
                    $('#loading').hide();

                },
                error: function(xhr, status, error) {
                    console.log(response);
                    $('#loading').hide();
                }
            });
        }


    });

    function updateFileName(input, labelId) {
        var fileName = input.files[0].name;
        var label = document.getElementById(labelId);
        label.innerHTML = "<span style='color: red;'>" + fileName + " (尚未上傳)</span>";
    }

    function updateFileStatus(input, labelId) {
        var fileName = input.files[0].name;
        var label = document.getElementById(labelId);
        label.innerHTML = "<span style='color: red;'>" + fileName + " (尚未上傳)</span>";
    }


    function uploadFile(type) {
 

        if (1>2) {
            alert("請確認*必填資料，才能上傳檔案");
        } else {
            var fileInput, formId;
            if (type === 'certificate') {
                fileInput = document.querySelector('input[name="certificateInput"]');
                formId = 'certificate';
            } 
            var file = fileInput.files[0];           
            var formData = new FormData();
            formData.append('file', file);
            formData.append('COD_FACT', COD_FACT);
            formData.append('partNumber', $('#partNumber').val());
            
            $('#loading').show();
            $.ajax({
                url: "{{ asset('uploadMSDSFile') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            var progressPercent = Math.round((e.loaded / e.total) * 100);
                            $('#progressBarFill').css('width', progressPercent + '%');
                        }
                    });
                    return xhr;
                },
                success: function(response) {
                    console.log(response.message);
                    console.log(response.filename);
                    $('#' + type + '_Name').val(response.filename).hide();
                    var label = document.getElementById(type);
                    label.innerHTML = "<span style='color: blue;'>" + response.filename + "(" + response.filesize + ")...上傳成功</span>";
                    // console.log(response.filesize);
                    // console.log(type);

                    $('#loading').hide();

                },
                error: function(xhr, status, error) {
                    console.log(error);
                    console.log(status);
                    var label = document.getElementById(type);
                    label.innerHTML = "<span style='color: red;'>上傳失敗(檔名不能包含中文或特殊符號)</span>";
                    $('#loading').hide();
                }
            });
        }


    }
</script>

</html>