<!DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>

    @include('layouts/head')


</head>


<style>
    .chartdiv {
        width: 100%;
        height: 500px;
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

            <div class="col-lg-6" style="padding: 2px;">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title" style="text-align: center;margin: 10px 0;">過去12個月出貨數量</h4>
                        <div id="amlinechart4"></div>
                        <div style="font-size: 12px; padding-left:1rem;"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4" style="padding: 2px;">
                    <div class="card">
                        <div class="card-body">
                            <div style="text-align: center;">
                                <h4 class="header-title" style="text-align: center;">借品排行榜</h4>
                            </div>
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead class="text-capitalize text-uppercase" style="background: #5C5C5C;color: white;">
                                            <th scope="col">借出人</th>
                                            <th scope="col">數量</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($borrowItem as $item)
                                            <tr>
                                                <td>{{ $item->nam_emp }}</td>
                                                <td>{{ $item->total_qty }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4" style="padding: 2px;">
                    <div class="card">
                        <div class="card-body">
                            <div style="text-align: center;">
                                <h4 class="header-title" style="text-align: center;">滯銷品排行榜</h4>
                            </div>
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead class="text-capitalize text-uppercase" style="background: #5C5C5C;color: white;">
                                            <th scope="col">產品型號</th>
                                            <th scope="col">庫存</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($unsalableProducts as $item)
                                            <tr>
                                                <td>{{ $item->COD_ITEM }}</td>
                                                <td>{{ $item->QTY_STK }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4" style="padding: 2px;">
                    <div class="card">
                        <div class="card-body">
                            <div style="text-align: center;">
                                <h4 class="header-title" style="text-align: center;">今日工單生產狀況 (條碼回報)</h4>
                            </div>
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table id="ListData" class="table text-center">
                                        <thead class="text-capitalize text-uppercase" style="background: #5C5C5C;color: white;">
                                            <th style="text-align: center;">客戶</th>
                                            <th style="text-align: center;">訂單數量</th>
                                            <th style="text-align: center;">已回報數量</th>
                                            <th style="text-align: center;">產品型號</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($productionStatus as $status)
                                            <tr>
                                                <td>{{ $status->remark2 }}</td>
                                                <td>{{ $status->qty_pcs }}</td>
                                                <td>{{ $status->count }}</td>
                                                <td>{{ $status->COD_MITEM }}</td>
                                            </tr>
                                            @endforeach
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
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>

<script src="https://www.amcharts.com/lib/3/serial.js"></script>
@if(isset($shipmentMon))
<script>
    var shipmentData = @json($shipmentMon); // 将后端传递的数组转换为JavaScript对象
    console.log(shipmentData);
    // 定义图表的数据提供者
    var chartData = [];
    shipmentData.forEach(function(item) {
        console.log(item[5]['QTY']);

        var monthData = {
            mon: 0 + "月",
            ahdcam: item[0]['QTY'],
            dvrnvr: item[1]['QTY'],
            ipcam: item[2]['QTY'],
            nav: item[3]['QTY'],
            sp: item[4]['QTY'],
            peripheral: item[5]['QTY'],
        };
        chartData.push(monthData);

    });



    if ($('#amlinechart4').length) {
        var chart = AmCharts.makeChart("amlinechart4", {
            "type": "serial",
            "theme": "light",
            "title": '過去12個月出貨數量',
            "legend": {
                "useGraphSettings": true
            },
            "dataProvider": chartData,
            "startDuration": 0.5,
            "graphs": [{
                "balloonText": "AHD CAM [[category]]: [[value]]",
                "bullet": "round",
                "title": "AHD CAM",
                "valueField": "ahdcam",
                "fillAlphas": 0,
                "lineColor": "#e67e22",
                "lineThickness": 2,
                "negativeLineColor": "#e67e22",
            }, {
                "balloonText": "DVR/NVR [[category]]: [[value]]",
                "bullet": "round",
                "title": "DVR/NVR",
                "valueField": "dvrnvr",
                "fillAlphas": 0,
                "lineColor": "#2ecc71",
                "lineThickness": 2,
                "negativeLineColor": "#2ecc71"
            }, {
                "balloonText": "IPCAM [[category]]: [[value]]",
                "bullet": "round",
                "title": "IPCAM",
                "valueField": "ipcam",
                "fillAlphas": 0,
                "lineColor": "#3498db",
                "lineThickness": 2,
                "negativeLineColor": "#3498db",
            }, {
                "balloonText": "NAV [[category]]: [[value]]",
                "bullet": "round",
                "title": "NAV",
                "valueField": "nav",
                "fillAlphas": 0,
                "lineColor": "#9b59b6",
                "lineThickness": 2,
                "negativeLineColor": "#9b59b6",
            }, {
                "balloonText": "SP [[category]]: [[value]]",
                "bullet": "round",
                "title": "SP",
                "valueField": "sp",
                "fillAlphas": 0,
                "lineColor": "#f1c40f",
                "lineThickness": 2,
                "negativeLineColor": "#f1c40f",
            }, {
                "balloonText": "周邊 [[category]]: [[value]]",
                "bullet": "round",
                "title": "周邊",
                "valueField": "peripheral",
                "fillAlphas": 0,
                "lineColor": "#e67e22",
                "lineThickness": 2,
                "negativeLineColor": "#e67e22",
            }],
            "chartCursor": {
                "cursorAlpha": 0,
                "zoomable": false
            },
            "categoryField": "mon",
            "categoryAxis": {
                "gridPosition": "start",
                "axisAlpha": 0,
                "fillAlpha": 0.05,
                "fillColor": "#000000",
                "gridAlpha": 0,
                "position": "top"
            },
            "export": {
                "enabled": false
            }
        });
    }
</script>
@endif

</html>