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
    textarea {
        width: 100%;
        /* 设置宽度为100% */
        height: 100px;
        /* 设置高度为200像素 */
        padding: 10px;
        /* 添加一些内边距 */
        border: 1px solid #ccc;
        /* 添加边框 */
        border-radius: 4px;
        /* 添加边框半径（圆角） */
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
                                <div class="form-row align-items-center">
                                    <div class="col-md-5 mb-3" id="searchBox">
                                        <label>單號</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                </div>
                                <div class="form-row align-items-center" style="margin:0px 0px 37px -6px">
                                    <div class="col-6" id="">
                                        <label>產品序號/零件序號/MAC</label>
                                        <input id="serchCon" type="text" class="form-control" placeholder="" required="" value="">
                                    </div>
                                    <div class="col-2" style="margin-left: 3rem;">
                                        <label for="">查詢</label>
                                        <div class="col" style="text-align: center;">
                                            <button type="button" id="submitSearch" class="btn btn-primary btn-block">送出</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row align-items-center">
                                    <div class="col-3" id="">
                                        <label>客戶編號</label>
                                        <input id="customerNumber" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-3" id="">
                                        <label>客戶名稱</label>
                                        <input id="customerName" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                

                                    <div class="col-3" id="">
                                      
                                            <label >送修日期</label>
                                            <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="noticeDate">
                                       
                                    </div>
                                </div>
                                <div class="form-row align-items-center">
                                    <div class="col-3" id="">
                                        <label>產品型號</label>
                                        <input id="productNum" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-3" id="">
                                        <label>產品名稱</label>
                                        <input id="productName" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-3" id="">
                                        <label>故障原因</label>
                                        <input id="" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-3" id="">
                                        <label>故障位置</label>
                                        <input id="" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                </div>
                                <div class="form-row align-items-center">
                                    <div class="col-3" id="">
                                        <label>維修判定</label>
                                        <input id="" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-3" id="">
                                        <label>維修人員</label>
                                        <input id="" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-3" id="">
                                        <label>完修日期</label>
                                        <input id="" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-3" id="">
                                        <label>序號</label>
                                        <input id="" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                </div>
                                <div class="form-row align-items-center" style="padding-top: 2rem;">
                                    <div class="col-3" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="checkbox1">
                                            <label class="custom-control-label" for="checkbox1">必須重新包裝</label>
                                        </div>
                                    </div>
                                    <div class="col-3" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="checkbox2">
                                            <label class="custom-control-label" for="checkbox2">電線</label>
                                        </div>
                                    </div>
                                    <div class="col-3" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="checkbox3">
                                            <label class="custom-control-label" for="checkbox3">鏡頭</label>
                                        </div>
                                    </div>
                                    <div class="col-3" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="checkbox4">
                                            <label class="custom-control-label" for="checkbox4">HDD</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row align-items-center" style="padding-top: 2rem;">
                                    <div class="col-3" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="checkbox5">
                                            <label class="custom-control-label" for="checkbox5">擦拭包裝</label>
                                        </div>
                                    </div>
                                    <div class="col-3" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="checkbox6">
                                            <label class="custom-control-label" for="checkbox6">整流器</label>
                                        </div>
                                    </div>
                                    <div class="col-6" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="checkbox7">
                                            <label class="custom-control-label" style="margin-right: 10px;" for="">其他</label>
                                            <input type="text" class="" placeholder="输入内容" id="input7">
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
                // 處理 AJAX 請求失敗後的回應
                console.log('no');
                $('#loading').hide();
            }
        });
    });

    function pullData(response) {
        var customerName = response[0]['NAM_CUSTS'];
        var customerNumber = response[0]['COD_CUST'];
        var productNum = response[0]['COD_ITEM'];
        var productName = response[0]['NAM_ITEM'];
        $('#customerName').val(customerName);
        $('#customerNumber').val(customerNumber);
        $('#productNum').val(productNum);
        $('#productName').val(productName);
    }
</script>

</html>