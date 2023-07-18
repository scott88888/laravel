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
                                <h4 class="header-title">ECR/N新增</h4>
                                <div class="form-row">
                                    <div class="col-md-2 mb-3">
                                        <label>ECR編號<span style="color: red;"></span></label>
                                        <input id="ECRNum" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <div class="form-group">
                                            <label style="padding-top: 0;" class="col-form-label">申請日期</label>
                                            <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="applyDate">
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label>ECN編號
                                        </label>
                                        <input id="ECNNum" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <div class="form-group">
                                            <label style="padding-top: 0;" class="col-form-label">通知日期</label>
                                            <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="noticeDate">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>機種<span style="color: red;"></span></label>
                                        <input id="model" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row" id="">
                                    <div class="col-md-3 mb-3">
                                        <label>事由<span style="color: red;"></span></label>
                                        <input id="reason" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="">備註</label>
                                        <input id="remark" type="text" class="form-control">
                                    </div>
                                  
                                    <div class="col-md-2 mb-3">
                                        <label>擔當<span style="color: red;"></span></label>
                                        <input id="charge" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label>送驗單號<span style="color: red;"></span></label>
                                        <input id="deliveryOrder" type="text" class="form-control" >
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="" class="fa fa-wrench">核准</label>
                                        <div class="form-check" style="padding-top: 0.5rem;padding-left: 2.5rem;">
                                            <input type="checkbox" class="form-check-input" id="approved">
                                            <label class="form-check-label">是否核准</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" style="padding-left: 26px;">
                                <div class="col-5" style="padding:0, 1rem;">
                                    <span class="ti-clipboard"> ECR</span>
                                    <input id="ECRpdf" style="display: none;">
                                    <form id="ECRpdfForm" enctype="multipart/form-data">
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="ECRpdfInput" id="ECRpdfInput" accept=".pdf" onchange="updateFileStatus(this,'ECRReport')">
                                                <label class="custom-file-label" id="ECRReport">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button class="input-group-text" type="button" onclick="uploadFile('ECRReport')">Upload</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-5" style="padding:0, 1rem;">
                                    <span class="ti-clipboard"> ECN</span>
                                    <input id="ECNpdf" style="display: none;">
                                    <form id="ECNpdfForm" enctype="multipart/form-data">
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="ECNpdfInput" id="ECNpdfInput" accept=".pdf" onchange="updateFileStatus(this,'ECNReport')">
                                                <label class="custom-file-label" id="ECNReport">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button class="input-group-text" type="button" onclick="uploadFile('ECNReport')">Upload</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="0" style="margin: 2% 25%;width: 50%;text-align: center;">
                                <button type="button" id="submit" class="btn btn-primary btn-block">
                                    <li class="fa fa-cloud-upload"></li> 儲存
                                </button>
                                <button type="button" id="submitOK" class="btn btn-flat btn-outline-success" onclick="location.reload()">
                                    <li class="fa fa-cloud-upload"></li> 儲存成功，新增下一筆
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
        $('#speedDome_input').hide();
    });
    $('#submit').click(function() {
        var ECRNum = $('#ECRNum').val();
        var applyDate = $('#applyDate').val();
        var ECNNum = $('#ECNNum').val();
        var noticeDate = $('#noticeDate').val();
        var model = $('#model').val();
        var reason = $('#reason').val();
        var charge = $('#charge').val();
        var remark = $('#remark').val();
        var deliveryOrder = $('#deliveryOrder').val();
        
        var approvedCheck = document.getElementById('approved');
        if (approvedCheck.checked) {
            var approved = 'Y'
        } else {
            var approved = 'N';
        }
        var labels = $('#ECRReport, #ECNReport');
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
        } else {
            $.ajax({
                url: 'fileECNCreateAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    ECRNum: ECRNum,
                    applyDate: applyDate,
                    ECNNum: ECNNum,
                    noticeDate: noticeDate,
                    model: model,
                    reason: reason,
                    approved: approved,
                    charge: charge,
                    deliveryOrder:deliveryOrder,
                    remark: remark
                },
                success: function(response) {
                    $('input').prop('disabled', true);
                    $('#submit').hide();
                    $('#submitOK').show();
                    $('.input-group-text').addClass('d-none');

                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // 處理 AJAX 請求失敗後的回應
                    console.log('no');

                }
            });
        }
    });

    function updateFileStatus(input, labelId) {
        var fileName = input.files[0].name;
        var label = document.getElementById(labelId);
        label.innerHTML = "<span style='color: red;'>" + fileName + " (尚未上傳)</span>";
    }

    function uploadFile(type) {
        if (1 != 1) {
            alert("請確認*必填資料，才能上傳檔案");
        } else {
            var fileInput, formId;
            if (type === 'ECRReport') {
                fileInput = document.getElementById('ECRpdfInput');
                formId = 'ECRpdfForm';
            } else if (type === 'ECNReport') {
                fileInput = document.getElementById('ECNpdfInput');
                formId = 'ECNpdfForm';
            }
            var file = fileInput.files[0];
            var formData = new FormData();
            formData.append('file', file);
            formData.append('formId', formId);

            $('#loading').show();
            $.ajax({
                url: "{{ asset('ECNuploadFile') }}",
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