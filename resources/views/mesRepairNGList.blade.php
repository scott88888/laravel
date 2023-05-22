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
<style>
    #loading {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        background-color: rgba(255, 255, 255, 0.8);
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        pointer-events: none;
    }

    #loading img {
        max-width: 100%;
        max-height: 100%;
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
            <div class="main-content-inner">
                <div class="row">
                    <!-- Dark table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">產線零件維修不良排行</h4>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label class="col-form-label">排行月份(年)</label>
                                        <select id="launchDate" class="form-control" style="padding: 0;">
                                            <option>select
                                            </option>
                                            @foreach ($date as $item)
                                            <option value="{{ $item->year}}{{ $item->month}}">{{ $item->year}}.{{ $item->month}}
                                            </option>
                                            @endforeach
                                            @foreach ($lastyear as $item)
                                            <option value="{{ $item->lastyear}}">{{ $item->lastyear}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="data-tables datatable-dark">
                                    <table id="ListData" class="display text-center" style="width:100%">
                                        <thead class="text-capitalize" style=" background: darkgrey;">
                                            <tr>
                                               <th>PART_NO</th>
                                               <th>PART_NO</th>
                                               <th>count_sum</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
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
        @include('layouts/footer')
    </div>
    @include('layouts/settings')
</body>
@include('layouts/footerjs')


<script>
    $(document).ready(function() {
        $('#loading').hide();
        let Model;
        let work_no;
        var table = $('#ListData').DataTable({
            "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
            columns: [{
                "data": "PART_NO",
                "title": "零件料號"
            }, {
                "data": "PART_NO",
                "title": "零件名稱"
            }, {
                "data": "count_sum",
                "title": "維修數量"
            } ],
           
        });
        $('#launchDate').on('change', function() {
            var selectedValue = $(this).val();
            $('#loading').show();
            $.ajax({
                url: 'mesRepairNGListAjax',
                type: 'GET',
                dataType: 'json',
                data: {
                    launch_date: selectedValue
                },
                success: function(response) {
                    // 清空表格資料
                    table.clear();
                    // 將回應資料加入表格
                    table.rows.add(response);
                    // 重新繪製表格
                    table.draw();
                    $('#loading').hide();
                    // 處理 AJAX 請求成功後的回應
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // 處理 AJAX 請求失敗後的回應
                    console.log('no');
                    $('#loading').hide();
                }
            });

        });


    });
</script>

</html>