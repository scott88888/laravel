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
                                <h4 class="header-title">物料查詢</h4>
                                <div class="form-row">
                                <div class="col-md-2 mb-3">
                                        <label class="col-form-label" style="padding-top: 0;">倉位編號</label>
                                        <select id="depository" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">                                        
                                            <option value="">全倉位</option>
                                            @foreach ($MesItemPartList as $ListData)
                                            <option value="{{$ListData->COD_LOC}}">{{$ListData->COD_LOC}}</option>                                           
                                            @endforeach 
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="">料號查詢</label>
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
                                                <th>上傳</th>
                                                <th>照片</th>
                                                <th>料號</th>
                                                <th>料件敘述</th>
                                                <th>庫存</th>
                                                <th>倉位</th>
                                                <th>倉位編號</th>
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
                                           </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">刪除確認</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p id="modal-delid"></p>
                            <input type="text" id="delid" style="display: none;">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-danger" id="delete" data-dismiss="modal" onclick="delJpgAjax('mesItemPartList')">確認刪除</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">圖片上傳</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="padding:0, 1rem;">
                                <span class="ti-upload">圖片</span>
                                <input id="mesItemPart_Name" style="display: none;">
                                <form id="mesItemPartListForm" enctype="multipart/form-data">
                                    <p id="modal-id"></p>
                                    <input type="text" id="idModel" style="display: none;">
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="mesItemPartListInput" id="mesItemPartListInput" accept=".jpg" onchange="updateFileName(this,'mesItemPartList')">
                                            <label class="custom-file-label" id="mesItemPartList">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="input-group-text" type="button" onclick="uploadFile('mesItemPartList')">Upload</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="progressBar">
                            <div id="progressBarFill"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-info" id="delete" data-dismiss="modal">確認上傳</button>
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
        $('#loading').hide();
        table = $('#ListData').DataTable({
            ...tableConfig,
            columnDefs: [{
                    "targets": "_all",
                    "className": "dt-center"
                },
                {
                    "data": "COD_ITEM",
                    "targets": 0,
                    "title": "上傳",
                },
                {
                    "data": "first",
                    "targets": 1,
                    "title": "產品照片"
                },
                {
                    "data": "COD_ITEM",
                    "targets": 2,
                    "title": "料號"
                },
                {
                    "data": "NAM_ITEM",
                    "targets": 3,
                    "title": "料件敘述"
                },
                {
                    "data": "QTY_STK",
                    "targets": 4,
                    "title": "庫存"
                },
                {
                    "data": "COD_LOC",
                    "targets": 5,
                    "title": "倉位"
                },
                {
                    "data": "COD_LOC",
                    "targets": 6,
                    "title": "倉位編號"
                },
                {
                    targets: [0, 1, 5, 6], // 所在的 index（從 0 開始）
                    render: function(data, type, row, meta) {
                        switch (meta.col) {
                            case 0:
                                model = data;
                                return '<span class="fa fa-arrow-up" data-toggle="modal" data-target="#editModal" data-id="' + data + '" style="font-size: larger;padding: 10px;cursor: pointer;color:blue;"></span>'
                            case 1:
                                if (data == 1) {
                                    var imageUrl = '{{ asset("/show-image/mesitempartlist/") }}' + '/' + row.model + '/' + row.model + '.jpg';
                                    var imageUrls = '{{ asset("/show-image/mesitempartlist/") }}' + '/' + row.model + '/' + row.model + '-s.jpg';
                                    return '<a href="' + imageUrl + '" target="_blank"><img style="max-width:100px;" src="' + imageUrls + '" alt="圖片"></a>';
                                } else {
                                    return data;
                                }
                            case 5:
                                if (data == 'GO-001') {
                                    return ' <p style="color:blue">內銷成品倉</p>';
                                } else if (data == 'WO-003') {
                                    return ' <p style="color:green">外銷成品倉</p>';
                                } else if (data == 'AO-111') {
                                    return ' <p style="color:purple">共用料件倉</p>';
                                } else if (data == 'LL-000') {
                                    return ' <p style="color:red">內銷借品專用倉</p>';
                                } else if (data == 'GO-002') {
                                    return ' <p style="color:blue">良品倉-原料</p>';
                                } else if (data == 'PA-000') {
                                    return ' <p style="color:blue">維修總倉</p>';
                                } else if (data == '0804') {
                                    return ' <p style="color:blue">品管課(生產)</p>';
                                }else {
                                    return data;
                                }
                            case 6:
                                return data;
                            default:
                                return data;
                        }
                    }
                }

            ]
        });

        $('#ListData').on('click', '.fa-arrow-up', function() {
            var id = $(this).data('id');
            $('#modal-id').text("model: " + id);
            $('#idModel').val(id);

        });
        $('.fa-times').on('click', function() {
            var id = $(this).data('id');
            $('#modal-delid').text("model: " + id);
            $('#delid').val(id);
        });
        $('#submit').click(function() {
            var search = $('#search').val();
            var depository = $('#depository').val();
            
            selectModel(depository,search);
        });
    });

    function selectModel(depository,search) {
        $('#loading').show();
        $.ajax({
            url: 'mesItemPartListAjax',
            type: 'GET',
            dataType: 'json',
            data: {
                search: search,
                depository: depository
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

    function updateFileName(input, labelId) {
        var fileName = input.files[0].name;
        var label = document.getElementById(labelId);
        label.innerHTML = "<span style='color: red;'>" + fileName + " (尚未上傳)</span>";
    }

    function select(type) {
        var fileInput;
        fileInput = document.getElementById(type + 'Input');

        var file = fileInput.files[0];
        var formData = new FormData();
        formData.append('file', file);
        formData.append('type', type);
        formData.append('idModel', $('#idModel').val());
        console.log(formData);
        $('#loading').show();
        $.ajax({
            url: "{{ asset('uploadjpg') }}",
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

    function uploadFile(type) {
        var fileInput;
        fileInput = document.getElementById(type + 'Input');

        var file = fileInput.files[0];
        var formData = new FormData();
        formData.append('file', file);
        formData.append('type', type);
        formData.append('idModel', $('#idModel').val());
        console.log(formData);
        $('#loading').show();
        $.ajax({
            url: "{{ asset('uploadjpg') }}",
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

    function delJpgAjax(type) {
        var fileInput;
        fileInput = document.getElementById(type + 'Input');

        var file = fileInput.files[0];
        var formData = new FormData();
        formData.append('file', file);
        formData.append('type', type);
        formData.append('delid', $('#delid').val());

        $('#loading').show();
        $.ajax({
            url: "{{ asset('delJpgAjax') }}",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response.message);
                console.log(response.filename);
                $('#loading').hide();

            },
            error: function(xhr, status, error) {
                console.log(error);
                console.log(status);
                $('#loading').hide();
            }
        });



    }
</script>

</html>