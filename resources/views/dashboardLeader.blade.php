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

            <!-- <div class="col-lg-4" style="padding: 2px;">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title" style="text-align: center;margin: 10px 0;">過去12個月出貨數量</h4>
                        <div id="amlinechart4"></div>
                        <div style="font-size: 12px; padding-left:1rem;">AHD 攝影機|IPCAM|OEM/ODM攝影機|NVR|DHDDVR|OEM/ODM NVR/DVR|NAV</div>   
                    </div>
                </div>
            </div> -->
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
                                        <thead class="text-capitalize text-uppercase bg-info" style=" background: darkgrey;">                                            
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
                                        <thead class="text-capitalize text-uppercase bg-info" style=" background: darkgrey;">                                            
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
                                        <thead class="text-capitalize text-uppercase bg-info" style=" background: darkgrey;">
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

<script>



    if ($('#amlinechart4').length) {
        var chart = AmCharts.makeChart("amlinechart4", {
            "type": "serial",
            "theme": "light",
            "title": '過去12個月出貨數量',
            "legend": {
                "useGraphSettings": true
            },
            "dataProvider": [{
                "mon": 1 + "月",
                "defective": 800,
                "germany": 1060,
                "uk": 999
            }, {
                "mon": 2 + "月",
                "defective": 900,
                "germany": 1000,
                "uk": 888
            }, {
                "mon": 3 + "月",
                "defective": 750,
                "germany": 1015,
                "uk": 777
            }, {
                "mon": 4 + "月",
                "defective": 650,
                "germany": 1000,
                "uk": 666
            }, {
                "mon": 5 + "月",
                "defective": 400,
                "germany": 1000,
                "uk": 690
            }, {
                "mon": 6 + "月",
                "defective": 550,
                "germany": 990,
                "uk": 780
            }, {
                "mon": 7 + "月",
                "defective": 650,
                "germany": 977,
                "uk": 820
            }, {
                "mon": 8 + "月",
                "defective": 666,
                "germany": 1000,
                "uk": 999
            }, {
                "mon": 9 + "月",
                "defective": 777,
                "germany": 1069,
                "uk": 688
            }, {
                "mon": 10 + "月",
                "defective": 555,
                "germany": 1000,
                "uk": 777
            }, {
                "mon": 11 + "月",
                "defective": 520,
                "germany": 1200,
                "uk": 712
            }, {
                "mon": 12 + "月",
                "defective": 480,
                "germany": 1270,
                "uk": 1300
            }],
            "startDuration": 0.5,
            "graphs": [{
                "balloonText": "AHD 攝影機 [[category]]: [[value]]",
                "bullet": "round",

                "title": "AHD攝影機",
                "valueField": "defective",
                "fillAlphas": 0,
                "lineColor": "#31ef98",
                "lineThickness": 2,
                "negativeLineColor": "#17e285",
            }, {
                "balloonText": "IPCAM [[category]]: [[value]]",
                "bullet": "round",
                "title": "IPCAM",
                "valueField": "germany",
                "fillAlphas": 0,
                "lineColor": "#9656e7",
                "lineThickness": 2,
                "negativeLineColor": "#c69cfd"
            }, {
                "balloonText": "OEM/ODM攝影機[[category]]: [[value]]",
                "bullet": "round",
                "title": "OEM攝影機",
                "valueField": "uk",
                "fillAlphas": 0,
                "lineColor": "#31aeef",
                "lineThickness": 2,
                "negativeLineColor": "#31aeef",
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
    if ($('#ambarchart4').length) {
        var chart = AmCharts.makeChart("ambarchart4", {
            "type": "serial",
            "theme": "light",
            "marginRight": 70,
            "dataProvider": [{
                "country": "馬希娥",
                "visits": 27,
                "color": "#8918FE"
            }, {
                "country": "張二",
                "visits": 82,
                "color": "#7474F0"
            }, {
                "country": "李三",
                "visits": 61,
                "color": "#C5C5FD"
            }, {
                "country": "陳四",
                "visits": 22,
                "color": "#952FFE"
            }, {
                "country": "小明",
                "visits": 26,
                "color": "#7474F0"
            }, {
                "country": "小貓",
                "visits": 14,
                "color": "#CBCBFD"
            }, {
                "country": "小狗",
                "visits": 64,
                "color": "#FD9C21"
            }, {
                "country": "大聰",
                "visits": 11,
                "color": "#0D8ECF"
            }, {
                "country": "大董",
                "visits": 65,
                "color": "#0D52D1"
            }, {
                "country": "小六",
                "visits": 80,
                "color": "#2A0CD0"
            }],
            "valueAxes": [{
                "axisAlpha": 0,
                "position": "left",
                "title": false
            }],
            "startDuration": 1,
            "graphs": [{
                "balloonText": "<b>[[category]]: [[value]]</b>",
                "fillColorsField": "color",
                "fillAlphas": 0.9,
                "lineAlpha": 0.2,
                "type": "column",
                "valueField": "visits"
            }],
            "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
            },
            "categoryField": "country",
            "categoryAxis": {
                "gridPosition": "start",
                "labelRotation": 45
            },
            "export": {
                "enabled": false
            }

        });
    }
</script>

</html>