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