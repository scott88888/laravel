// 去年報修圖表開始
        var root6 = am5.Root.new("chartdiv6");
        root6.setThemes([
            am5themes_Animated.new(root6)
        ]);
        var chart6 = root6.container.children.push(am5xy.XYChart.new(root6, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX",
            pinchZoomX: true
        }));
        var cursor6 = chart6.set("cursor", am5xy.XYCursor.new(root6, {}));
        cursor6.lineY.set("visible", false);
        var xRenderer6 = am5xy.AxisRendererX.new(root6, {
            minGridDistance: 30
        });
        xRenderer6.labels.template.setAll({
            rotation: 50,
            centerY: am5.p100,
            centerX: am5.p200,
            paddingRight: 50
        });

        xRenderer6.grid.template.setAll({
            location: 1
        })

        var xAxis6 = chart6.xAxes.push(am5xy.CategoryAxis.new(root6, {
            maxDeviation: 0.3,
            categoryField: "item",
            renderer: xRenderer6,
            tooltip: am5.Tooltip.new(root6, {})
        }));

        var yAxis6 = chart6.yAxes.push(am5xy.ValueAxis.new(root6, {
            maxDeviation: 0.3,
            renderer: am5xy.AxisRendererY.new(root6, {
                strokeOpacity: 0.1
            })
        }));
        var series6 = chart6.series.push(am5xy.ColumnSeries.new(root6, {
            name: "Series 6",
            xAxis: xAxis6,
            yAxis: yAxis6,
            valueYField: "value",
            sequencedInterpolation: true,
            categoryXField: "item",
            tooltip: am5.Tooltip.new(root6, {
                labelText: "{valueY}"
            })
        }));

        series6.columns.template.setAll({
            cornerRadiusTL: 5,
            cornerRadiusTR: 5,
            strokeOpacity: 0,

        });
        series6.columns.template.adapters.add("fill", function(fill, target) {
            return chart6.get("colors").getIndex(series6.columns.indexOf(target));
        });

        series6.columns.template.adapters.add("stroke", function(stroke, target) {
            return chart6.get("colors").getIndex(series6.columns.indexOf(target));
        });


        xAxis6.data.setAll(data6);
        series6.data.setAll(data6);

        series6.appear(1000);
        chart6.appear(1000, 100);
        // 去年報修圖表結束