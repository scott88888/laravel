<!DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>

    @include('layouts/head')


</head>


<style>
    #chartdiv {
        width: 100%;
        height: 400px;

    }


    .table td,
    .table th {
        padding: 0.25rem;

    }

    .row {
        margin-right: 0px;
        margin-left: 0px;
    }

    .amcharts-main-div {
        margin-left: -40px;
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
                                                    @elseif ($item->TYP_CODE == 6)
                                                    <p>周邊</p>
                                                    @elseif  ($item->TYP_CODE == 7)
                                                    <p>外購NVR/DVR/NAV/Camera</p>    
                                                    @else ($item->TYP_CODE == 8)
                                                    <p>腳架/投射器</p>                                                  
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
                
           
            </div>
            <div class="row">
                <div class="col-4" style="padding: 2px;">
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
                                    <table id="maintenTable" class="table text-center">
                                        <thead class="text-capitalize text-uppercase" style="background: #5C5C5C;color: white;">
                                            <th scope="col">工單</th>
                                            <th scope="col">產品名稱</th>
                                            <th scope="col">訂單數量</th>
                                            <th scope="col">維修數量</th>
                                            <th scope="col">今日不良率</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($maintenData['mainten'] as $item)
                                            <tr class="{{ ($item->count / $item->order_qty * 100) >= 10 ? 'text-danger' : '' }}">
                                                <td><a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/db_query_GAngRate.php?={{ $item->model }}&{{ $item->runcard_no}}">
                                                        {{ substr($item->runcard_no, 0, 11) }}
                                                    </a>
                                                </td>
                                                <td>{{ $item->model }}</td>
                                                <td>{{ $item->order_qty }}</td>
                                                <td>{{ $item->count }}</td>
                                                <td>
                                                    @if ($item->count == 0)
                                                    0
                                                    @else
                                                    {{ round($item->count / $item->order_qty * 100, 1) . '%'  }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="card">
                        <div class="card-body" style="padding: 0;">
                        <div style="text-align: center;">
                                <h4 class="header-title" style="text-align: center;">
                                    {{$maintenData['maintenDate'] }}
                                    製程不良狀況佔比
                                </h4>
                            </div>
                            <div id="chartdiv"></div>
                           
                        </div>
                    </div>
                </div>
                <div class="col-3" style="padding: 2px;">
                    <div class="card">
                        <div class="card-body" style="padding: 0.5rem;">
                            <div style="text-align: center;">
                                <h4 class="header-title" style="text-align: center;">不良統計表(當月)</h4>
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
                <div class="col-5" style="padding: 2px;">
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
                                            <th style="text-align: center;">圖片</th>
                                            <th style="text-align: center;">工單</th>
                                            <th style="text-align: center;">訂單數量</th>
                                            <th style="text-align: center;">已回報數量</th>
                                            <th style="text-align: center;">產品型號</th>
                                            <th style="text-align: center;">製程</th>
                                            
                                        </thead>
                                        <tbody>
                                            @foreach ($productionData['productionStatus'] as $status)
                                            <tr>
                                                <td>
                                                <img style="max-width:56px;" src={{ asset("/show-image/mesitempartlist").'/'.$status->COD_MITEM.'/'.$status->COD_MITEM.'-s.jpg' }} >
                                                </td>
                                                <td>{{ $status->NUM_PS }}</td>
                                                <td>{{ $status->qty_pcs }}</td>
                                                <td>{{ $status->count }}</td>
                                                <td>{{ $status->COD_MITEM }}</td> 
                                               @if ($status->operation == 'A0')
                                                <td>前置作業</td>
                                                @elseif ($status->operation == 'B0')
                                                <td>組裝</td>
                                                @elseif ($status->operation == 'B1')
                                                <td>組裝</td>
                                                @elseif ($status->operation == 'C0')
                                                <td>測試</td>
                                                @elseif ($status->operation == 'D0')
                                                <td>包裝</td>
                                                @elseif ($status->operation == 'D1')
                                                <td>包裝</td>
                                                @elseif (substr($status->runcard_no, 0, 2) == 'AA')
                                                <td style="color:red">重工</td>
                                                @else
                                                <td>{{ $status->operation }}</td>
                                                @endif     

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
                                <h4 class="header-title" style="text-align: center;">RMA維修(過去30天) <span style="color: green;">調整中</span> </h4>
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
                                            @foreach ($warrantyPercent as $status)
                                            <tr>
                                                @if( $status[0] == 'warrantyCountIn' )
                                                <td>製造日期1年內</td>
                                                @elseif( $status[0] == 'warrantyCountOut' )
                                                <td>製造日期1年外</td>
                                                @elseif( $status[0] == 'warrantyCountOther' )
                                                <td>其它</td>
                                                @elseif( $status[0] == 'warrantyCount' )
                                                <td>維修總數</td>
                                                @elseif( $status[0] == 'warrantyTest' )
                                                <td>測試正常</td>
                                                @elseif( $status[0] == 'warrantyQty' )
                                                <td>維修數量</td>
                                                @elseif( $status[0] == 'warrantyDuty' )
                                                <td>製造日期1年內故障數量(本廠)</td>
                                                @endif
                                                <td>{{ $status[1] }}</td>
                                                <td>{{ $status[2] }}</td>
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
            </div>
        </div>

        @include('layouts/footer')
    </div>
    @include('layouts/settings')
</body>
@include('layouts/footerjs')
<script src="{{ asset('js/amcharts3.js') }}"></script>
<script src="{{ asset('js/serial.js') }}"></script>
<script src="{{ asset('js/pie.js') }}"></script>
@if(isset($shipmentMon))
<script>
    $('#maintenTable').DataTable({       
        "info": false, 
        "lengthChange": false,
        "searching": false ,
        "paging": false,
        "order": [[4, "desc"]]
    });
  
    var currentDate = new Date();

    var recentMonths = [];
    for (var i = 0; i < 12; i++) {
        var year = currentDate.getFullYear();
        var month = currentDate.getMonth() + 1;
        var formattedMonth = ("0" + month).slice(-2);
        recentMonths.push(formattedMonth + "月");
        currentDate.setMonth(currentDate.getMonth() - 1);
    }
    var i = 11;
    var shipmentData = @json($shipmentMon);
    var chartData = [];
    shipmentData.forEach(function(item) {
        var monthData = {
            mon: recentMonths[i],
            ahdcam: (item[0] && item[0]['TYP_CODE'] == '1') ? item[0]['QTY'] : 0,
            dvrnvr: (item[1] && item[1]['TYP_CODE'] == '2') ? item[1]['QTY'] : 0,
            ipcam: (item[2] && item[2]['TYP_CODE'] == '3') ? item[2]['QTY'] : 0,
            nav: (item[3] && item[3]['TYP_CODE'] == '4') ? item[3]['QTY'] : 0,
            sp: (item[4] && item[4]['TYP_CODE'] == '5') ? item[4]['QTY'] : 0,    
 
            // outsourcing: (item[6] && item[6]['TYP_CODE'] == '7') ? item[6]['QTY'] : 0,
            // tripod: (item[7] && item[7]['TYP_CODE'] == '8') ? item[7]['QTY'] : 0,
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
            }
            // ,{
            //     "balloonText": "外購NVR/DVR/NAV主機 [[category]]: [[value]]",
            //     "bullet": "round",
            //     "title": "外購NVR/DVR/NAV主機",
            //     "valueField": "outsourcing",
            //     "fillAlphas": 0,
            //     "lineColor": "#B9B973",
            //     "lineThickness": 2,
            //     "negativeLineColor": "#B9B973",
            // }, {
            //     "balloonText": "腳架/投射器 [[category]]: [[value]]",
            //     "bullet": "round",
            //     "title": "腳架/投射器",
            //     "valueField": "tripod",
            //     "fillAlphas": 0,
            //     "lineColor": "#B87070",
            //     "lineThickness": 2,
            //     "negativeLineColor": "#B87070",
            // }
        ],
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


    var chartData = [
        @foreach ($maintenData['maintenPie'] as $item)
        {
            "country": "{{ $item->comr_desc }}",
            "litres": {{ $item->COUNT }},
        },
        @endforeach
    ];
    var chart = AmCharts.makeChart("chartdiv", {
        "type": "pie",
        "dataProvider": chartData, // 使用 chartData 作为数据提供程序
        "valueField": "litres",
        "titleField": "country",
        "labelRadius": 5,
        "colorField": "color",
        "labelText": "[[title]]:[[percents]]%",
        "marginTop": 0,
        "marginBottom": 0
    });

    // chart2.dataProvider[0].color = "#E89F7B";
    // chart2.dataProvider[1].color = "#FFAF87";
    // chart2.dataProvider[2].color = "#FF9F7D";
    // chart2.dataProvider[3].color = "#FF8E72";
    chart.dataProvider[3].color = "#F67C68";
    // chart2.dataProvider[5].color = "#ED6A5E";
    // chart2.dataProvider[6].color = "#9DA589";
    // chart2.dataProvider[7].color = "#4CE0B3";
    // chart2.dataProvider[8].color = "#42AC92";
    // chart2.dataProvider[9].color = "#377771";
    chart.validateData();
</script>
@endif

</html>