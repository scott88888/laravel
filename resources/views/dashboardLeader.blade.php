<!DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>
    <title>Dashboard</title>
    @include('layouts/head')
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Dark.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/plugins/exporting.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>

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
            <div class="row">

                <div class="col-lg-4" style="padding: 2px 2px 2px 10px;">
                    <div class="card">
                        <div class="card-body" style="padding: 0rem;">
                            <h4 class="header-title" style="text-align: center;">借品排行榜</h4>
                            <div id="chartdiv1" class="chartdiv"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" style="padding: 2px;">
                    <div class="card">
                        <div class="card-body" style="padding: 0rem;">
                            <h4 class="header-title" style="text-align: center;">成品庫存排行榜</h4>
                            <div id="chartdiv2" class="chartdiv"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" style="padding: 2px;">
                    <div class="card">
                        <div class="card-body" style="padding: 0rem;">
                            <h4 class="header-title" style="text-align: center;">零件庫存排行榜</h4>
                            <div id="chartdiv3" class="chartdiv"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-lg-12" style="padding: 2px;">
                    <div class="card">
                        <div class="card-body" style="padding: 0rem;">
                            <h4 class="header-title" style="text-align: center;">入料逾期明細表</h4>
                            <div id="chartdiv4" class="chartdiv"></div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        @include('layouts/footer')
    </div>
    @include('layouts/settings')
