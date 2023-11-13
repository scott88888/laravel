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
                <div class="main5">
                    <div class="row" style=" margin-left:0;margin-right:0;">
                        <!-- Dark table start -->
                        <div class="col-12 mt-1">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">使用者權限設定</h4>
                                    <div>                                    
                                        <div class="mb-3"></div>
                                        <div class="form-row">
                                            <div class="col-md-2 mb-3" id="searchBox">
                                                <label for="">員工編號</label>
                                                <input id="searchID" type="text" class="form-control" placeholder="" required="" value="{{$employee_id}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="checkPermissionForm" style="display: block;">
                                        <div class="form-row">
                                            <div class="custom-checkbox custom-control-inline">
                                                <b class="text-muted mb-3 mt-4 d-block">
                                                    儀錶板
                                                </b>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox1">
                                                <label class="custom-control-label" for="checkbox1">排行榜</label>
                                            </div>
                                        </div>


                                        <div class="form-row">
                                            <div class="custom-checkbox custom-control-inline">
                                                <b class="text-muted mb-3 mt-4 d-block">
                                                    銷貨管理 <input type="checkbox" id="selectAll6"> 全選
                                                </b>
                                            </div>
                                        </div>
                                        <div class="form-row" id="salesManagementcheck">
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox6">
                                                <label class="custom-control-label" for="checkbox6">訂單生產狀態查詢</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox17">
                                                <label class="custom-control-label" for="checkbox17">出貨查詢</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox9">
                                                <label class="custom-control-label" for="checkbox9">借品未歸還一覽表</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox29">
                                                <label class="custom-control-label" for="checkbox29">運送管理</label>
                                            </div>
                                        </div>


                                        <div class="form-row">
                                            <div class="custom-checkbox custom-control-inline">
                                                <b class="text-muted mb-3 mt-4 d-block">
                                                    文件查詢/下載 <input type="checkbox" id="selectAll"> 全選
                                                </b>
                                            </div>
                                        </div>

                                        <div class="form-row" id="queryAndDownload">
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox2">
                                                <label class="custom-control-label" for="checkbox2">韌體下載查詢</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox3">
                                                <label class="custom-control-label" for="checkbox3">產品型號查詢</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox4">
                                                <label class="custom-control-label" for="checkbox4">客製化申請單查詢</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox5">
                                                <label class="custom-control-label" for="checkbox5">客戶代碼查詢</label>
                                            </div>

                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox7">
                                                <label class="custom-control-label" for="checkbox7">生產履歷查詢</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox8">
                                                <label class="custom-control-label" for="checkbox8">歷史產品生產數量</label>
                                            </div>

                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox10">
                                                <label class="custom-control-label" for="checkbox10">生產流程卡查詢</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox11">
                                                <label class="custom-control-label" for="checkbox11">未回報MES工單查詢</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox12">
                                                <label class="custom-control-label" for="checkbox12">生產維修紀錄查詢</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox13">
                                                <label class="custom-control-label" for="checkbox13">產品維修不良率分析</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox14">
                                                <label class="custom-control-label" for="checkbox14">產線零件維修不良排行</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox15">
                                                <label class="custom-control-label" for="checkbox15">入料逾期明細表</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox16">
                                                <label class="custom-control-label" for="checkbox16">ECR/ECN查詢</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox31">
                                                <label class="custom-control-label" for="checkbox31">BOM查詢</label>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="custom-checkbox custom-control-inline">
                                                <b class="text-muted mb-3 mt-4 d-block">
                                                    RMA <input type="checkbox" id="selectAll2"> 全選
                                                </b>
                                            </div>
                                        </div>
                                        <div class="form-row" id="rmacheck">
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox18">
                                                <label class="custom-control-label" for="checkbox18">RMA退貨授權查詢</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox19">
                                                <label class="custom-control-label" for="checkbox19">RMA不良原因查詢</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="checkbox32">
                                            <label class="custom-control-label" for="checkbox32">產品維修單</label>
                                        </div>
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="checkbox33">
                                            <label class="custom-control-label" for="checkbox33">產品維修單明細表</label>
                                        </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="custom-checkbox custom-control-inline">
                                                <b class="text-muted mb-3 mt-4 d-block">
                                                    檔案管理 <input type="checkbox" id="selectAll3"> 全選
                                                </b>
                                            </div>
                                        </div>
                                        <div class="form-row" id="fileManagement">
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox20">
                                                <label class="custom-control-label" for="checkbox20">韌體上傳</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox21">
                                                <label class="custom-control-label" for="checkbox21">ECR/ECN新增</label>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="custom-checkbox custom-control-inline">
                                                <b class="text-muted mb-3 mt-4 d-block">
                                                    庫存表 <input type="checkbox" id="selectAll4"> 全選
                                                </b>
                                            </div>
                                        </div>
                                        <div class="form-row" id="stock">
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox22">
                                                <label class="custom-control-label" for="checkbox22">成品庫存查詢</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox23">
                                                <label class="custom-control-label" for="checkbox23">料件庫存查詢</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox24">
                                                <label class="custom-control-label" for="checkbox24">國外庫存上傳</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox25">
                                                <label class="custom-control-label" for="checkbox25">庫存查詢</label>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="custom-checkbox custom-control-inline">
                                                <b class="text-muted mb-3 mt-4 d-block">
                                                    設定 <input type="checkbox" id="selectAll5"> 全選
                                                </b>
                                            </div>
                                        </div>
                                        <div class="form-row" id="setup">
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox26">
                                                <label class="custom-control-label" for="checkbox26">修改密碼</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox27">
                                                <label class="custom-control-label" for="checkbox27">登入紀錄</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox28">
                                                <label class="custom-control-label" for="checkbox28">權限調整</label>
                                            </div>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="checkbox30">
                                                <label class="custom-control-label" for="checkbox30">使用者修改</label>
                                            </div>
                                        </div>
                                        <div class="row justify-content-md-center">
                                            <div class="col-lg-2">
                                                <div class="">
                                                    <button type="button" id="delCheck" class="btn btn-danger btn-block">刪除</button>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="">
                                                    <button type="button" id="saveSubmit" class="btn btn-primary btn-block">儲存</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <!-- Modal -->
                            <div class="modal fade" id="dellCheck">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete Check </h5>
                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <span>ID: <span style="color: red;font-size:2rem">{{$employee_id}}</span> 刪除確認</span>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal" id="userDelete">刪除</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
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
        </div>


    </body>
    @include('layouts/footerjs')
    <script>
        const selectAllCheckbox = document.getElementById('selectAll');
        const selectAllCheckbox2 = document.getElementById('selectAll2');
        const selectAllCheckbox3 = document.getElementById('selectAll3');
        const selectAllCheckbox4 = document.getElementById('selectAll4');
        const selectAllCheckbox5 = document.getElementById('selectAll5');
        const selectAllCheckbox6 = document.getElementById('selectAll6');

        const checkboxesToToggle6 = document.querySelectorAll('#salesManagementcheck input[type="checkbox"]');
        const checkboxesToToggle = document.querySelectorAll('#queryAndDownload input[type="checkbox"]');
        const checkboxesToToggle2 = document.querySelectorAll('#rmacheck input[type="checkbox"]');
        const checkboxesToToggle3 = document.querySelectorAll('#fileManagement input[type="checkbox"]');
        const checkboxesToToggle4 = document.querySelectorAll('#stock input[type="checkbox"]');
        const checkboxesToToggle5 = document.querySelectorAll('#setup input[type="checkbox"]');


        function handleSelectAllCheckboxChange(checkbox, checkboxesToToggle) {
            checkbox.addEventListener('change', function() {
                const isChecked = this.checked;
                checkboxesToToggle.forEach(function(checkbox) {
                    checkbox.checked = isChecked;
                });
            });
        }
        handleSelectAllCheckboxChange(selectAllCheckbox, checkboxesToToggle);
        handleSelectAllCheckboxChange(selectAllCheckbox2, checkboxesToToggle2);
        handleSelectAllCheckboxChange(selectAllCheckbox3, checkboxesToToggle3);
        handleSelectAllCheckboxChange(selectAllCheckbox4, checkboxesToToggle4);
        handleSelectAllCheckboxChange(selectAllCheckbox5, checkboxesToToggle5);
        handleSelectAllCheckboxChange(selectAllCheckbox6, checkboxesToToggle6);

        $(document).ready(function() {
            $('#loading').hide();
            $('#searchID').prop('disabled', true);
            $('#checkPermissionForm').toggle();
            const searchSubmitButton = $('#searchSubmit');
            const reSearchButton = $('#reSearch');
            reSearchButton.hide();
            getUserData()

            function getUserData() {
                var searchID = $('#searchID').val();
                $('#loading').show();
                $.ajax({
                    url: 'userSearchIDAjax',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        searchID: searchID
                    },
                    success: function(response) {
                        $('#loading').hide();
                        getCheckBox(response);
                        $('#checkPermissionForm').toggle();

                        searchSubmitButton.hide();
                        reSearchButton.show();
                    },
                    error: function(xhr, status, error) {
                        console.log('no data');
                        $('#loading').hide();
                        alert('查無資料');
                    }
                });
            };




            $('#saveSubmit').click(function() {
                const selectedCheckboxIds = []; // 用於存儲已選中的 checkbox 的 ID 的數組
                // 獲取所有具有 class "custom-control-input" 的 checkbox
                const checkboxes = document.querySelectorAll('.custom-control-input');
                // 遍歷所有 checkbox
                checkboxes.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        // 如果 checkbox 被選中，提取其 ID 並將數字部分存入數組
                        const id = checkbox.id.replace('checkbox', ''); // 移除 "checkbox" 前綴
                        selectedCheckboxIds.push(parseInt(id, 10)); // 轉換為整數並存入數組
                    }
                });
                var searchID = $('#searchID').val();
                $('#loading').show();
                $.ajax({
                    url: 'userUpdatePermissionAjax',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        searchID: searchID,
                        selectedCheckboxIds: selectedCheckboxIds
                    },
                    success: function(response) {
                        $('#loading').hide();
                    },
                    error: function(xhr, status, error) {
                        console.log('no data');
                        $('#loading').hide();
                    }
                });

            });

            $('#reSearch').click(function() {
                location.reload();
            });
            $('#delCheck').click(function() {
                $('#dellCheck').modal('show');
            });
            $('#userDelete').click(function() {
                var searchID = $('#searchID').val();
                $('#loading').show();
                $.ajax({
                    url: 'userDeleteAjax',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        searchID: searchID
                    },
                    success: function(response) {
                        $('#loading').hide();
                        console.log(response);
                        alert('删除成功');
                        window.close();
                    },
                    error: function(xhr, status, error) {
                        console.log('no data');
                        $('#loading').hide();

                    }
                });
            });

            function getCheckBox(response) {
                var permissionData = response[0]['permission'];
                var pageID = permissionData.split(',').map(function(item) {
                    return parseInt(item.trim(), 10);
                });
                pageID.forEach(permissionValue => {
                    const checkbox = document.getElementById(`checkbox${permissionValue}`);
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                });
            }
        });
    </script>

</html>