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
    .custom-dropdown {
        position: relative;
        /* 相对定位，以便下拉框相对于其父元素进行定位 */
    }

    .custom-dropdown ul {
        list-style: none;
        padding: 0;
        margin: 0;
        position: absolute;
        /* 绝对定位，相对于父元素进行定位 */
        width: 100%;
        display: none;
        background-color: #fff;
        /* 底色 */
        border: 1px solid #ccc;
        /* 边框样式 */
        z-index: 2;
        /* 提高z-index以覆盖下方元素 */
    }

    .custom-dropdown ul li {
        padding: 5px 10px;
    }

    .custom-dropdown.active ul {
        display: block;
        /* 显示下拉框 */
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
            <div>
                <div class="row" style="margin: 0;">
                    <!-- Dark table start -->
                    <div class="col-12" style="padding: 8px;">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">產品維修單</h4>
                               
                                <div class="form-row">
                                    <div class="">
                                        <label class="col-form-label" style="padding-top: 0;">字碼</label>
                                        <select id="numTitle" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option value="FA">FA</option>
                                            <option value="FE">FE</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="">單號</label>
                                        <input id="repairNum" type="text" class="form-control" placeholder="" required="" disabled>
                                    </div>

                                    <div class="col-4" id="">
                                        <label>產品序號/零件序號/MAC</label>
                                        <input id="serchCon" type="text" class="form-control" placeholder="" required="" value="">
                                    </div>
                                    <div class="col-2" style="margin-left: 3rem;">
                                        <label for="">查詢</label>
                                        <div class="col" style="text-align: center;">
                                            <button type="button" id="submitSearch" class="btn btn-primary btn-block">送出</button>
                                        </div>
                                    </div>
                                    <div class="col-2" style="margin-left: 3rem;">
                                    {!! $qrcode !!}
                                        
                                    </div>
                                  
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" checked id="customRadio1" name="customRadio1" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio1">維修</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadio2" name="customRadio1" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio2">借</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadio3" name="customRadio1" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio3">退</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadio4" name="customRadio1" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio4">換</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadio5" name="customRadio1" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio5">LZ</label>
                                </div>


                                <div class="form-row align-items-center" style="margin:2rem 0px 37px -6px">
                                    <div class="col-1" id="">
                                        <label>客戶編號</label>
                                        <input id="customerNumber" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-3" id="">
                                        <label>客戶名稱</label>
                                        <input id="customerName" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-3" id="">
                                        <label>產品型號</label>
                                        <input id="productNum" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-5" id="">
                                        <label>產品名稱</label>
                                        <input id="productName" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                </div>
                                <div class="form-row align-items-center">
                                    <div class="col-2">
                                        <label>送修日期</label>
                                        <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="noticeDate">
                                    </div>
                                    <div class="col-3">
                                        <label for="faultSituationCode" class="form-label">故障情形(代碼)</label>
                                        <input type="text" id="faultSituationCode" list="faultSituationCodes" class="form-control">
                                        <datalist id="faultSituationCodes">
                                            @foreach ($codeA as $codeA)
                                            <option value="{{ $codeA->faultcode}}-{{ $codeA->fault}}">{{ $codeA->faultcode}}-{{ $codeA->fault}}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="col-3">
                                        <label for="faultCauseCode" class="form-label">故障原因(代碼)</label>
                                        <input type="text" id="faultCauseCode" list="faultCauseCodes" class="form-control">
                                        <datalist id="faultCauseCodes">
                                            @foreach ($codeB as $codeB)
                                            <option value="{{ $codeB->faultcode}}-{{ $codeB->fault}}">{{ $codeB->faultcode}}-{{ $codeB->fault}}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="col-2">
                                        <label>故障零件</label>
                                        <input id="faultPart" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-2">
                                        <label>故障位置</label>
                                        <input id="faultLocation" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                </div>
                                <div class="form-row align-items-center">
                                    <div class="col-1" id="">
                                        <label>責任</label>
                                        <select id="responsibility" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option value="本場">本場</option>
                                            <option value="場商">場商</option>
                                            <option value="客戶">客戶</option>
                                        </select>
                                    </div>
                                    <div class="col-3" id="">
                                        <label>整新前序號</label>
                                        <input id="SN" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-3" id="">
                                        <label>序號</label>
                                        <input id="newSN" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-2" id="">
                                        <label>QA</label>
                                        <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="QADate">
                                    </div>
                                    <div class="col-2" id="">
                                        <label>完修</label>
                                        <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="completedDate">
                                    </div>
                                </div>

                                <div class="form-row align-items-center">
                                    <div class="col-2" id="">
                                        <label>人員編號</label>
                                        <input id="employeeID" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-2" id="">
                                        <label>人員</label>
                                        <input id="employeeName" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-1" id="">
                                        <label>收費</label>

                                        <select id="toll" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option value="no">否</option>
                                            <option value="yes">是</option>

                                        </select>
                                    </div>
                                    <div class="col-3" id="">
                                        <label>工時</label>
                                        <input id="workingHours" type="text" class="form-control" placeholder="" required="">
                                    </div>

                                </div>
                                <div class="form-row align-items-center" style="padding-top: 2rem;">
                                    <div class="col-2" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="newPackaging">
                                            <label class="custom-control-label" for="newPackaging">必須整新包裝</label>
                                        </div>
                                    </div>
                                    <div class="col-2" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="wire">
                                            <label class="custom-control-label" for="wire">電線</label>
                                        </div>
                                    </div>


                                    <div class="col-2" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="wipePackaging">
                                            <label class="custom-control-label" for="wipePackaging">擦拭包裝</label>
                                        </div>
                                    </div>
                                    <div class="col-3" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="rectifier">
                                            <label class="custom-control-label" for="rectifier">整流器</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row align-items-center" style="padding-top: 2rem;">
                                    <div class="col-3" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="lens">
                                            <label class="custom-control-label" for="lens">鏡頭</label>
                                            <input type="text" class="" placeholder="输入内容" id="lensText">
                                        </div>
                                    </div>
                                    <div class="col-3" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="HDD">
                                            <label class="custom-control-label" for="HDD">HDD</label>
                                            <input type="text" class="" placeholder="输入内容" id="HDDText">
                                        </div>
                                    </div>

                                    <div class="col-6" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="other">
                                            <label class="custom-control-label" style="margin-right: 10px;" for="other">其他</label>
                                            <input type="text" class="" placeholder="输入内容" id="otherText">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row align-items-center" style="padding-top: 2rem;">
                                    <label>維修紀錄</label>
                                    <div class="col-12" id="">

                                        <textarea rows="4" cols="200" placeholder="在此输入..."></textarea>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="0" style="margin: 2% 25%;width: 50%;text-align: center;">
                            <button type="button" id="submit" class="btn btn-primary btn-block">
                                <li class="fa fa-cloud-upload"></li> 儲存
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div id="autocomplete">
            <input type="text" id="input" placeholder="Type something...">
            <div id="suggestions"></div>
        </div> -->
    </div>
    </div>
    @include('layouts/footer')
    </div>
    @include('layouts/settings')
</body>
@include('layouts/footerjs')

<script>
    $(document).ready(function() {
        $('#loading').hide();


    });

    $('#submitSearch').click(function() {
        var serchCon = $('#serchCon').val();

        $('#loading').show();
        $.ajax({
            url: 'mesRmaEditAjax',
            type: 'GET',
            dataType: 'json',
            data: {
                serchCon: serchCon
            },
            success: function(response) {



                pullData(response)

                console.log(response);
                $('#loading').hide();
            },
            error: function(xhr, status, error) {

                console.log('no');
                $('#loading').hide();
            }
        });
    });


    $('#submit').click(function() {
        rmaGetNum();
    });

    function rmaGetNum() {
        var numTitle = $('#numTitle').val();

        $('#loading').show();
        $.ajax({
            url: 'mesRmaGetNumAjax',
            type: 'GET',
            dataType: 'json',
            data: {
                numTitle: numTitle
            },
            success: function(response) {
                $('#repairNum').val(response);

                // 在这里执行提交表单的代码
                submitForm();
            },
            error: function(xhr, status, error) {
                console.log('no');
                $('#loading').hide();
            }
        });
    }

    function submitForm() {
        const numTitle = $('#numTitle').val();
        const repairNum = $('#repairNum').val();
        const selectedValue = $('input[name="customRadio1"]:checked').next('label').text();
        const customerNumber = $('#customerNumber').val();
        const customerName = $('#customerName').val();
        const productNum = $('#productNum').val();
        const productName = $('#productName').val();
        const noticeDate = $('#noticeDate').val();
        const faultSituationCodes = $('#faultSituationCodes').val();
        const faultCauseCodes = $('#faultCauseCodes').val();
        const faultPart = $('#faultPart').val();
        const faultLocation = $('#faultLocation').val();
        const responsibility = $('#responsibility').val();
        const SN = $('#SN').val();
        const newSN = $('#newSN').val();
        const QADate = $('#QADate').val();
        const completedDate = $('#completedDate').val();
        const employeeID = $('#employeeID').val();
        const employeeName = $('#employeeName').val();
        const toll = $('#toll').val();
        const workingHours = $('#workingHours').val();
        const newPackaging = $('#newPackaging').prop('checked');
        const wire = $('#wire').prop('checked');
        const wipePackaging = $('#wipePackaging').prop('checked');
        const rectifier = $('#rectifier').prop('checked');
        const lens = $('#lens').prop('checked');
        const HDD = $('#HDD').prop('checked');
        const other = $('#other').prop('checked');
        const lensText = $('#lensText').val();
        const HDDText = $('#HDDText').val();
        const otherText = $('#otherText').val();

        const formData = {
            numTitle,
            repairNum,
            selectedValue,
            customerNumber,
            customerName,
            productNum,
            productName,
            noticeDate,
            faultSituationCodes,
            faultCauseCodes,
            faultPart,
            faultLocation,
            responsibility,
            SN,
            newSN,
            QADate,
            completedDate,
            employeeID,
            employeeName,
            toll,
            workingHours,
            newPackaging,
            wire,
            wipePackaging,
            rectifier,
            lens,
            HDD,
            other,
            lensText,
            HDDText,
            otherText
        };

        $('#loading').show();

        $.ajax({
            url: 'mesRmaeEditSave',
            type: 'GET',
            dataType: 'json',
            data: formData,
            success: function(response) {
                $('#loading').hide();
                console.log(response);
            },
            error: function(xhr, status, error) {
                $('#loading').hide();
            }
        });
    }

    function pullData(response) {
        var customerName = response[0]['NAM_CUSTS'];
        var customerNumber = response[0]['COD_CUST'];
        var productNum = response[0]['COD_ITEM'];
        var productName = response[0]['NAM_ITEM'];
        var user = response[0]['employee_id'];
        $('#customerName').val(customerName);
        $('#customerNumber').val(customerNumber);
        $('#productNum').val(productNum);
        $('#productName').val(productName);
        $('#user').val(user);
    }
</script>

</html>