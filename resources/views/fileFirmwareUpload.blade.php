<!DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>

    @include('layouts/head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                                        <label class="col-form-label" style="padding-top: 0;">客戶類別<span style="color: red;">*必填</span> </label>
                                        <select id="searchClientType" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option value="">選擇</option>
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
                                        <label class="col-form-label" style="padding-top: 0;">產品類型<span style="color: red;">*必填</span></label>
                                        <select id="searChproductType" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option value="">選擇</option>
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
                                        <label for="validationCustom04">MOD<span style="color: red;">*必填</span></label>
                                        <input id="MOD" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04">利凌版本<span style="color: red;"></span></label>
                                        <input id="lilinVersion" type="text" class="form-control" placeholder="" required="">
                                    </div>

                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04">產品名稱<span style="color: red;"></span></label>
                                        <input id="productName" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04">客戶名稱<span style="color: red;"></span></label>
                                        <input id="customerName" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="validationCustom04">客戶型號<span style="color: red;"></span></label>
                                        <input id="customerType" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-2 mb-3">
                                        <label for="lensMCU" class="fa fa-camera">鏡頭MCU</label>
                                        <input id="lensMCU" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="lensISP" class="fa fa-camera">鏡頭ISP</label>
                                        <input id="lensISP" type="text" class="form-control" placeholder="" required="">
                                    </div>                                    
                                    <div class="col-md-2 mb-3">
                                        <label for="AI_Version" class="fa fa-wrench">AI 版本</label>
                                        <input id="AI_Version" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="inspectionForm" class="fa fa-calendar-minus-o">送驗需求單</label>
                                        <input id="inspectionForm" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                </div>                               
                            </div>

                            <div class="form-row" style="padding-left: 26px;">
                                <div class="col-5" style="padding:0, 1rem;">
                                    <span class="ti-upload">韌體(OS)</span>
                                    <input id="firmwareOS_Name" style="display: none;">
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
                                    <input id="firmwareAPP_Name" style="display: none;">
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
                            <div class="form-row" style="padding-left: 26px;">
                                <div class="col-5" style="padding:0, 1rem;">
                                    <span class="ti-upload">其他檔案</span>
                                    <input id="checkReport_Name" style="display: none;">
                                    <form id="otherUploadForm" enctype="multipart/form-data">
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="otherFileInput" id="otherFileInput" accept=".zip,.rar" onchange="updateFileName(this,'otherFiles')">
                                                <label class="custom-file-label" id="otherFiles">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button class="input-group-text" type="button" onclick="uploadFile('otherFiles')">Upload</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-5" style="padding:0, 1rem;">
                                    <span class="ti-clipboard">驗證報告</span>
                                    <input id="otherFiles_Name" style="display: none;">
                                    <form id="reportUploadForm" enctype="multipart/form-data">
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="reportFileInput" id="reportFileInput" accept=".pdf" onchange="updateFileName(this,'checkReport')">
                                                <label class="custom-file-label" id="checkReport">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button class="input-group-text" type="button" onclick="uploadFile('checkReport')">Upload</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="0" style="margin: 2% 25%;width: 50%;text-align: center;">
                                <button type="button" id="submit" class="btn btn-primary btn-block">
                                    <li class="fa fa-cloud-upload"></li> 儲存
                                </button>
                                <button type="button" id="submitOK" class="btn btn-flat btn-outline-success">
                                    <li class="fa fa-cloud-upload"></li> 儲存成功
                                </button>
                            </div>
                            <div class="0" style="margin: 2% 25%;width: 50%;">

                            </div>
                            <div id="progressBar">
                                <div id="progressBarFill"></div>
                            </div>

                            <div id="loading" style="display: none;">上傳中...請勿重整頁面</div>
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
    $(document).ready(function() {
        $('#submitOK').hide();
    });
    $('#submit').click(function() {
        var searchClientType = $('#searchClientType').val();
        var searChproductType = $('#searChproductType').val();
        var lilinVersion = $('#lilinVersion').val();
        var MOD = $('#MOD').val();
        var productName = $('#productName').val();
        var customerName = $('#customerName').val();
        var customerType = $('#customerType').val();
        var lensMCU = $('#lensMCU').val();
        var lensISP = $('#lensISP').val();
        var AI_Version = $('#AI_Version').val();
        var firmwareOS_Name = $('#firmwareOS_Name').val();
        var firmwareAPP_Name = $('#firmwareAPP_Name').val();
        var checkReport_Name = $('#checkReport_Name').val();
        var otherFiles_Name = $('#otherFiles_Name').val();


        var labels = $('#firmwareOS, #firmwareAPP, #otherFiles, #checkReport');
        var containsNotUploaded = false;
        labels.each(function() {
            var label = $(this);
            var text = label.text();
            if (text.includes("尚未上傳")) {
                containsNotUploaded = true;
                console.log(label.attr('id') + " 包含 '尚未上傳'");
                return false;
            }
        });

        if (containsNotUploaded) {            
            alert("有文件尚未上傳");
        } else if (!searchClientType || !searChproductType || !MOD) {
            alert("請確認*必填資料");
        } else {

            $.ajax({
                url: 'fileFirmwareUploadAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    searchClientType: searchClientType,
                    searChproductType: searChproductType,
                    lilinVersion: lilinVersion,
                    MOD: MOD,
                    productName: productName,
                    customerName: customerName,
                    customerType: customerType,
                    lensMCU: lensMCU,
                    lensISP: lensISP,                
                    AI_Version: AI_Version,                  
                    firmwareOS_Name: firmwareOS_Name,
                    firmwareAPP_Name: firmwareAPP_Name,
                    checkReport_Name: checkReport_Name,
                    otherFiles_Name: otherFiles_Name
                },
                success: function(response) {
                    $('#searchClientType').prop('disabled', true);
                    $('#searChproductType').prop('disabled', true);
                    $('#lilinVersion').prop('disabled', true);
                    $('#MOD').prop('disabled', true);
                    $('#productName').prop('disabled', true);
                    $('#customerName').prop('disabled', true);
                    $('#customerType').prop('disabled', true);
                    $('#lensMCU').prop('disabled', true);
                    $('#lensISP').prop('disabled', true);                   
                    $('#AI_Version').prop('disabled', true);                    
                    $('#submit').hide();
                    $('#submitOK').show();
                    $('.input-group-text').addClass('d-none');
                },
                error: function(xhr, status, error) {
                    // 處理 AJAX 請求失敗後的回應
                    console.log('no');

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
        var searchClientType = $('#searchClientType').val();
        var searChproductType = $('#searChproductType').val();
        var lilinVersion = $('#lilinVersion').val();
        var MOD = $('#MOD').val();
        var productName = $('#productName').val();
        var customerName = $('#customerName').val();
        var customerType = $('#customerType').val();

        if (!searchClientType || !searChproductType || !MOD) {
            alert("請確認*必填資料，才能上傳檔案");
        } else {
            var fileInput, formId;
            if (type === 'firmwareOS') {
                fileInput = document.getElementById('firmwareOSInput');
                formId = 'firmwareOSForm';
            } else if (type === 'firmwareAPP') {
                fileInput = document.getElementById('firmwareAPPInput');
                formId = 'firmwareAPPForm';
            } else if (type === 'checkReport') {
                fileInput = document.getElementById('reportFileInput');
                formId = 'reportUploadForm';
            } else if (type === 'otherFiles') {
                fileInput = document.getElementById('otherFileInput');
                formId = 'otherUploadForm';
            }
            var file = fileInput.files[0];
            var formData = new FormData();
            formData.append('file', file);
            formData.append('searchClientType', searchClientType);
            formData.append('lilinVersion', lilinVersion);
            formData.append('MOD', MOD);
            formData.append('productName', productName);
            formData.append('customerType', customerType);
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