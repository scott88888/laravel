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
                                        <select id="depository" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option value="FA">FA</option>
                                            <option value="FE">FE</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3" id="searchBox">
                                        <label for="">單號</label>
                                        <input id="search" type="text" class="form-control" placeholder="" required="">
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
                                    <div class="col-1 custom-dropdown">
                                        <label for="faultSituationCode">故障情形(代碼)</label>
                                        <input id="faultSituationCode" type="text" class="form-control" placeholder="" required="">
                                        <ul class="list-group" id="suggestionList"></ul>
                                    </div>

                                    <div class="col-2">
                                        <label>故障情形</label>
                                        <input id="faultSituation" type="text" class="form-control" placeholder="" required="" disabled>
                                    </div>
                                    <div class="col-1 custom-dropdown">
                                        <label for="faultCauseCode">故障原因(代碼)</label>
                                        <input id="faultCauseCode" type="text" class="form-control" placeholder="" required="">
                                        <!-- 下拉建议框 -->
                                        <ul class="list-group" id="faultCauseCodeSuggestionList"></ul>
                                    </div>
                                    <div class="col-2">
                                        <label>故障原因</label>
                                        <input id="faultCause" type="text" class="form-control" placeholder="" required="" disabled>
                                    </div>
                                    <div class="col-2">
                                        <label>故障零件</label>
                                        <input id="faultLocation" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-2">
                                        <label>故障位置</label>
                                        <input id="faultLocation" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                </div>

                                <div class="form-row align-items-center">
                                    <div class="col-1" id="">
                                        <label>責任</label>
                                        <select id="" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option value="">本場</option>
                                            <option value="">場商</option>
                                            <option value="">客戶</option>
                                        </select>
                                    </div>
                                    <div class="col-3" id="">
                                        <label>整新前序號</label>
                                        <input id="" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-3" id="">
                                        <label>序號</label>
                                        <input id="" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-2" id="">
                                        <label>QA</label>
                                        <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="noticeDate">
                                    </div>
                                    <div class="col-2" id="">
                                        <label>完修</label>
                                        <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="noticeDate">
                                    </div>
                                </div>

                                <div class="form-row align-items-center">
                                    <div class="col-2" id="">
                                        <label>人員編號</label>
                                        <input id="" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-2" id="">
                                        <label>人員</label>
                                        <input id="" type="text" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-1" id="">
                                        <label>收費</label>

                                        <select id="" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option value="no">否</option>
                                            <option value="yes">是</option>

                                        </select>
                                    </div>
                                    <div class="col-3" id="">
                                        <label>工時</label>
                                        <input id="" type="text" class="form-control" placeholder="" required="">
                                    </div>

                                </div>
                                <div class="form-row align-items-center" style="padding-top: 2rem;">
                                    <div class="col-2" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="checkbox1">
                                            <label class="custom-control-label" for="checkbox1">必須整新包裝</label>
                                        </div>
                                    </div>
                                    <div class="col-2" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="checkbox2">
                                            <label class="custom-control-label" for="checkbox2">電線</label>
                                        </div>
                                    </div>


                                    <div class="col-2" id="">
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
                                </div>

                                <div class="form-row align-items-center" style="padding-top: 2rem;">
                                    <div class="col-2" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="checkbox3">
                                            <label class="custom-control-label" for="checkbox3">鏡頭</label>
                                            <input type="text" class="" placeholder="输入内容" id="input7">
                                        </div>
                                    </div>
                                    <div class="col-2" id="">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="checkbox4">
                                            <label class="custom-control-label" for="checkbox4">HDD</label>
                                            <input type="text" class="" placeholder="输入内容" id="input7">
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

        // 输入框和建议框的数据
        const faultcodesBackA = <?php echo json_encode($faultcodeA); ?>;
        const faultcodesBackB = <?php echo json_encode($faultcodeB); ?>;
        const inputElements = [{
                inputId: 'faultSituationCode',
                suggestionListId: 'suggestionList',
                data: faultcodesBackA
            },
            {
                inputId: 'faultCauseCode',
                suggestionListId: 'faultCauseCodeSuggestionList',
                data: faultcodesBackB
            }
        ];

        inputElements.forEach(element => {
            const input = $('#' + element.inputId);
            const suggestionList = $('#' + element.suggestionListId);
            const data = element.data;

            let selectedOptionIndex = -1;

            input.on('input', function() {
                const query = input.val().toLowerCase();
                const matches = data.filter(item => item.toLowerCase().startsWith(query));
                displaySuggestions(matches);
            });

            input.on('keydown', function(e) {
                const suggestionItems = suggestionList.find('li');
                if (e.key === 'ArrowDown') {
                    selectedOptionIndex = Math.min(selectedOptionIndex + 1, suggestionItems.length - 1);
                    updateSelectedOption();
                } else if (e.key === 'ArrowUp') {
                    selectedOptionIndex = Math.max(selectedOptionIndex - 1, -1);
                    updateSelectedOption();
                } else if (e.key === 'Enter') {
                    if (selectedOptionIndex >= 0) {
                        input.val(suggestionItems.eq(selectedOptionIndex).text());
                        suggestionList.css('display', 'none');
                    }
                }
            });

            function displaySuggestions(matches) {
                if (matches.length === 0) {
                    suggestionList.css('display', 'none');
                    return;
                }

                suggestionList.html('');
                matches.forEach(match => {
                    const listItem = $('<li class="list-group-item"></li>');
                    listItem.text(match);
                    listItem.on('click', () => {
                        input.val(match);
                        suggestionList.css('display', 'none');
                    });
                    suggestionList.append(listItem);
                });

                suggestionList.css('display', 'block');
                selectedOptionIndex = -1;
            }

            function updateSelectedOption() {
                const suggestionItems = suggestionList.find('li');
                suggestionItems.each((index, item) => {
                    if (index === selectedOptionIndex) {
                        $(item).addClass('active');
                    } else {
                        $(item).removeClass('active');
                    }
                });
            }
        });

        const codeAMap = <?php echo json_encode($codeAMap); ?>;
        const faultSituationCodeInput = $('#faultSituationCode');
        const faultSituationInput = $('#faultSituation');
        faultSituationCodeInput.on('change', function() {
            const selectedFaultCode = $(this).val();
            const matchingFault = codeAMap[selectedFaultCode]; 
            $('#faultSituation').val(matchingFault);
        });
        const codeBMap = <?php echo json_encode($codeBMap); ?>; 
        const faultCauseCodeInput = $('#faultCauseCode');
        const faultCauseInput = $('#faultCause');
        faultCauseCodeInput.on('change', function() {
            const selectedCauseCode = $(this).val();
            const matchingFault = codeBMap[selectedCauseCode]; 
            $('#faultCause').val(matchingFault);
           
        });
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
        var user = response[0]['employee_id'];
        $('#customerName').val(customerName);
        $('#customerNumber').val(customerNumber);
        $('#productNum').val(productNum);
        $('#productName').val(productName);
        $('#user').val(user);
    }
</script>

</html>