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
                                        <select id="searchClientType" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option>選擇</option>
                                            <option value="LILIN">LILIN</option>
                                            <option value="NoBrand">No Brand</option>
                                            <option value="OEM-Brand">OEM-Brand</option>
                                            <option value="OEM-LILIN">OEM-LILIN</option>
                                            <option value="OEM-NoBrand">OEM-No Brand</option>
                                            <option value="JVC">JVC</option>
                                            <option value="CoreBrand">CoreBrand</option>
                                            <option value="C4">C4</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="col-form-label" style="padding-top: 0;">產品類型 </label>
                                        <select id="searChproductType" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option>選擇</option>
                                            <option value="IPCAM">IPCAM</option>
                                            <option value="SpeedDome">SpeedDome</option>
                                            <option value="NVR">NVR</option>
                                            <option value="AHD">AHD</option>
                                            <option value="DHD">DHD</option>
                                            <option value="NAV">NAV</option>
                                            <option value="AI Engine">AI Engine</option>
                                            <option value="Other">外購品</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04">利凌版本</label>
                                        <input id="lilinVersion" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04">MOD</label>
                                        <input id="MOD" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04">產品名稱</label>
                                        <input id="productName" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04">客戶名稱</label>
                                        <input id="customerName" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04">客戶型號</label>
                                        <input id="customerType" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="lensMCU" class="fa fa-camera">鏡頭MCU</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="lensISP" class="fa fa-camera">鏡頭ISP</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="rescueVersion" class="fa fa-wrench">救援檔案版本</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="AI_Version" class="fa fa-wrench">AI 版本</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 mb-3" id="searchBox">
                                        <label for="inspectionForm" class="fa fa-calendar-minus-o">送驗需求單</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-5" style="padding:0, 1rem;">
                                    <span class="ti-upload">韌體(OS)</span>
                                    <form id="firmwareOSForm" enctype="multipart/form-data">
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="firmwareOSInput" id="firmwareOSInput" accept=".zip,.rar" onchange="updateFileName(this,'firmwareOS')">
                                                <label class="custom-file-label" id="firmwareOS">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button class="input-group-text" type="button" onclick="uploadFile('firmwareOS')">Upload</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-5" style="padding:0, 1rem;">
                                    <span class="ti-upload">韌體(應用程式)</span>
                                    <form id="firmwareAPPForm" enctype="multipart/form-data">
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="firmwareAPPInput" id="firmwareAPPInput" accept=".zip,.rar" onchange="updateFileName(this,'firmwareAPP')">
                                                <label class="custom-file-label" id="firmwareAPP">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button class="input-group-text" type="button" onclick="uploadFile('firmwareAPP')">Upload</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-5" style="padding:0, 1rem;">
                                    <span class="ti-upload">其他檔案</span>
                                    <form id="otherUploadForm" enctype="multipart/form-data">
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="otherFileInput" id="otherFileInput" accept=".zip,.rar" onchange="updateFileName(this,'otherFiles')">
                                                <label class="custom-file-label" id="otherFiles">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button class="input-group-text" type="button" onclick="uploadFile('other')">Upload</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-5" style="padding:0, 1rem;">
                                    <span class="ti-clipboard">驗證報告</span>
                                    <form id="reportUploadForm" enctype="multipart/form-data">
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="reportFileInput" id="reportFileInput" accept=".zip,.rar" onchange="updateFileName(this,'checkReport')">
                                                <label class="custom-file-label" id="checkReport">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button class="input-group-text" type="button" onclick="uploadFile('report')">Upload</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="progressBar">
                                <div id="progressBarFill"></div>
                            </div>

                            <div id="loading" style="display: none;">上傳中...</div>
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
    function updateFileName(input, labelId) {
        var fileName = input.files[0].name;
        var label = document.getElementById(labelId);
        label.innerHTML = "<span style='color: red;'>" + fileName + " (尚未上傳)</span>";
    }

    function uploadFile(type) {
        var fileInput, formId;
        if (type === 'firmwareOS') {
            fileInput = document.getElementById('firmwareOSInput');
            formId = 'firmwareOSForm';
        } else if (type === 'firmwareAPP') {
            fileInput = document.getElementById('firmwareAPPInput');
            formId = 'firmwareAPPForm';
        } else if (type === 'report') {
            fileInput = document.getElementById('reportFileInput');
            formId = 'reportUploadForm';
        } else if (type === 'other') {
            fileInput = document.getElementById('otherFileInput');
            formId = 'otherUploadForm';
        }
        var file = fileInput.files[0];
        var formData = new FormData();
        formData.append('file', file);
        $('#loading').show();
        $.ajax({
            url: "{{ asset('fileupload') }}",
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
                console.log('上傳失敗');
                $('#loading').hide();
            }
        });
    }
</script>

</html>