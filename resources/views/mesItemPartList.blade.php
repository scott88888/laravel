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
                                <div class="data-tables datatable-dark">
                                    <table id="ListData" class="display text-center" style="width:100%">
                                        <thead class="text-capitalize" style=" background: darkgrey;">
                                            <tr>
                                                <th>上傳/刪除</th>
                                                <th>產品照片</th>
                                                <th>產品型號</th>
                                                <th>產品敘述</th>
                                                <th>庫存</th>
                                                <th>倉位</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($MesItemPartList as $ListData)
                                            <tr>
                                                <td style="padding: 0;">
                                                    <span class="fa fa-arrow-up" data-toggle="modal" data-target="#editModal"  data-id="{{$ListData->COD_ITEM}}" style="font-size: larger;padding: 10px;cursor: pointer;color:blue;"></span>
                                                    <span class="fa fa-times" data-toggle="modal" data-target="#delModal" style="font-size: larger;padding: 10px;cursor: pointer;color:red;"></span>
                                                </td>
                                                <td><img style="max-width:60px;" src="https://www.anword.com.tw/images/Color-block/White.jpg"></td>
                                                <td>{{$ListData->COD_ITEM}}</td>
                                                <td>
                                                    {{$ListData->NAM_ITEM}}
                                                </td>
                                                <td>{{$ListData->QTY_STK}}</td>
                                                <td>
                                                    @switch($ListData->COD_LOC)
                                                    @case('GO-001')
                                                    <p style="color:blue">內銷成品倉</p>
                                                    @break
                                                    @case('WO-003')
                                                    <p style="color:green">外銷成品倉</p>
                                                    @break
                                                    @case('AO-111')
                                                    <p style="color:purple">共用料件倉</p>
                                                    @break
                                                    @case('LL-000')
                                                    <p style="color:red">內銷借品專用倉</p>
                                                    @break
                                                    @default
                                                    <p></p>
                                                    @endswitch
                                                </td>
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

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-danger" id="delete" data-dismiss="modal">確認刪除</button>
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
                                <form id="mesItemPartForm" enctype="multipart/form-data">
                                <p id="modal-id"></p>
                                <input type="text" id="idModel" style="display: none;">
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="mesItemPartInput" id="mesItemPartInput" accept=".jpg" onchange="updateFileName(this,'mesItemPart')">
                                            <label class="custom-file-label" id="mesItemPart">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="input-group-text" type="button" onclick="uploadFile('mesItemPart')">Upload</button>
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
    $(document).ready(function() {      
        $('.fa-arrow-up').on('click', function() {            
            var id = $(this).data('id');        
            $('#modal-id').text("model: "+id);
            $('#idModel').val(id) ;
        });
    });
    $(ListData).DataTable({
        ...tableConfig,
        columnDefs: [{
            "targets": "_all",
            "className": "dt-center"
        }],
        "order": [
            [0, "asc"]
        ]
    })


    function updateFileName(input, labelId) {
        var fileName = input.files[0].name;
        var label = document.getElementById(labelId);
        label.innerHTML = "<span style='color: red;'>" + fileName + " (尚未上傳)</span>";
    }

    function uploadFile(type) {
        var fileInput;
        fileInput = document.getElementById(type+'Input');
        
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
</script>

</html>