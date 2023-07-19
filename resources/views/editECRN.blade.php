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
                    @foreach($editECRN as $data)
                    <div class="col-12" style="padding: 8px;">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="header-title" style="color: red;">ECR/ECN(RD修改)</h4>
                                <div id="message" style="text-align: center;"></div>
                                <input id="listid" style="display: none;" value="{{ $data->id }}">
                                <div class="form-row">
                                    <div class="col-md-2 mb-3">
                                        <label>ECR編號<span style="color: red;"></span></label>
                                        <input id="ECRNum" type="text" class="form-control" value="{{ $data->ECRNum }}">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <div class="form-group">
                                            <label style="padding-top: 0;" class="col-form-label">申請日期</label>
                                            <input class="form-control" type="date" value="{{ $data->applyDate }}" id="applyDate">
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label>ECN編號
                                        </label>
                                        <input id="ECNNum" type="text" class="form-control" value="{{ $data->ECNNum }}">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <div class="form-group">
                                            <label style="padding-top: 0;" class="col-form-label">通知日期</label>
                                            <input class="form-control" type="date" value="{{ $data->noticeDate }}" id="noticeDate">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>機種<span style="color: red;"></span></label>
                                        <input id="model" type="text" class="form-control" value="{{ $data->model }}">
                                    </div>
                                </div>
                                <div class="form-row" id="">
                                    <div class="col-md-3 mb-3">
                                        <label>事由<span style="color: red;"></span></label>
                                        <input id="reason" type="text" class="form-control" value="{{ $data->reason }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="">備註</label>
                                        <input id="remark" type="text" class="form-control" value="{{ $data->remark }}">
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label>擔當<span style="color: red;"></span></label>
                                        <input id="charge" type="text" class="form-control" value="{{ $data->charge }}">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label>送驗單號<span style="color: red;"></span></label>
                                        <input id="deliveryOrder" type="text" class="form-control" value="{{ $data->deliveryOrder }}">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="" class="fa fa-wrench">核准</label>
                                        <div class="form-check" style="padding-top: 0.5rem;padding-left: 2.5rem;">
                                            <input type="checkbox" class="form-check-input" id="approved" value="{{ $data->approved }}">
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
                                <div class="0" style="margin: 2% 25%;width: 50%;text-align: center;">
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <button type="submit" id="delBtn" class="btn btn-danger btn-block" data-toggle="modal" data-target="#myModal">
                                                <li class="fa fa-cloud-upload"></li> 刪除
                                            </button>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <button type="button" id="edit" class="btn btn-info btn-block">
                                                <li class="fa fa-cloud-upload"></li> 修改
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <button type="button" id="cancel" class="btn btn-secondary  btn-block">
                                                <li class="fa fa-cloud-upload"></li> 取消修改
                                            </button>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <button type="button" id="submit" class="btn btn-primary btn-block">
                                                <li class="fa fa-cloud-upload"></li> 儲存
                                            </button>
                                        </div>
                                    </div>

                                    <button type="button" id="submitOK" class="btn btn-flat btn-outline-success">
                                        <li class="fa fa-cloud-upload"></li> 儲存成功，關閉此頁面
                                    </button>
                                    <button type="button" id="delOK" class="btn btn-flat btn-outline-success">
                                        <li class="fa fa-cloud-upload"></li> 刪除成功，關閉此頁面
                                    </button>
                                </div>
                            </div>

                            <div id="progressBar">
                                <div id="progressBarFill"></div>
                            </div>
                            <div id="loading" style="display: none;">上傳中...請勿重整頁面</div>
                        </div>

                    </div>
                    @endforeach
                </div>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
            </div>
            <div>
                <div class="row" style="margin: 0;">
                    <div class="col-12" style="padding: 8px;">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title" style="color: red;">ECR/ECN新增(生管修改)</h4>
                                <div id="messagePM" style="text-align: center;"></div>
                                <div class="form-row">
                                    <div class="col-md-2 mb-3">
                                        <div class="form-group">
                                            <label for="example-date-input" style="padding-top: 0;" class="col-form-label">生管修改日期</label>
                                            <input class="form-control" type="text" value="{{ $data->modificationDate }}" id="modificationDate">
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label>製造單號<span style="color: red;"></span></label>
                                        <input id="orderNumber" type="text" class="form-control" value="{{ $data->orderNumber }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="fa fa-calendar-minus-o">出廠序號</label>
                                        <input id="serialNumber" type="text" class="form-control" value="{{ $data->serialNumber }}">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="fa fa-calendar-minus-o">規修單號</label>
                                        <input id="repairOrderNum" type="text" class="form-control" value="{{ $data->repairOrderNum }}">
                                    </div>
                                  
                                    <div class="col-md-2 mb-3">
                                        <label class="fa fa-wrench">結案</label>
                                        <div class="form-check" style="padding-top: 0.5rem;padding-left: 2.5rem;">
                                            <input type="checkbox" class="form-check-input" id="closeCase" value="{{ $data->closeCase }}">
                                            <label class="form-check-label">是否結案</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="0" style="margin: 2% 25%;width: 50%;text-align: center;">
                                <div class="col-md-12">
                                    <button type="button" id="editPM" class="btn btn-info btn-block">
                                        <li class="fa fa-cloud-upload"></li> 修改
                                    </button>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <button type="button" id="cancelPM" class="btn btn-secondary btn-block">
                                            <li class="fa fa-cloud-upload"></li> 取消修改
                                        </button>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <button type="button" id="submitPM" class="btn btn-primary btn-block">
                                            <li class="fa fa-cloud-upload"></li> 儲存
                                        </button>
                                    </div>
                                </div>
                                <button type="button" id="submitOKPM" class="btn btn-flat btn-outline-success">
                                    <li class="fa fa-cloud-upload"></li> 儲存成功，關閉此頁面
                                </button>

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
    $(document).ready(function() {
        $('#submitOK').hide();
        $('#submit').hide();
        $('#cancel').hide();
        $('#delOK').hide();
        $('#cancelPM').hide();
        $('#submitPM').hide();
        $('#submitOKPM').hide();
        $('#delOKPM').hide();
        disabled()
        disabledPM()
        var approved = $("#approved");
        if (approved.val() === 'Y') {
            approved.prop("checked", true);
        } else {
            approved.prop("checked", false);
        }
        var closeCase = $("#closeCase");
        if (closeCase.val() === 'Y') {
            closeCase.prop("checked", true);
        } else {
            closeCase.prop("checked", false);
        }

    });
    $('#submit').click(function() {
        var listid = $('#listid').val();
        var ECRNum = $('#ECRNum').val();
        var applyDate = $('#applyDate').val();
        var ECNNum = $('#ECNNum').val();
        var noticeDate = $('#noticeDate').val();
        var model = $('#model').val();
        var reason = $('#reason').val();
        var charge = $('#charge').val();
        var remark = $('#remark').val();
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
                url: 'fileECRNEditAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    listid: listid,
                    ECRNum: ECRNum,
                    applyDate: applyDate,
                    ECNNum: ECNNum,
                    noticeDate: noticeDate,
                    model: model,
                    reason: reason,
                    approved: approved,
                    charge: charge,
                    remark: remark
                },
                success: function(response) {
                    $('input').prop('disabled', true);
                    $('#submit').hide();
                    $('#cancel').hide();
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
    $('#delete').click(function() {
        var listid = $('#listid').val();

        $.ajax({
            url: "{{ asset('delECRNAjax') }}",
            type: 'POST',
            dataType: 'json',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                listid: listid
            },
            success: function(response) {
                $('#delOK').show();
                disabled();
                $('#delBtn').hide();
                $('#edit').hide();
                console.log(response);
            },
            error: function(xhr, status, error) {
                // 處理 AJAX 請求失敗後的回應
                console.log('no');
            }
        });
    });

    $('#edit').click(function() {
        enable()
        var message = "請注意!現在是可修改狀態";
        var alertElement = $('<div class="alert alert-warning">' + message + '</div>');
        $('#message').append(alertElement);
    });

    $('#editPM').click(function() {
        enablePM()
        var message = "請注意!現在是可修改狀態";
        var alertElement = $('<div class="alert alert-warning">' + message + '</div>');
        $('#messagePM').append(alertElement);
    });
    $('#submitPM').click(function() {
        var listid = $('#listid').val();
        var modificationDate = $('#modificationDate').val();
        var orderNumber = $('#orderNumber').val();
        var serialNumber = $('#serialNumber').val();
        var deliveryOrder = $('#deliveryOrder').val();
        var repairOrderNum = $('#repairOrderNum').val();
     
        var closeCasecheck = document.getElementById('closeCase');
        if (closeCasecheck.checked) {
            var closeCase = 'Y'
        } else {
            var closeCase = 'N';
        }

        $.ajax({
            url: 'fileECRNEditPMAjax',
            type: 'GET',
            dataType: 'json',
            data: {
                listid: listid,
                modificationDate: modificationDate,
                orderNumber: orderNumber,
                serialNumber: serialNumber,
                closeCase: closeCase,
                deliveryOrder: deliveryOrder,
                repairOrderNum: repairOrderNum,
               
            },
            success: function(response) {
                $('input').prop('disabled', true);
                $('#submitPM').hide();
                $('#cancelPM').hide();
                $('#submitOKPM').show();
                $('.input-group-text').addClass('d-none');
            },
            error: function(xhr, status, error) {
                // 處理 AJAX 請求失敗後的回應
                console.log('no');
            }
        });
    });

    function disabled() {
        $('#ECRNum').prop('disabled', true);
        $('#applyDate').prop('disabled', true);
        $('#ECNNum').prop('disabled', true);
        $('#noticeDate').prop('disabled', true);
        $('#model').prop('disabled', true);
        $('#reason').prop('disabled', true);
        $('#remark').prop('disabled', true);
        $('#charge').prop('disabled', true);
        $('#approved').prop('disabled', true);
        $(".input-group-append").hide();
        $('#deliveryOrder').prop('disabled', true);
    }

    function enable() {
        $('#ECRNum').prop('disabled', false);
        $('#applyDate').prop('disabled', false);
        $('#ECNNum').prop('disabled', false);
        $('#noticeDate').prop('disabled', false);
        $('#model').prop('disabled', false);
        $('#reason').prop('disabled', false);
        $('#remark').prop('disabled', false);
        $('#charge').prop('disabled', false);
        $('#approved').prop('disabled', false);
        $('#cancel').show();
        $('#submit').show();
        $('#delBtn').hide();
        $('#edit').hide();
        $(".input-group-append").show();
        $('#deliveryOrder').prop('disabled', false);
    }

    function disabledPM() {
        $('#modificationDate').prop('disabled', true);
        $('#orderNumber').prop('disabled', true);
        $('#serialNumber').prop('disabled', true);
        $('#closeCase').prop('disabled', true);
        $('#repairOrderNum').prop('disabled', true);
      

    }

    function enablePM() {
        $('#modificationDate').prop('disabled', false);
        $('#orderNumber').prop('disabled', false);
        $('#serialNumber').prop('disabled', false);
        $('#closeCase').prop('disabled', false);   
        $('#repairOrderNum').prop('disabled', false); 
        $('#cancelPM').show();
        $('#submitPM').show();
        $('#editPM').hide();
    }

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

    function closePage() {
        window.close(); // 關閉當前窗口
    }

    // 關閉當前窗口
    document.getElementById('cancel').addEventListener('click', closePage);
    document.getElementById('submitOK').addEventListener('click', closePage);
    document.getElementById('delOK').addEventListener('click', closePage);
    document.getElementById('cancelPM').addEventListener('click', closePage);
    document.getElementById('submitOKPM').addEventListener('click', closePage);
</script>

</html>