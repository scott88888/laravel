<!DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts/head')
</head>

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
            <div class="main5">
                <div class="row" style="margin:0;">
                    <!-- Dark table start -->
                    <div class="col-12 mt-1">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">BOM查詢</h4>
                                <div class="form-row">

                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="">產品型號查詢</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-2" style="margin-left: 3rem;">
                                        <label for="">查詢</label>
                                        <div class="col" style="text-align: center;">
                                            <button type="button" id="submit" class="btn btn-primary btn-block">送出</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="data-tables datatable-dark">
                                    <table id="ListData" class="display text-center" style="width:100%">
                                        <thead class="text-capitalize" style=" background: darkgrey;">
                                            <tr>
                                                <th>BOM</th>
                                                <th>照片</th>
                                                <th>產品型號</th>
                                                <th>產品性質</th>
                                                <th>產品名稱</th>
                                                <th>部別</th>
                                                <th>上架時間</th>
                                                <th>終止使用</th>
                                                <th>90天</th>
                                            </tr>
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
            <input type="hidden" id="modalValue">
            <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="max-width: 60%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">BOM</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="data-tables datatable-dark">
                                <table id="BOMData" class="display text-center" style="width:100%">
                                    <thead class="text-capitalize" style=" background: darkgrey;">
                                        <tr>
                                            <th>照片</th>
                                            <th>料件</th>
                                            <th>敘述</th>
                                            <th>庫存</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: 1px;"></td>
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
                            <button type="button" class="btn btn-danger" id="delete" data-dismiss="modal" onclick="delJpgAjax('mesItemPartList')">確認刪除</button>
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
    let model;

    $(document).ready(function() {
        let bom_icon = '<img src=' + '{{ asset("images/icon/bom_icon300.png")}} style="width: 1.5rem;"">';
        $('#loading').hide();
        table = $('#ListData').DataTable({
            ...tableConfig,
            columnDefs: [{
                    "targets": "_all",
                    "className": "dt-center"
                }, {
                    "data": "COD_ITEM",
                    "targets": 0,
                    "title": "BOM",
                    "render": function(data, type, row) {
                        if (data.length > 0) {
                            return '<a href="#" id="openModalButton" data-modal-value="' + data + '">' + bom_icon + '</a>';
                            return button[0].outerHTML;
                        } else {
                            return '';
                        }
                    }
                }, {
                    "data": "COD_ITEM",
                    "targets": 1,
                    "title": "產品照片",
                    "render": function(data, type, row) {
                        if (data.length > 0) {
                            var imageUrl = '{{ asset("/show-image/mesitempartlist/") }}' + '/' + data + '/' + data + '.jpg';
                            var imageUrls = '{{ asset("/show-image/mesitempartlist/") }}' + '/' + data + '/' + data + '-s.jpg';
                            return '<a href="' + imageUrl + '" target="_blank"><img style="max-width:100px;" src="' + imageUrls + '"></a>';
                        } else {
                            return '';
                        }
                    }
                }, {
                    "data": "COD_ITEM",
                    "targets": 2,
                    "title": "產品型號"
                },
                {
                    "data": "DSC_ITEM",
                    "targets": 3,
                    "title": "產品性質"
                },
                {
                    "data": "NAM_ITEM",
                    "targets": 4,
                    "title": "產品名稱"
                },
                {
                    "data": "TYP_ITEM",
                    "targets": 5,
                    "title": "部別"
                },
                {
                    "data": "DAT_FILE",
                    "targets": 6,
                    "title": "上架時間"
                },
                {
                    "data": "DAT_USET",
                    "targets": 7,
                    "title": "終止使用"
                },
                {
                    "data": "QTY_DEL",
                    "targets": 8,
                    "title": "90天",
                    "render": function(data, type, row) {

                        return data;

                    }
                }
            ]

        });
        BOMtable = $('#BOMData').DataTable({
            ...tableConfig,          
            "lengthChange": false,
          
            columnDefs: [{
                    "targets": "_all",
                    "className": "dt-center"
                },
                {
                    "data": "COD_ITEMS",
                    "targets": 0,
                    "title": "產品照片",
                    "render": function(data, type, row) {
                        if (data.length > 0) {
                            var imageUrl = '{{ asset("/show-image/mesitempartlist/") }}' + '/' + data + '/' + data + '.jpg';
                            var imageUrls = '{{ asset("/show-image/mesitempartlist/") }}' + '/' + data + '/' + data + '-s.jpg';
                            return '<a href="' + imageUrl + '" target="_blank"><img style="max-width:50px;" src="' + imageUrls + '"></a>';
                        } else {
                            return '';
                        }
                    }
                }, {
                    "data": "COD_ITEMS",
                    "targets": 1,
                    "title": "料號"
                },
                {
                    "data": "NAM_ITEM",
                    "targets": 2,
                    "title": "產品說明"
                },
                {
                    "data": "qty",
                    "targets": 3,
                    "title": "庫存",
                    "render": function(data, type, row) {

                        return data;

                    }
                }
            ]


        });
        $('#ListData').on('click', '#openModalButton', function() {
            var modalValue = $(this).data('modal-value');
            selectBOM(modalValue);
            console.log(modalValue);

        });
        $('#submit').click(function() {
            var search = $('#search').val();
            selectModel(search);
        });
    });

    function selectModel(search) {
        $('#loading').show();
        $.ajax({
            url: 'mesBOMItemAjax',
            type: 'GET',
            dataType: 'json',
            data: {
                search: search,
            },
            success: function(response) {
                table.clear().rows.add(response).draw();
                $('#loading').hide();
            },
            error: function(xhr, status, error) {
                console.log('no data');
                table.clear();
                $('#loading').hide();
            }
        });

    }

    function selectBOM(modalValue) {
        $('#loading').show();
        $.ajax({
            url: 'mesBOMSelectAjax',
            type: 'GET',
            dataType: 'json',
            data: {
                modalValue: modalValue,
            },
            success: function(response) {
                console.log(response);
                $('#loading').hide();
                var BOMtable = $('#BOMData').DataTable();
                BOMtable.clear().rows.add(response).draw();


                $('#delModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.log('no data');
                table.clear();
                $('#loading').hide();
            }
        });

    }
</script>

</html>