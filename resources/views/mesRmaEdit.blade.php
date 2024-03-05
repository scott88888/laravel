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


                                    <div class="col-1">
                                        <label>狀態</label>
                                        <select id="formStat" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option value="0" style="color: black;">已維修完結案</option>
                                            <option value="1" style="color: black;">不維修結案</option>
                                            <option value="2" style="color: red;">待客戶回復</option>
                                            <option value="3" style="color: red;">待外廠維修</option>
                                            <option value="4" style="color: black;">撤銷</option>
                                            <option value="5" style="color: red;" selected>廠內維修中</option>
                                        </select>
                                    </div>
                                    <div class="col-1" style="margin-left: 3rem;">
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
                                    <label class="custom-control-label" for="customRadio2">借品</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadio3" name="customRadio1" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio3">借品專用</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadio4" name="customRadio1" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio4">換</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadio5" name="customRadio1" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio5">退</label>
                                </div>


                                <div class="form-row align-items-center" style="margin-top: 2rem;">
                                    <div class="col-2" id="">
                                        <label>客戶編號</label>
                                        <input id="customerNumber" type="text" class="form-control" placeholder="" value="{{$ListData->customerNumber}}">
                                    </div>
                                    <div class="col-2" style="margin-left: 3rem;">
                                        <label for="">查詢</label>
                                        <div class="col" style="text-align: center;">
                                            <button type="button" id="customerSearch" class="btn btn-primary btn-block">送出</button>
                                        </div>
                                    </div>


                                </div>

                                <div class="form-row align-items-center" style="margin-top: 2rem;">
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
                                    <div class="col-5" id="">
                                        <label>地址</label>
                                        <input id="customerAdd" type="text" class="form-control" placeholder="" value="{{$ListData->customerAdd}}">
                                    </div>

                                </div>
                                <div class="form-row align-items-center" style="">
                                    <div class="col-2" id="">
                                        <label>產品型號</label>
                                        <input id="productNum" type="text" class="form-control" placeholder="" value="{{$ListData->productNum}}">
                                    </div>
                                    <div class="col-4" id="">
                                        <label>產品名稱</label>
                                        <input id="productName" type="text" class="form-control" placeholder="" value="{{$ListData->productName}}">
                                    </div>
                                    <div class="col-1" id="">
                                        <label>收貨人員編號</label>
                                        <input id="userID" type="text" class="form-control" placeholder="" value="{{$ListData->userID}}">
                                    </div>
                                    <div class="col-1" id="">
                                        <label>收貨人員</label>
                                        <input id="userName" type="text" class="form-control" placeholder="" value="{{$ListData->userName}}">
                                    </div>
                                    <div class="col-2">
                                        <label>送修日期</label>
                                        @if($ListData->noticeDate)
                                        @php
                                        $date = new DateTime($ListData->noticeDate);
                                        @endphp
                                        <input class="form-control" type="date" value="{{$date->format('Y-m-d')}}" id="noticeDate">
                                        @else
                                        <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="noticeDate">
                                        @endif
                                    </div>
                                    <div class="col-2" id="">
                                        <label>出場序號</label>
                                        <input id="SEQ_MITEM" type="text" class="form-control" placeholder="" value="{{$ListData->SN}}">
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
                                <div class="form-row align-items-center" style="padding-top: 2rem;">
                                    <label>備註:</label>
                                    <div class="col-12" id="">
                                        <textarea id='remark' rows="4" cols="200" placeholder="在此输入...">{{$ListData->remark}}</textarea>
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
                                        <div class="col-2">
                                            <label for="faultSituationCode" class="form-label">故障情形(代碼)</label>
                                            <input type="text" id="faultSituationCode" list="faultSituationCodes" class="form-control">
                                            <datalist id="faultSituationCodes">
                                                @foreach ($codeA as $codeA)
                                                <option value="{{ $codeA->faultcode}}-{{ $codeA->fault}}">{{ $codeA->faultcode}}-{{ $codeA->fault}}</option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                        <div class="col-2">
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
                                        <div class="col-1" style="">
                                            <label for="">查詢</label>
                                            <div class="col" style="text-align: center;">
                                                <a href="#" id="openModalButton"><button type="button" id="bombtn" class="btn btn-primary btn-block">BOM</button></a>
                                            </div>

                                        </div>
                                        <div class="col-2">
                                            <label>查詢</label>
                                            <a href="{{ asset('RMAAnalysis?model=')}}{{$ListData->productNum}}" target="_blank"><button type="button" id="" class="btn btn-primary btn-block">不良零件/不良原因</button></a>
                                        </div>
                                    </div>
                                    <div class="form-row align-items-center">
                                        <div class="col-1" id="">
                                            <label>責任</label>
                                            <select id="responsibility" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                                <option value="本場">本廠</option>
                                                <option value="場商">廠商</option>
                                                <option value="客戶">客戶</option>
                                            </select>
                                        </div>
                                        <div class="col-3" id="">
                                            <label>整新前序號</label>
                                            <input id="SN" type="text" class="form-control" placeholder="" value="{{$ListData->SN}}">
                                        </div>
                                        <div class="col-3" id="">
                                            <label>序號</label>
                                            <input id="newSN" type="text" class="form-control" placeholder="" value="{{$ListData->newSN}}">
                                        </div>
                                        <div class="col-2" id="">
                                            <label>RMA開始時間</label>
                                            @if($ListData->QADate)
                                            <input class="form-control" type="datetime-local" value="{{$ListData->QADate}}" id="QADate">
                                            @else
                                            <input class="form-control" type="datetime-local" value="<?php echo date('Y-m-d H:i:s'); ?>" id="QADate">
                                            @endif

                                        </div>
                                        <div class="col-2" id="">
                                            <label>RMA完修時間</label>
                                            @if($ListData->completedDate)
                                            <input class="form-control" type="datetime-local" value="{{$ListData->completedDate}}" id="completedDate">
                                            @else
                                            <input class="form-control" type="datetime-local" value="<?php echo date('Y-m-d H:i:s'); ?>" id="completedDate">
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
                                                <option value="yes" {{$ListData->toll == 'yes' ? 'selected' : ''}}>是</option>
                                                <option value="no" {{$ListData->toll == 'no' ? 'selected' : ''}}>否</option>
                                            </select>
                                        </div>
                                        <div class="col-3" id="">
                                            <label>工時</label>
                                            <input id="workingHours" type="text" class="form-control" placeholder="" value="{{$ListData->workingHours}}">
                                        </div>
                                        <div class="col-1">
                                            <label>狀態</label>
                                            <select id="formStat2" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                                <option value="0" style="color: black;">已維修完結案</option>
                                                <option value="1" style="color: black;">不維修結案</option>
                                                <option value="2" style="color: red;">待客戶回復</option>
                                                <option value="3" style="color: red;">待外廠維修</option>
                                                <option value="4" style="color: black;">撤銷</option>
                                                <option value="5" style="color: red;" selected>廠內維修中</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row align-items-center">
                                        <div class="col-12" style="padding-top: 2rem;"> <label>維修紀錄</label> </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="Innerbox" name="records" class="custom-control-input">
                                            <label class="custom-control-label" for="Innerbox">內盒</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="Wire" name="records" class="custom-control-input">
                                            <label class="custom-control-label" for="Wire">電線</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="OctopusCable" name="records" class="custom-control-input">
                                            <label class="custom-control-label" for="OctopusCable">八爪線</label>
                                        </div>

                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="WaterDamage" name="records" class="custom-control-input">
                                            <label class="custom-control-label" for="WaterDamage">滲水不修</label>
                                        </div>

                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="Accessories" name="records" class="custom-control-input">
                                            <label class="custom-control-label" for="Accessories">配件</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="Mouseom" name="records" class="custom-control-input">
                                            <label class="custom-control-label" for="Mouseom">滑鼠</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="FullSetom" name="records" class="custom-control-input">
                                            <label class="custom-control-label" for="FullSetom">全配</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="12V1A" name="records" class="custom-control-input">
                                            <label class="custom-control-label" for="12V1A">12V1A</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="12V3A" name="records" class="custom-control-input">
                                            <label class="custom-control-label" for="12V3A">12V3A</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="12V5A" name="records" class="custom-control-input">
                                            <label class="custom-control-label" for="12V5A">12V5A</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="HDDErr" name="records" class="custom-control-input">
                                            <label class="custom-control-label" for="HDDErr">HDD未固定，撞壞機板</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="Irreparable" name="records" class="custom-control-input">
                                            <label class="custom-control-label" for="Irreparable">無修復價值不修</label>
                                        </div>
                                        <div class="col-12" id="">
                                            <textarea id='records' rows="4" cols="200" placeholder="在此输入...">{{$ListData->records}}</textarea>
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
                                        <button type="button" id="maintenanceUpdateSuccess" class="btn btn-success btn-block">
                                            <li class="fa fa-cloud-upload"> 儲存成功</li>
                                        </button>
                                    </div>

                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document" style="max-width: 70%;">
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
                                                <th>料號說明</th>
                                                <th>在庫庫存</th>
                                                <th>在途量</th>
                                                <th>交期</th>
                                                <th>預計庫存</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="padding: 1px;"></td>
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
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">確認</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel">
                <div class="modal-dialog" role="document" style="max-width: 70%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="customerModalLabel">聯絡人</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">                            
                            <div class="data-tables datatable-dark" style="margin: 2rem;">
                                <label>目的料號(請選)</label>
                                <table id="customerModalTable" class="display text-center" style="width:100%">
                                    <thead class="text-capitalize" style=" background: darkgrey;">
                                        <tr>
                                            <th>選取</th>
                                            <th>編號</th>
                                            <th>廠商</th>
                                            <th>地址</th>
                                            <th>聯絡人</th>
                                            <th>電話</th>
                                            <th>傳真</th>
                                         
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: 1px;"></td>
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

        $('#loading').hide();
        BOMtable = $('#BOMData').DataTable({
            ...tableConfig,
            "info": false,
            "lengthChange": false,
            "paging": false,
            "scrollCollapse": true, // 啟用捲動條收縮
            columnDefs: [{
                    "targets": "_all",
                    "className": "dt-center"
                },
                {
                    "data": "COD_ITEMS",
                    "targets": 0,
                    "title": "料件照片",
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
                    "title": "料號",
                    "render": function(data, type, row) {
                        if (data.length > 0) {
                            var itemUrl = '{{ asset("/inventoryItemPartList?target=") }}' + data;

                            return '<a href="' + itemUrl + '" target="_blank">' + data + '</a>';
                        } else {
                            return '';
                        }
                    }
                },
                {
                    "data": "NAM_ITEM",
                    "targets": 2,
                    "title": "料號說明"
                },
                {
                    "data": "qty",
                    "targets": 3,
                    "title": "在庫庫存"
                },
                {
                    "data": "SUN_QTY",
                    "targets": 4,
                    "title": "在途料件"
                },
                {
                    "data": "DAT_REQ",
                    "targets": 5,
                    "title": "料件預計到廠日"
                },
                {
                    "data": "inventory",
                    "targets": 6,
                    "title": "預期庫存"
                }
            ]


        });
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
        selectColor()
        customerModalTable = $('#customerModalTable').DataTable({
            ...tableConfig,
            order: [
                [1, 'asc']

            ],
            columns: [{
                    "targets": 0,
                    "data": "check",
                    "title": "選取",
                    "type": "checkbox",
                    "render": function(data, type, row, meta) {
                        var encodedRow = btoa(unescape(encodeURIComponent(JSON.stringify(row))));
                return '<a href="#" class="select-link" data-row="' + encodedRow + '">選取</a>';
            
                    }
                },
                {
                    "data": "NUM_DPT",
                    "title": "編號"
                },
                {
                    "data": "NAM_DPT",
                    "title": "廠商"
                },
                {
                    "data": "ADD_DPT",
                    "title": "地址"
                },
                {
                    "data": "NAM_ATTN",
                    "title": "聯絡人"
                },
                {
                    "data": "NUM_TEL",
                    "title": "電話"
                },
                {
                    "data": "NUM_FAX",
                    "title": "傳真"
                }

            ]
        });

    });

    function qrCode() {
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

    function selectColor() {
        if ($('#formStat').val() == 0 || $('#formStat').val() == 1 || $('#formStat').val() == 4) {
            $('#formStat').css('color', 'black');
            $('#formStat2').css('color', 'black');
        } else {
            $('#formStat').css('color', 'red');
            $('#formStat2').css('color', 'red');
        }
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

    $('#customerModalTable').on('click', '.select-link', function () {
    var encodedRow = $(this).data('row');
    var decodedRow = JSON.parse(decodeURIComponent(escape(atob(encodedRow))));
        addData(decodedRow);
    });

   
    function addData(rowData) {
        $('#customerName').val(rowData.NAM_CUST);       
        $('#customerAttn').val(rowData.NAM_ATTN);
        $('#customerTel').val(rowData.NUM_TEL);
        $('#customerAdd').val(rowData.ADD_DPT);     
        $('#customerModal').modal('hide');   
    }


    $('#maintenanceEdit').click(function() {
        disabledMaintenance(false);
        $('#maintenanceUpdate').show();
        $('#maintenanceEdit').hide();
        const faultSituationCode = $('#faultSituationCode').val();
        if (faultSituationCode == '') {
            $('#faultSituationCode').val('A001-無');
        }
        const faultCauseCode = $('#faultCauseCode').val();
        if (faultCauseCode == '') {
            $('#faultCauseCode').val('B001-測試正常');
        }
        const responsibility = $("#responsibility");
        if (responsibility.find("option:selected").length === 0) {
            responsibility.find("option[value='客戶']").attr("selected", true);

        }

        const faultPart = $('#faultPart').val();
        if (faultPart == '') {
            $('#faultPart').val('N');
        }

        const maintenanceStaff = $('#maintenanceStaff').val();
        const maintenanceStaffID = $('#maintenanceStaffID').val();
        const SN = $('#SN').val();
        const newSN = $('#newSN').val();
        const toll = $('#toll').val();
        const workingHours = $('#newSN').val();

        if (SN == null || $.trim(SN) == '') {
            const SN = $('#serchCon').val()
            $('#SN').val(SN);
        }
        if (newSN == null || $.trim(newSN) == '') {
            const newSN = $('#serchCon').val()
            $('#newSN').val(newSN);

        }
        if (workingHours == null || $.trim(workingHours) == '') {
            const hours = diffhours()
            $('#workingHours').val(hours);
        }
        if (toll == null) {
            $('#toll').val('yes');
        }


    });

    function diffhours() {

        const time1 = $('#QADate').val();
        const time2 = $('#completedDate').val();


        const time1_ms = new Date(time1).getTime();
        const time2_ms = new Date(time2).getTime();
        // 計算兩個時間的差值
        const diff_ms = time2_ms - time1_ms;

        // 計算兩個時間相差多少個小時
        const hours = Math.floor(diff_ms / (1000 * 60 * 60));

        // 取到小數第一位
        return hours + (diff_ms % (1000 * 60 * 60)) / (1000 * 60) * 0.01;

    }


    $('#maintenanceUpdate').click(function() {
        const idNum = $('#idNum').val();
        const faultSituationCode = $('#faultSituationCode').val();
        const faultCauseCode = $('#faultCauseCode').val();
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
        const hours = diffhours()
        $('#workingHours').val(hours);

        const workingHours = $('#workingHours').val();
        const records = $('#records').val();
        const records2 = $('input[name="records"]:checked').next('label').text();
        const formStat = $('#formStat2').val();
        $('#loading').show();
        $.ajax({
            url: 'mesMaintenanceUpdateAjax',
            type: 'GET',
            dataType: 'json',
            data: {
                idNum: idNum,
                faultSituationCode: faultSituationCode,
                faultCauseCode: faultCauseCode,
                faultPart: faultPart,
                faultLocation: faultLocation,
                responsibility: responsibility,
                SN: SN,
                newSN: newSN,
                QADate: QADate,
                completedDate: completedDate,
                maintenanceStaffID: maintenanceStaffID,
                maintenanceStaff: maintenanceStaff,
                toll: toll,
                workingHours: workingHours,
                records: records,
                records2: records2,
                formStat: formStat

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
        } else {
            $('#numTitle').val('FA');
        }
        var formStat = '{{$ramData[0]->formStat}}';
        $('#formStat').val(formStat);
        $('#formStat2').val(formStat);
        var remark = '{{$ramData[0]->remark}}';

        var faultSituationText = '{{$ramData[0]->faultSituationCode. $ramData[0]->faultSituation }}';
        var faultCauseText = '{{$ramData[0]->faultCauseCode.$ramData[0]->faultCause }}';
        var recordsText = '{{$ramData[0]->records}}';
        $('#responsibility').val('{{$ramData[0]->responsibility }}');
        $('#toll').val('{{$ramData[0]->toll }}');
        $('#newPackaging').prop('checked', {{$ramData[0]->newPackaging }});
        $('#wire').prop('checked', {{$ramData[0]->wire }});
        $('#wipePackaging').prop('checked', {{$ramData[0]->wipePackaging }});
        $('#rectifier').prop('checked', {{$ramData[0]->rectifier }});
        $('#HDD').prop('checked', {{$ramData[0]->HDD }});
        $('#lens').prop('checked', {{$ramData[0]->lens }});
        $('#other').prop('checked', {{$ramData[0]->other }});
        $('#faultSituationCode').val(faultSituationText).trigger('input');
        $('#faultCauseCode').val(faultCauseText).trigger('input');
        $('#records').val(recordsText).trigger('textarea');
        var customRadio = '{{$ramData[0]->repairType }}';
        switch (customRadio) {
            case '維修':
                $('#customRadio1').prop('checked', true);
                break;
            case '借品':
                $('#customRadio2').prop('checked', true);
                break;
            case '借品專用':
                $('#customRadio3').prop('checked', true);
                break;
            case '換':
                $('#customRadio4').prop('checked', true);
                break;
            case '退':
                $('#customRadio5').prop('checked', true);
                break;
            default:
                $('#customRadio1').prop('checked', true);
                break;
        }
        var records2Radio = '{{$ramData[0]->records2 }}';
        console.log(records2Radio);
        switch (records2Radio) {
            case '內盒':
                $('#Innerbox').prop('checked', true);
                break;
            case '電線':
                $('#Wire').prop('checked', true);
                break;
            case '八爪線':
                $('#OctopusCable').prop('checked', true);
                break;
            case '滲水不修':
                $('#WaterDamage').prop('checked', true);
                break;
            case '配件':
                $('#Accessories').prop('checked', true);
                break;
            case '滑鼠':
                $('#Mouseom').prop('checked', true);
                break;
            case '全配':
                $('#FullSetom').prop('checked', true);
                break;
            case '12V1A':
                $('#12V1A').prop('checked', true);
                break;
            case '12V3A':
                $('#12V3A').prop('checked', true);
                break;
            case '12V5A':
                $('#12V5A').prop('checked', true);
                break;
            case 'HDD未固定，撞壞機板':
                $('#HDDErr').prop('checked', true);
                break;
            case '無修復價值不修':
                $('#Irreparable').prop('checked', true);
                break;

            default:
                $('#records2Radio1').prop('checked', true);
                break;
        }


    };

    $('#openModalButton').click(function() {


        const modalValue = $('#productNum').val();
        selectBOM(modalValue);
        console.log(modalValue);

    });

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

                $('#loading').hide();
                var BOMtable = $('#BOMData').DataTable();
                BOMtable.clear().rows.add(response).draw();
                console.log(response);
                $('#myModalLabel').text('「推估訂單BOM」-' + modalValue);
                $('#delModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.log('no data');
                table.clear();
                $('#loading').hide();
            }
        });

    }

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
        var SEQ_MITEM = response[0]['SEQ_MITEM'];
        $('#customerName').val(customerName);
        $('#customerNumber').val(customerNumber);
        $('#productNum').val(productNum);
        $('#productName').val(productName);
        $('#userID').val(userID);
        $('#userName').val(userName);
        $('#customerAttn').val(NAM_ATTN);
        $('#customerTel').val(NUM_TEL1);
        $('#customerAdd').val(ADD_REG);
        $('#SEQ_MITEM').val(SEQ_MITEM);
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

    $('#customerSearch').click(function() {

        var customerNumber = $('#customerNumber').val();
        $.ajax({
            url: 'mesCustomerSearchAjax',
            type: 'GET',
            dataType: 'json',
            data: {
                customerNumber: customerNumber
            },
            success: function(response) {
                $('#loading').hide();
                customerModalTable.clear();
                        customerModalTable.rows.add(response);
                        customerModalTable.draw();
                $('#customerModal').modal('show');
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
        const formStat = $('#formStat').val();
        selectColor()
        const remark = $('#remark').val();
        const formData = {
            idNum,
            numTitle,
            repairNum,
            selectedValue,
            serchCon,
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
            otherText,
            formStat,
            remark
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
        const formStat = $('#formStat').val();
        const remark = $('#remark').val();
        const SEQ_MITEM = $('#SEQ_MITEM').val();


        const formData = {
            numTitle,
            repairNum,
            selectedValue,
            serchCon,
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
            otherText,
            formStat,
            remark,
            SEQ_MITEM
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
        $('#formStat').prop('disabled', type);
        if (type == true) {
            $('#remark').css('background', '#e9ecef');
            $('#remark').prop('readonly', type);
        } else {
            $('#remark').css('background', '#ffffff');
            $('#remark').prop('readonly', type);
        }

        $('#SEQ_MITEM').prop('disabled', type);
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
        $('#workingHours').prop('disabled', true);
        $('#formStat2').prop('disabled', type);
        if (type == true) {
            $('#records').css('background', '#e9ecef');
            $('#records').prop('readonly', type);
        } else {
            $('#records').css('background', '#ffffff');
            $('#records').prop('readonly', type);
        }
    }



</script>

</html>