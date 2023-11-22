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
    }

    .custom-dropdown ul {
        list-style: none;
        padding: 0;
        margin: 0;
        position: absolute;     
        width: 100%;
        display: none;
        background-color: #fff;      
        border: 1px solid #ccc;      
        z-index: 2;     
    }

    .custom-dropdown ul li {
        padding: 5px 10px;
    }

    .custom-dropdown.active ul {
        display: block;     
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
                        @foreach ($ramData as $ListData)


                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">產品維修單 <span id="numer">{{$ListData->NUM}}</span> </h4>
                                <div class="form-row">
                                    <div class=""><input type="text" id="idNum" value="{{$ListData->ID}}" style="display: none;"></h4>
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
                                        <input id="serchCon" type="text" class="form-control" placeholder="" required="" value="{{$ListData->serchCon}}">
                                    </div>
                                    <div class="col-2" style="margin-left: 3rem;">
                                        <label for="">查詢</label>
                                        <div class="col" style="text-align: center;">
                                            <button type="button" id="submitSearch" class="btn btn-primary btn-block">送出</button>
                                        </div>
                                    </div>

                                    <div class="col-2" style="margin-left: 3rem;">
                                        @if($ListData->svgImage)
                                        <img id="svgImage" src="{{$ListData->svgImage}}" alt="SVG Image">
                                        @else
                                        <img id="svgImage" src="data:image/svg+xml;base64,Base64EncodedSVGData" alt="SVG Image">
                                        @endif


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


                                <div class="form-row align-items-center" style="margin-top: 2rem;">
                                    <div class="col-2" id="">
                                        <label>客戶編號</label>
                                        <input id="customerNumber" type="text" class="form-control" placeholder="" value="{{$ListData->customerNumber}}">
                                    </div>
                                    <div class="col-3" id="">
                                        <label>客戶名稱</label>
                                        <input id="customerName" type="text" class="form-control" placeholder="" value="{{$ListData->customerName}}">
                                    </div>
                                    <div class="col-2" id="">
                                        <label>收件人</label>
                                        <input id="customerAttn" type="text" class="form-control" placeholder="" value="{{$ListData->customerAttn}}">
                                    </div>
                                    <div class="col-2" id="">
                                        <label>電話</label>
                                        <input id="customerTel" type="text" class="form-control" placeholder="" value="{{$ListData->customerTel}}">
                                    </div>
                                    <div class="col-3" id="">
                                        <label>地址</label>
                                        <input id="customerAdd" type="text" class="form-control" placeholder="" value="{{$ListData->customerAdd}}">
                                    </div>


                                </div>
                                <div class="form-row align-items-center" style="">
                                    <div class="col-2" id="">
                                        <label>產品型號</label>
                                        <input id="productNum" type="text" class="form-control" placeholder="" value="{{$ListData->productNum}}">
                                    </div>
                                    <div class="col-5" id="">
                                        <label>產品名稱</label>
                                        <input id="productName" type="text" class="form-control" placeholder="" value="{{$ListData->productName}}">
                                    </div>
                                    <div class="col-1" id="">
                                        <label>收貨人員編號</label>
                                        <input id="userID" type="text" class="form-control" placeholder="" value="{{$ListData->userID}}">
                                    </div>
                                    <div class="col-2" id="">
                                        <label>收貨人員</label>
                                        <input id="userName" type="text" class="form-control" placeholder="" value="{{$ListData->userName}}">
                                    </div>
                                    <div class="col-2">
                                        <label>送修日期</label>

                                        @if($ListData->noticeDate)
                                        <input class="form-control" type="date" value="{{$ListData->noticeDate}}" id="noticeDate">
                                        @else
                                        <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="noticeDate">
                                        @endif
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
                                            <input type="text" class="" placeholder="输入内容" id="lensText" value="{{$ListData->lensText}}">
                                        </div>
                                    </div>
                                    <div class="col-3" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="HDD">
                                            <label class="custom-control-label" for="HDD">HDD</label>
                                            <input type="text" class="" placeholder="输入内容" id="HDDText" value="{{$ListData->HDDText}}">
                                        </div>
                                    </div>

                                    <div class="col-6" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="other">
                                            <label class="custom-control-label" style="margin-right: 10px;" for="other">其他</label>
                                            <input type="text" class="" placeholder="输入内容" id="otherText" value="{{$ListData->otherText}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="0" style="margin: 4% 25%;width: 50%;text-align: center;margin-bottom: 5rem;">
                                    <button type="button" id="createRMA" class="btn btn-primary btn-block">
                                        <li class="fa fa-cloud-upload"> 收貨人員建檔</li>
                                    </button>
                                    <button type="button" id="updateRMA" class="btn btn-info btn-block">
                                        <li class="fa fa-cloud-upload"> 收貨人員修改</li>
                                    </button>
                                    <button type="button" id="saveUpdateRMA" class="btn btn-warning btn-block">
                                        <li class="fa fa-cloud-upload"> 收貨人員修改儲存</li>
                                    </button>
                                    <button type="button" id="saveUpdateRMASuccess" class="btn btn-Success btn-block">
                                        <li class="fa fa-cloud-upload"> 儲存成功</li>
                                    </button>
                                </div>
                                <div id="MaintenanceForm">
                                    <div class="form-row align-items-center" style="margin:2rem 0px 37px -6px">
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
                                            <input id="faultPart" type="text" class="form-control" placeholder="" value="{{$ListData->faultPart}}">
                                        </div>
                                        <div class="col-2">
                                            <label>故障位置</label>
                                            <input id="faultLocation" type="text" class="form-control" placeholder="" value="{{$ListData->faultLocation}}">
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
                                            <input id="SN" type="text" class="form-control" placeholder="" value="{{$ListData->faultLocation}}">
                                        </div>
                                        <div class="col-3" id="">
                                            <label>序號</label>
                                            <input id="newSN" type="text" class="form-control" placeholder="" value="{{$ListData->faultLocation}}">
                                        </div>
                                        <div class="col-2" id="">
                                            <label>QA</label>
                                            @if($ListData->QADate)
                                            <input class="form-control" type="date" value="{{$ListData->QADate}}" id="QADate">
                                            @else
                                            <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="QADate">
                                            @endif

                                        </div>
                                        <div class="col-2" id="">
                                            <label>完修</label>
                                            @if($ListData->completedDate)
                                            <input class="form-control" type="date" value="{{$ListData->completedDate}}" id="completedDate">
                                            @else
                                            <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="completedDate">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-row align-items-center">
                                        <div class="col-2" id="">
                                            <label>人員編號</label>
                                            <input id="maintenanceStaffID" type="text" class="form-control" placeholder="" value="{{$ListData->maintenanceStaffID}}">
                                        </div>
                                        <div class="col-2" id="">
                                            <label>人員姓名</label>
                                            <input id="maintenanceStaff" type="text" class="form-control" placeholder="" value="{{$ListData->maintenanceStaff}}">
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
                                            <input id="workingHours" type="text" class="form-control" placeholder="" value="{{$ListData->workingHours}}">
                                        </div>
                                    </div>
                                    <div class="form-row align-items-center" style="padding-top: 2rem;">
                                        <label>維修紀錄</label>
                                        <div class="col-12" id="">
                                            <textarea rows="4" cols="200" placeholder="在此输入..."></textarea>
                                        </div>
                                    </div>

                                    <div class="0" style="margin: 2% 25%;width: 50%;text-align: center;">
                                        <button type="button" id="maintenanceEdit" class="btn btn-info btn-block">
                                            <li class="fa fa-cloud-upload"></li> 維修人員新增 \ 修改
                                        </button>
                                    </div>
                                    <div class="0" style="margin: 2% 25%;width: 50%;text-align: center;">
                                        <button type="button" id="maintenanceUpdate" class="btn btn-warning btn-block">
                                            <li class="fa fa-cloud-upload"></li> 儲存
                                        </button>
                                    </div>
                                    <div class="0" style="margin: 2% 25%;width: 50%;text-align: center;">
                                        <button type="button" id="maintenanceUpdateSuccess" class="btn btn-Success btn-block">
                                            <li class="fa fa-cloud-upload"> 儲存成功</li>
                                        </button>
                                    </div>
                                   
                                </div>
                            </div>



                            @endforeach
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
        getRmaData()
        displayBtn()
        const pagetype = '{{$pagetype}}';
        if (pagetype == 'create') {
            $("#createRMA").show();
            $('#MaintenanceForm').hide();
        } else if (pagetype == 'update') {
            disabled(true);
            disabledMaintenance(true) 
            $("#updateRMA").show();
            $('#MaintenanceForm').show();
            $('#maintenanceEdit').show();

        }
        qrCode();
    });

    function qrCode(){
        var svgImage = document.getElementById('svgImage');
        var img = new Image();
        img.src = svgImage.src;
        img.onload = function() {
            svgImage.style.display = 'inline';
        };
        img.onerror = function() {
            svgImage.style.display = 'none';
        };
    }

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
                $('#loading').hide();
            },
            error: function(xhr, status, error) {
                $('#loading').hide();
            }
        });
    });


    

    $('#maintenanceEdit').click(function() {
        disabledMaintenance(false);             
        $('#maintenanceUpdate').show();
        $('#maintenanceEdit').hide();
        const faultSituationCode = $('#faultSituationCode').val();
        const faultCauseCode = $('#faultCauseCode').val();
        const maintenanceStaff = $('#maintenanceStaff').val();
        const maintenanceStaffID = $('#maintenanceStaffID').val();
        const SN = $('#SN').val();
        if (faultSituationCode == '-') {
            $('#faultSituationCode').val('A001-無');
        }
        if (faultCauseCode == '-') {
            $('#faultCauseCode').val('B001-測試正常');
        }     
        if (SN == null || $.trim(SN) == '') {
            const SN = $('#serchCon').val()
            $('#SN').val(SN);
            
        }
      
        
        
    });
    

    

    $('#maintenanceUpdate').click(function() {
        const idNum = $('#idNum').val();
        const faultSituationCode = $('#faultSituationCode').val();
        
        const faultCauseCode = $('#faultCauseCode').val();
        console.log(faultSituationCode);

        console.log(faultCauseCode);
        const faultPart = $('#faultPart').val();
        const faultLocation = $('#faultLocation').val();
        const responsibility = $('#responsibility').val();
        const SN = $('#SN').val();
        const newSN = $('#newSN').val();
        const QADate = $('#QADate').val();
        const completedDate = $('#completedDate').val();    
        const maintenanceStaffID = $('#maintenanceStaffID').val();
        const maintenanceStaff = $('#maintenanceStaff').val();
        const toll = $('#toll').val();
        const workingHours = $('#workingHours').val();
        $('#loading').show();
        $.ajax({
            url: 'mesMaintenanceUpdateAjax',
            type: 'GET',
            dataType: 'json',
            data: {
                    idNum:idNum,
                    faultSituationCode:faultSituationCode,
                    faultCauseCode:faultCauseCode,
                    faultPart:faultPart,
                    faultLocation:faultLocation,
                    responsibility:responsibility,
                    SN:SN,
                    newSN:newSN,
                    QADate:QADate,
                    completedDate:completedDate,
                    maintenanceStaffID:maintenanceStaffID,
                    maintenanceStaff:maintenanceStaff,
                    toll:toll,
                    workingHours:workingHours
            },
            success: function(response) {
                $('#loading').hide();
                displayBtn();
                $('#maintenanceUpdateSuccess').show();
                $('#updateRMA').show();
                disabledMaintenance(true);
                console.log(response)     
            },
            error: function(xhr, status, error) {
                console.log('no');
                $('#loading').hide();
            }
        });

    });

    function getRmaData() {
        var num = '{{$ramData[0]->NUM}}';
        if (num != null && $.trim(num) !== '') {
            var numTitle = num.slice(0, 2); 
            var repairNum = num.slice(2);
        $('#numTitle').val(numTitle);
        $('#repairNum').val(repairNum);
        }else{
            $('#numTitle').val('FA');
        }
        var faultSituationText = '{{$ramData[0]->faultSituationCode. $ramData[0]->faultSituation }}';
        var faultCauseText = '{{$ramData[0]->faultCauseCode.$ramData[0]->faultCause }}';        
        $('#responsibility').val('{{$ramData[0]->responsibility }}');
        $('#toll').val('{{$ramData[0]->toll }}');
        $('#newPackaging').prop('checked',  {{$ramData[0]->newPackaging }});
        $('#wire').prop('checked',  {{$ramData[0]->wire }});
        $('#wipePackaging').prop('checked',  {{$ramData[0]->wipePackaging }});
        $('#rectifier').prop('checked',  {{$ramData[0]->rectifier }});
        $('#HDD').prop('checked',  {{$ramData[0]->HDD }});
        $('#lens').prop('checked',  {{$ramData[0]->lens }});
        $('#other').prop('checked',  {{$ramData[0]->other }});
        $('#faultSituationCode').val(faultSituationText).trigger('input');
        $('#faultCauseCode').val(faultCauseText).trigger('input');
       var customRadio = '{{$ramData[0]->repairType }}';
       switch (customRadio) {
        case '維修':
            $('#customRadio1').prop('checked', true);
            break;
            case '借':
            $('#customRadio2').prop('checked', true);
            break;
            case '退':
            $('#customRadio3').prop('checked', true);
            break;
            case '換':
            $('#customRadio4').prop('checked', true);
            break;
            case 'LZ':
            $('#customRadio5').prop('checked', true);
            break;
        default:
        $('#customRadio1').prop('checked', true);
            break;
       }
    };





    function pullData(response) {
        var customerName = response[0]['NAM_CUSTS'];
        var customerNumber = response[0]['COD_CUST'];
        var productNum = response[0]['COD_ITEM'];
        var productName = response[0]['NAM_ITEM'];
        var userID = response[0]['employee_id'];
        var userName = response[0]['userName'];
        var NAM_ATTN = response[0]['NAM_ATTN'];
        var NUM_TEL1 = response[0]['NUM_TEL1'];
        var ADD_REG = response[0]['ADD_REG'];
        $('#customerName').val(customerName);
        $('#customerNumber').val(customerNumber);
        $('#productNum').val(productNum);
        $('#productName').val(productName);
        $('#userID').val(userID);
        $('#userName').val(userName);
        $('#customerAttn').val(NAM_ATTN);
        $('#customerTel').val(NUM_TEL1);
        $('#customerAdd').val(ADD_REG);
    }
    $('#createRMA').click(function() {

        var numTitle = $('#numTitle').val();
        $.ajax({
            url: 'mesRmaEditReceiptCreateAjax',
            type: 'GET',
            dataType: 'json',
            data: {
                numTitle: numTitle
            },
            success: function(response) {
                $('#loading').hide();
                var svgImage = document.getElementById('svgImage');
                $('#repairNum').val(response.newNumber);
                svgImage.src = 'data:image/svg+xml;base64,' + response.qrCode;
                submitCreateForm();
                displayBtn();
                $("#updateRMA").show();
                disabled(true);
                qrCode();
            },
            error: function(xhr, status, error) {
                $('#loading').hide();
            }
        });
    });

    $('#updateRMA').click(function() {
        disabled(false);
        displayBtn();
        $("#saveUpdateRMA").show();
        disabledMaintenance(true);
    });
    $('#saveUpdateRMA').click(function() {
        const idNum = $('#idNum').val();
        if (idNum == null && $.trim(idNum) == '') {         
            return;
        }

        const numTitle = $('#numTitle').val();
        const repairNum = $('#repairNum').val();
        const selectedValue = $('input[name="customRadio1"]:checked').next('label').text();
        const serchCon = $('#serchCon').val();
        const svgImage = $("#svgImage").attr("src");
        const customerNumber = $('#customerNumber').val();
        const customerName = $('#customerName').val();
        const customerAttn = $('#customerAttn').val();
        const customerTel = $('#customerTel').val();
        const customerAdd = $('#customerAdd').val();
        const productNum = $('#productNum').val();
        const productName = $('#productName').val();
        const userID = $('#userID').val();
        const userName = $('#userName').val();
        const noticeDate = $('#noticeDate').val();
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
            idNum,
            numTitle,
            repairNum,
            selectedValue,
            serchCon,
            svgImage,
            customerNumber,
            customerName,
            customerAttn,
            customerTel,
            customerAdd,
            productNum,
            productName,
            userID,
            userName,
            noticeDate,
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
            url: 'mesRmaEditReceiptUpdateAjax',
            type: 'GET',
            dataType: 'json',
            data: formData,
            success: function(response) {
                $('#loading').hide();
                displayBtn();
                $("#saveUpdateRMASuccess").show();
                disabled(true);

            },
            error: function(xhr, status, error) {
                $('#loading').hide();
            }
        });
    });


    function submitCreateForm() {
        const numTitle = $('#numTitle').val();
        const repairNum = $('#repairNum').val();
        const selectedValue = $('input[name="customRadio1"]:checked').next('label').text();
        const serchCon = $('#serchCon').val();
        const svgImage = $("#svgImage").attr("src");
        const customerNumber = $('#customerNumber').val();
        const customerName = $('#customerName').val();
        const customerAttn = $('#customerAttn').val();
        const customerTel = $('#customerTel').val();
        const customerAdd = $('#customerAdd').val();
        const productNum = $('#productNum').val();
        const productName = $('#productName').val();
        const userID = $('#userID').val();
        const userName = $('#userName').val();
        const noticeDate = $('#noticeDate').val();
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
            serchCon,
            svgImage,
            customerNumber,
            customerName,
            customerAttn,
            customerTel,
            customerAdd,
            productNum,
            productName,
            userID,
            userName,
            noticeDate,
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
            url: 'mesRmaEditReceiptSaveAjax',
            type: 'GET',
            dataType: 'json',
            data: formData,
            success: function(response) {
                $('#loading').hide();
                $('#idNum').val(response);
                console.log(response);

            },
            error: function(xhr, status, error) {
                $('#loading').hide();
            }
        });
    }

    function displayBtn() {
        $("#createRMA").hide();
        $("#updateRMA").hide();
        $("#saveUpdateRMA").hide();
        $("#saveUpdateRMASuccess").hide();
        $('#maintenanceEdit').hide();
        $('#maintenanceUpdate').hide();
        $('#maintenanceUpdateSuccess').hide();

    }

    function disabled(type) {
        $('#numTitle').prop('disabled', type);
        $('#serchCon').prop('disabled', type);
        $('#customerNumber').prop('disabled', type);
        $('#customerName').prop('disabled', type);
        $('#customerAttn').prop('disabled', type);
        $('#customerTel').prop('disabled', type);
        $('#customerAdd').prop('disabled', type);
        $('#productNum').prop('disabled', type);
        $('#productName').prop('disabled', type);
        $('#userID').prop('disabled', type);
        $('#userName').prop('disabled', type);
        $('#noticeDate').prop('disabled', type);
        $('#newPackaging').prop('disabled', type);
        $('#wire').prop('disabled', type);
        $('#wipePackaging').prop('disabled', type);
        $('#rectifier').prop('disabled', type);
        $('#lens').prop('disabled', type);
        $('#HDD').prop('disabled', type);
        $('#other').prop('disabled', type);
        $('#lensText').prop('disabled', type);
        $('#HDDText').prop('disabled', type);
        $('#otherText').prop('disabled', type);
    }

    
    function disabledMaintenance(type) {
        $('#faultSituationCode').prop('disabled', type);
        $('#faultCauseCode').prop('disabled', type);
        $('#faultPart').prop('disabled', type);
        $('#faultLocation').prop('disabled', type);
        $('#responsibility').prop('disabled', type);
        $('#SN').prop('disabled', type);
        $('#newSN').prop('disabled', type);
        $('#QADate').prop('disabled', type);
        $('#completedDate').prop('disabled', type);
        $('#maintenanceStaffID').prop('disabled', type);
        $('#maintenanceStaff').prop('disabled', type);
        $('#toll').prop('disabled', type);
        $('#workingHours').prop('disabled', type);
      
    }
</script>

</html>