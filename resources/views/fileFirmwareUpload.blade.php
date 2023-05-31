<!DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>

    @include('layouts/head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/dropzone@5.9.2/dist/dropzone.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.2/dist/dropzone.js"></script>
</head>

<script>
    $(document).ready(function() {
        $('#ListData').DataTable();
    });
</script>
<style>
  #progressBar {
    width: 100%;
    height: 10px;
    background-color: #f0f0f0;
    border-radius: 5px;
  }

  #progressBarFill {
    height: 100%;
    background-color: #4CAF50;
    border-radius: 5px;
    width: 0;
  }
</style>

<body>
    <div id="preloader">
        <div class="loader"></div>
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
                                <h4 class="header-title">韌體上傳</h4>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label class="col-form-label" style="padding-top: 0;">客戶類別 </label>
                                        <select id="searchtype" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option>選擇</option>
                                            <option value="NUM_CUST">客戶代號</option>
                                            <option value="NAM_ITEMS">品名</option>
                                            <option value="NUM_DEL">出貨單號</option>
                                            <option value="NUM_PO">訂單編號</option>
                                            <option value="COD_ITEM">料號</option>
                                            <option value="DAT_DEL">出貨日期</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="col-form-label" style="padding-top: 0;">產品類型 </label>
                                        <select id="searchtype" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option>選擇</option>
                                            <option value="NUM_CUST">客戶代號</option>
                                            <option value="NAM_ITEMS">品名</option>
                                            <option value="NUM_DEL">出貨單號</option>
                                            <option value="NUM_PO">訂單編號</option>
                                            <option value="COD_ITEM">料號</option>
                                            <option value="DAT_DEL">出貨日期</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04">利凌版本</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04">MOD</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04">產品名稱</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04">客戶名稱</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04">客戶型號</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04" class="fa fa-camera">鏡頭MCU</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04" class="fa fa-camera">鏡頭ISP</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04" class="fa fa-wrench">救援檔案版本</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04" class="fa fa-wrench">AI 版本</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 mb-3" id="searchBox">
                                        <label for="validationCustom04" class="fa fa-calendar-minus-o">送驗需求單</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                </div>
                                <div class="col-2">

                                </div>

                                <div class="col-2">
                                    <label for="">查詢</label>
                                    <button type="button" id="submit" class="btn btn-primary btn-block">送出</button>
                                </div>
                            </div>
                        </div>
                        <form id="uploadForm" enctype="multipart/form-data">
                            <input type="file" name="file" id="fileInput">
                            <button type="button" onclick="uploadFile()">上传文件</button>
                        </form>

                        <div id="progressBar">
                            <div id="progressBarFill"></div>
                        </div>

                        <div id="loading" style="display: none;">加载中...</div>
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
    function uploadFile() {
        var fileInput = document.getElementById('fileInput');
        var file = fileInput.files[0];

        var formData = new FormData();
        formData.append('file', file);

        $('#loading').show();
        $.ajax({
            url: 'upload',
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
                console.log(response.path);
                $('#loading').hide();
            },
            error: function(xhr, status, error) {
                console.log(error);
                console.log(status);
                console.log('上传失败');
                $('#loading').hide();
            }
        });
    }
</script>

</html>