</body>
@include('layouts/footerjs')
<Script>
    //排行榜
    var mfr = JSON.parse('@json($MfrDashboard)');
    var productStock = JSON.parse('@json($ProductStockDashboard)');
    var partsStock = JSON.parse('@json($PartsStockDashboard)');
    var BuyDelay = JSON.parse('@json($BuyDelayDashboard)');
    
    
    console.log(BuyDelay);
    // 定義兩個不同的資料

    var data1 = [];
    var data2 = [];
    var data3 = [];


    for (let i = 0; i < mfr.length; i++) {
        data1.push({
            item: mfr[i].cod_item,
            value: parseInt(mfr[i].qty_brow),

        });
    }

    for (let i = 0; i < productStock.length; i++) {
        data2.push({
            item: productStock[i].cod_item,
            value: productStock[i].qty_stk
        });
    }

    for (let i = 0; i < partsStock.length; i++) {
        data3.push({
            item: partsStock[i].cod_item,
            value: partsStock[i].qty_stk
        });
    }


    am5.ready(function() {
        // 第一個圖表
        var root1 = am5.Root.new("chartdiv1");
        root1.setThemes([
            am5themes_Animated.new(root1)
        ]);
        var chart1 = root1.container.children.push(am5xy.XYChart.new(root1, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX",
            pinchZoomX: true
        }));
        var cursor1 = chart1.set("cursor", am5xy.XYCursor.new(root1, {}));
        cursor1.lineY.set("visible", false);
        var xRenderer1 = am5xy.AxisRendererX.new(root1, {
            minGridDistance: 30
        });
        xRenderer1.labels.template.setAll({
            // rotation: 50,
            // centerY: am5.p50,
            // centerX: am5.p100,
            // paddingRight: 15
            rotation: 50,
            centerY: am5.p100,
            centerX: am5.p200,
            paddingRight: 50
        });

        xRenderer1.grid.template.setAll({
            location: 1
        })

        var xAxis1 = chart1.xAxes.push(am5xy.CategoryAxis.new(root1, {
            maxDeviation: 0.3,
            categoryField: "item",
            renderer: xRenderer1,
            tooltip: am5.Tooltip.new(root1, {})
        }));

        var yAxis1 = chart1.yAxes.push(am5xy.ValueAxis.new(root1, {
            maxDeviation: 0.3,
            renderer: am5xy.AxisRendererY.new(root1, {
                strokeOpacity: 0.1
            })
        }));
        var series1 = chart1.series.push(am5xy.ColumnSeries.new(root1, {
            name: "Series 1",
            xAxis: xAxis1,
            yAxis: yAxis1,
            valueYField: "value",
            sequencedInterpolation: true,
            categoryXField: "item",
            tooltip: am5.Tooltip.new(root1, {
                labelText: "{valueY}"
            })
        }));

        series1.columns.template.setAll({
            cornerRadiusTL: 5,
            cornerRadiusTR: 5,
            strokeOpacity: 0,

        });

        series1.columns.template.adapters.add("fill", function(fill, target) {
            return chart1.get("colors").getIndex(series1.columns.indexOf(target));
        });

        series1.columns.template.adapters.add("stroke", function(stroke, target) {
            return chart1.get("colors").getIndex(series1.columns.indexOf(target));
        });

        // 設定第一個圖表的資料
        xAxis1.data.setAll(data1);
        series1.data.setAll(data1);

        series1.appear(1000);
        chart1.appear(1000, 100);

        // 第二個圖表
        var root2 = am5.Root.new("chartdiv2");
        root2.setThemes([
            am5themes_Animated.new(root2)
        ]);
        var chart2 = root2.container.children.push(am5xy.XYChart.new(root2, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX",
            pinchZoomX: true
        }));
        var cursor2 = chart2.set("cursor", am5xy.XYCursor.new(root2, {}));
        cursor2.lineY.set("visible", false);
        var xRenderer2 = am5xy.AxisRendererX.new(root2, {
            minGridDistance: 30
        });
        xRenderer2.labels.template.setAll({
            rotation: 50,
            centerY: am5.p100,
            centerX: am5.p200,
            paddingRight: 50
        });

        xRenderer2.grid.template.setAll({
            location: 1
        })

        var xAxis2 = chart2.xAxes.push(am5xy.CategoryAxis.new(root2, {
            maxDeviation: 0.3,
            categoryField: "item",
            renderer: xRenderer2,
            tooltip: am5.Tooltip.new(root2, {})
        }));

        var yAxis2 = chart2.yAxes.push(am5xy.ValueAxis.new(root2, {
            maxDeviation: 0.3,
            renderer: am5xy.AxisRendererY.new(root2, {
                strokeOpacity: 0.1
            })
        }));
        var series2 = chart2.series.push(am5xy.ColumnSeries.new(root2, {
            name: "Series 2",
            xAxis: xAxis2,
            yAxis: yAxis2,
            valueYField: "value",
            sequencedInterpolation: true,
            categoryXField: "item",
            tooltip: am5.Tooltip.new(root2, {
                labelText: "{valueY}"
            })
        }));

        series2.columns.template.setAll({
            cornerRadiusTL: 5,
            cornerRadiusTR: 5,
            strokeOpacity: 0
        });
        series2.columns.template.adapters.add("fill", function(fill, target) {
            return chart2.get("colors").getIndex(series2.columns.indexOf(target));
        });

        series2.columns.template.adapters.add("stroke", function(stroke, target) {
            return chart2.get("colors").getIndex(series2.columns.indexOf(target));
        });

        // 設定第二個圖表的資料
        xAxis2.data.setAll(data2);
        series2.data.setAll(data2);

        series2.appear(1000);
        chart2.appear(1000, 100);


        // 第三個圖表
        var root3 = am5.Root.new("chartdiv3");
        root3.setThemes([
            am5themes_Animated.new(root3)
        ]);
        var chart3 = root3.container.children.push(am5xy.XYChart.new(root3, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX",
            pinchZoomX: true
        }));
        var cursor3 = chart3.set("cursor", am5xy.XYCursor.new(root3, {}));
        cursor3.lineY.set("visible", false);
        var xRenderer3 = am5xy.AxisRendererX.new(root3, {
            minGridDistance: 30
        });
        xRenderer3.labels.template.setAll({
            rotation: 50,
            centerY: am5.p100,
            centerX: am5.p200,
            paddingRight: 50
        });

        xRenderer3.grid.template.setAll({
            location: 1
        })

        var xAxis3 = chart3.xAxes.push(am5xy.CategoryAxis.new(root3, {
            maxDeviation: 0.3,
            categoryField: "item",
            renderer: xRenderer3,
            tooltip: am5.Tooltip.new(root3, {})
        }));

        var yAxis3 = chart3.yAxes.push(am5xy.ValueAxis.new(root3, {
            maxDeviation: 0.3,
            renderer: am5xy.AxisRendererY.new(root3, {
                strokeOpacity: 0.1
            })
        }));
        var series3 = chart3.series.push(am5xy.ColumnSeries.new(root3, {
            name: "Series 3",
            xAxis: xAxis3,
            yAxis: yAxis3,
            valueYField: "value",
            sequencedInterpolation: true,
            categoryXField: "item",
            tooltip: am5.Tooltip.new(root3, {
                labelText: "{valueY}"
            })
        }));

        series3.columns.template.setAll({
            cornerRadiusTL: 5,
            cornerRadiusTR: 5,
            strokeOpacity: 0,

        });
        series3.columns.template.adapters.add("fill", function(fill, target) {
            return chart3.get("colors").getIndex(series3.columns.indexOf(target));
        });

        series3.columns.template.adapters.add("stroke", function(stroke, target) {
            return chart3.get("colors").getIndex(series3.columns.indexOf(target));
        });

        // 設定第三個圖表的資料
        xAxis3.data.setAll(data3);
        series3.data.setAll(data3);

        series3.appear(1000);
        chart3.appear(1000, 100);

        //第四個圖表
        var root4 = am5.Root.new("chartdiv4");
        root4.setThemes([
            am5themes_Animated.new(root4)
        ]);

        var chart4 = root4.container.children.push(
            am5percent.PieChart.new(root4, {
                endAngle: 270
            })
        );

        var series4 = chart4.series.push(
            am5percent.PieSeries.new(root4, {
                valueField: "value",
                categoryField: "category",
                endAngle: 270,

            })
        );
        // series4.get("colors").set("colors", [
        //     am5.color(0x2ABB9B),
        //     am5.color(0x00B16A),
        //     am5.color(0x1E824C),
        //     am5.color(0x26A65B),
        //     am5.color(0x59ABE3)
        // ]);
        series4.states.create("hidden", {
            endAngle: -90
        });

        series4.data.setAll([{
            category: "Lithuania",
            value: 501.9
        }, {
            category: "Czechia",
            value: 301.9
        }, {
            category: "Ireland",
            value: 201.1
        }, {
            category: "Germany",
            value: 165.8
        }, {
            category: "Australia",
            value: 139.9
        }, {
            category: "Austria",
            value: 128.3
        }, {
            category: "UK",
            value: 99
        }]);

        series4.appear(1000, 100);
    });
</script>


</html>