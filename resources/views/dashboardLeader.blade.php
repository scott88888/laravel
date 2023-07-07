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

    .table td,
    .table th {
        padding: 0.25rem;

    }

    .row {
        margin-right: 0px;
        margin-left: 0px;
    }
</style>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div class="page-container">
        @include('layouts/sidebar')
        <div class="main-content" style="background: #fff;">
            @include('layouts/headerarea')
            <div class="row">
                <div class="col-5" style="padding: 2px;">
                    <div class="card">
                        <div class="card-body" style="padding: 0.5rem;">
                            <h4 class="header-title" style="text-align: center;margin: 10px 0;">過去12個月出貨數量</h4>
                            <div id="amlinechart4"></div>
                            <div style="font-size: 12px; padding-left:1rem;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-3" style="padding: 2px;">
                    <div class="card">
                        <div class="card-body" style="padding: 0.5rem;">
                            <div style="text-align: center;">
                                <h4 class="header-title" style="text-align: center;">當月份累計出貨數量</h4>
                            </div>
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead class="text-capitalize text-uppercase" style="background: #5C5C5C;color: white;">
                                            <th scope="col">種類</th>
                                            <th scope="col">數量</th>
                                            <th scope="col">佔比</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($shipmentThisMon as $item)
                                            <tr>
                                                <td>
                                                    @if ($item->TYP_CODE == 1)
                                                    <p>AHD CAM</p>
                                                    @elseif ($item->TYP_CODE == 2)
                                                    <p>DVR/NVR</p>
                                                    @elseif ($item->TYP_CODE == 3)
                                                    <p>IPCAM</p>
                                                    @elseif ($item->TYP_CODE == 4)
                                                    <p>NAV</p>
                                                    @elseif ($item->TYP_CODE == 5)
                                                    <p>SP</p>
                                                    @else ($item->TYP_CODE == 6)
                                                    <p>周邊</p>
                                                    @endif
                                                </td>
                                                <td>{{ $item->QTY }}</td>
                                                <td>{{ $item->part }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2" style="padding: 2px;">
                    <div class="card">
                        <div class="card-body" style="padding: 0.5rem;">
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
                <div class="col-2" style="padding: 2px;">
                    <div class="card">
                        <div class="card-body" style="padding: 0.5rem;">
                            <div style="text-align: center;">
                                <h4 class="header-title" style="text-align: center;">庫存排行榜</h4>
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
            </div>
            <div class="row">
                

                <div class="col-5" style="padding: 2px;">
                    <div class="card">
                        <div class="card-body" style="padding: 0.5rem;">
                            <div style="text-align: center;">
                                <h4 class="header-title" style="text-align: center;">
                                    {{$maintenData['maintenDate'] }}
                                    製程不良狀況
                                </h4>
                            </div>
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead class="text-capitalize text-uppercase" style="background: #5C5C5C;color: white;">
                                            <th scope="col">工單</th>
                                            <th scope="col">產品名稱</th>
                                            <th scope="col">訂單數量</th>
                                            <th scope="col">維修數量</th>
                                            <th scope="col">今日不良率</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($maintenData['mainten'] as $item)
                                            <tr>
                                                <td><a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/db_query_GAngRate.php?={{ $item->model }}&{{ $item->runcard_no}}">
                                                        {{ $item->runcard_no }}
                                                    </a>
                                                </td>
                                                <td>{{ $item->model }}</td>
                                                <td>{{ $item->order_qty }}</td>
                                                <td>{{ $item->ng_qty }}</td>
                                                <td>{{ round($item->ng_qty / $item->order_qty * 100, 1) . '%'  }}</td>
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
                        <div class="card-body" style="padding: 0.5rem;">
                            <div style="text-align: center;">
                                <h4 class="header-title" style="text-align: center;">
                                    {{$productionData['currentDate'] }} 工單生產狀況 (條碼回報)
                                </h4>
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
                                            @foreach ($productionData['productionStatus'] as $status)
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
                <div class="col-3" style="padding: 2px;">
                    <div class="card">
                        <div class="card-body" style="padding: 0.5rem;">
                            <div style="text-align: center;">
                                <h4 class="header-title" style="text-align: center;">RMA維修(過去30天)</h4>
                            </div>
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table id="ListData" class="table text-center">
                                        <thead class="text-capitalize text-uppercase" style="background: #5C5C5C;color: white;">
                                            <th style="text-align: center;"></th>
                                            <th style="text-align: center;">數量</th>
                                            <th style="text-align: center;">百分比</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($warranty as $status)
                                            <tr>
                                                <td>{{ $status->PS1_4 }}</td>
                                                <td>{{ $status->Count }}</td>
                                                <td>{{ $status->part }}</td>
                                            </tr>
                                            @endforeach
                                            @foreach ($warrantyPart as $status)
                                            <tr>
                                                <td>無損毀</td>
                                                <td>{{ $status->noDamage }}</td>
                                                <td>{{ $status->noDamagePer }}</td>
                                            </tr>
                                            <tr>
                                                <td>換零件</td>
                                                <td>{{ $status->changeParts }}</td>
                                                <td>{{ $status->changePartsPer }}</td>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @foreach ($AVGtime as $status)
                                            <tr>
                                                <td>入場平均時間</td>
                                                <td>{{ $status->Count }}</td>
                                                <td></td>
                                            </tr>
                                            @endforeach
                                            @foreach ($repairQuantity as $status)
                                            <tr>
                                                <td>維修總數</td>
                                                <td>{{ $status->Count }}</td>
                                                <td></td>
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
            <div class="row">
            <div class="col-3" style="padding: 2px;">
                    <div class="card">
                        <div class="card-body" style="padding: 0.5rem;">
                            <div style="text-align: center;">
                                <h4 class="header-title" style="text-align: center;">季出貨排行榜(202303-202306)</h4>
                            </div>
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead class="text-capitalize text-uppercase" style="background: #5C5C5C;color: white;">
                                            <th scope="col">品名</th>
                                            <th scope="col">分類</th>
                                            <th scope="col">季出貨</th>
                                            <th scope="col">成品庫存</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                @foreach ($shipmentRanking as $item)
                                            <tr>
                                                <td>{{ $item->COD_ITEM }}</td>
                                                <td>
                                                    @if ($item->TYP_CODE == 1)
                                                    <p>AHD CAM</p>
                                                    @elseif ($item->TYP_CODE == 2)
                                                    <p>DVR/NVR</p>
                                                    @elseif ($item->TYP_CODE == 3)
                                                    <p>IPCAM</p>
                                                    @elseif ($item->TYP_CODE == 4)
                                                    <p>NAV</p>
                                                    @elseif ($item->TYP_CODE == 5)
                                                    <p>SP</p>
                                                    @else ($item->TYP_CODE == 6)
                                                    <p>周邊</p>
                                                    @endif
                                                </td>
                                                <td>{{ $item->QTY_DEL }}</td>
                                                <td>
                                                    @if ($item->QTY_STK > 0 )
                                                    <p> {{ $item->QTY_STK }}</p>
                                                    @else
                                                    <p>0</p>
                                                    @endif
                                                </td>

                                            </tr>
                                            @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4" style="padding: 2px;">
                    <div class="card">
                        <div class="card-body" style="padding: 0.5rem;">
                            <div style="text-align: center;">
                                <h4 class="header-title" style="text-align: center;">不良統計表(過去30天)</h4>
                            </div>
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead class="text-capitalize text-uppercase" style="background: #5C5C5C;color: white;">
                                            <th scope="col">不良現象</th>
                                            <th scope="col">不良代號</th>
                                            <th scope="col">數量</th>
                                            <th scope="col">占比</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($description as $item)
                                            <tr>
                                                <td>{{ $item->comr_desc }}</td>
                                                <td>{{ $item->sts_comr }}</td>
                                                <td>{{ $item->count_comr }}</td>
                                                <td>{{ $item->total }}</td>
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
<script>
    $(document).ready(function() {
        // 檢查是否支援全畫面 API
        console.log('test');
        if (document.documentElement.requestFullscreen) {
            // 在載入完成後，進入全畫面模式
            document.documentElement.requestFullscreen();
        }
    });
</script>
@if(isset($shipmentMon))
<script>
    // 获取当前日期
    var currentDate = new Date();
    // 存储最近 12 个月份的数组
    var recentMonths = [];
    for (var i = 0; i < 12; i++) {
        var year = currentDate.getFullYear();
        var month = currentDate.getMonth() + 1;
        var formattedMonth = ("0" + month).slice(-2);
        recentMonths.push(formattedMonth + "月");
        currentDate.setMonth(currentDate.getMonth() - 1);
    }

    console.log(recentMonths[11]);
    var i = 11;
    var shipmentData = @json($shipmentMon);
    console.log(shipmentData);
    var chartData = [];
    shipmentData.forEach(function(item) {
        var monthData = {
            mon: recentMonths[i],
            ahdcam: (item[0] && item[0]['TYP_CODE'] == '1') ? item[0]['QTY'] : 0,
            dvrnvr: (item[1] && item[1]['TYP_CODE'] == '2') ? item[1]['QTY'] : 0,
            ipcam: (item[2] && item[2]['TYP_CODE'] == '3') ? item[2]['QTY'] : 0,
            nav: (item[3] && item[3]['TYP_CODE'] == '4') ? item[3]['QTY'] : 0,
            sp: (item[4] && item[4]['TYP_CODE'] == '5') ? item[4]['QTY'] : 0,

        };
        chartData.push(monthData);
        i = i - 1;
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