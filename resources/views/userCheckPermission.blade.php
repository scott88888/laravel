<!DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>

    @include('layouts/head')
</head>

<script>
    $(document).ready(function() {
        $('#ListData').DataTable();
    });
</script>

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
                                    <h6>查詢當前用戶權限</h6>
                                    <div class="mb-3"></div>
                                    <div class="form-row">
                                        <div class="col-md-2 mb-3" id="searchBox">
                                            <label for="">員工編號</label>
                                            <input id="searchID" type="text" class="form-control" placeholder="" required="">
                                        </div>
                                        <div class="col-2">
                                            <label for="">查詢</label>
                                            <button type="button" id="searchSubmit" class="btn btn-primary btn-block">送出</button>
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
                                                文件查詢/下載 <input type="checkbox" id="selectAll"> 全選
                                            </b>
                                        </div>
                                    </div>
                                    <div class="form-row" id="queryAndDownload">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="checkbox22">
                                            <label class="custom-control-label" for="checkbox22">韌體下載查詢</label>
                                        </div>
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="checkbox16">
                                            <label class="custom-control-label" for="checkbox16">產品型號查詢</label>
                                        </div>
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="checkbox14">
                                            <label class="custom-control-label" for="checkbox14">客製化申請單查詢</label>
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
    const selectAllCheckbox = document.getElementById('selectAll');
    const checkboxesToToggle = document.querySelectorAll('#queryAndDownload input[type="checkbox"]');

    // 监听 "文件查詢/下載" 的 checkbox 的点击事件
    selectAllCheckbox.addEventListener('change', function() {
        // 获取其选中状态
        const isChecked = this.checked;

        // 切换其他 checkbox 的选中状态
        checkboxesToToggle.forEach(function(checkbox) {
            checkbox.checked = isChecked;
        });
    });


    $(document).ready(function() {
        $('#loading').hide();
        $('#searchSubmit').click(function() {
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
                    console.log(response);
                    $('#loading').hide();
                    getCheckBox(response);
                    // 處理 AJAX 請求成功後的回應

                },
                error: function(xhr, status, error) {
                    // 處理 AJAX 請求失敗後的回應
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
            console.log(pageID);
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