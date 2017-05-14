function generateChartData(post_id, names) {
    console.log('generateChartData():');
    $.each(names, function (i, name) {
        /*
         $.get(Ajax.json_url + '/SensorLog/charts/', {
         'type': 'media',
         'name': name,
         'post_id': post_id
         },
         */
        console.log(Ajax.json_url + '/SensorLog/charts/?type=media&name=' + name + '&post_id=' + post_id);
        $.getJSON(Ajax.json_url + '/SensorLog/charts/?type=media&name=' + name + '&post_id=' + post_id, function (media) {
            console.log(media);
            $media = $('#widget-' + post_id + ' table.media tr#' + name);
            if (media.min != '-') {
                $($media).removeClass('hide');
                $($media).find('strong.min').html('<small>' + media.min + '</small>');
            }
            if (media.max != '-') {
                $($media).removeClass('hide');
                $($media).find('strong.max').html('<small>' + media.max + '</small>');
            }
        });
    });
}

if ($('body').find(".charts")) {
    $('body').find(".charts").each(function () {
        console.log('amcharts.widget.js:');

        var chart = new AmCharts.AmSerialChart();

        $this = $(this);
        $($this).html("Aguarde, carregando gráfico ...");
        var data_names = $($this).attr('data-names');
        var chart_type = $($this).attr('data-type');
        var post_id = $($this).attr('data-postid');
        var graph_id = $($this).attr('data-graphid');
        var names = data_names.split(',');

        var chartData = [];
        var chartCursor;
        var day = 0;

        var seriesOptions = [],
            seriesCounter = 0;
        if (chart_type == 'widget') {
            // create chart
            AmCharts.ready(function () {
                // generate some data first
                generateChartData(post_id, names);
                var chartData = 0;

                $.getJSON(Ajax.json_url + '/SensorLog/charts/?base=' + data_names + '&post_id=' + post_id, function (result) {
                    console.log(Ajax.json_url + '/SensorLog/charts/?base=' + data_names + '&post_id=' + post_id);
                    if (result.status == 0) {
                        $('div.charts[data-postid="' + post_id + '"][data-graphid="' + data_names + '"]').html(result.response);
                        return false;
                    }
                    $('#widget-' + post_id + ' table.media').removeClass('hide');

                    resultData = result.response;

                    // SERIAL CHART
                    chart.pathToImages = "http://www.amcharts.com/lib/3/images/";
                    chart.dataProvider = resultData;
                    chart.categoryField = "date";
                    chart.dateFormats = {period: 'mm', format: 'JJ:NN'};

                    console.log('chart.dataProvider');
                    console.log(chart.dataProvider);
                    var val = ($(chart.dataProvider).get(-1).date).replace(' ', '').replace(/\-/g, '').replace(/\:/g, '');

                    console.log(val);//atribuir o último momento aqui!
                    // $($this).attr('data-last',val); //atribuir o último momento aqui!
                    $('div#chart-' + post_id + '-' + data_names).data('last', val); //atribuir o último momento aqui!

                    var categoryAxis = chart.categoryAxis;
                    categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
                    categoryAxis.minPeriod = "mm"; // our data is daily, so we set minPeriod to DD

                    categoryAxis.dashLength = 1;
                    categoryAxis.gridAlpha = 0.15;
                    categoryAxis.axisColor = "#DADADA";

                    // var nomes = resultData[0].category.split(',');
                    var nomes = resultData[0].display_name.split(',');

                    for (var i in nomes) {

                        var l = nomes[i];
                        var v = "value" + (i++);
                        var graph = new AmCharts.AmGraph();
                        graph.valueField = v;
                        graph.balloonText = l + ": [[" + v + "]]";
                        graph.bullet = "round";
                        graph.bulletBorderColor = "#FFFFFF";
                        graph.bulletBorderThickness = 2;
                        graph.lineThickness = 2;
                        graph.lineAlpha = 0.5;
                        chart.addGraph(graph);

                    }

                    // CURSOR
                    chartCursor = new AmCharts.ChartCursor();
                    chartCursor.cursorPosition = "mouse";
                    chartCursor.categoryBalloonDateFormat = "JJ:NN";
                    chart.addChartCursor(chartCursor);

                    // CATEGORY AXIS 
                    chart.categoryAxis.parseDates = true;

                    // WRITE
                    chart.write('chart-' + post_id + '-' + graph_id);
                });

                console.log('setInterval(function () {');
                /*set up the chart to update every second*/
                setInterval(function () {
                    last = $("div.container-fluid").find("div[id='chart-" + post_id + "-" + data_names + "']").data('last');
                    $.getJSON(Ajax.json_url + '/SensorLog/charts/?type=add&base=' + data_names + '&post_id=' + post_id + '&start=' + $("div.container-fluid").find("div[id='chart-" + post_id + "-" + data_names + "']").data('last'), function (result) {
                        console.log('chart.dataProvider.shift()');
                        console.log(Ajax.json_url + '/SensorLog/charts/?type=add&base=' + data_names + '&post_id=' + post_id + '&start=' + $("div.container-fluid").find("div[id='chart-" + post_id + "-" + data_names + "']").data('last'));
                        console.log(result);
                        if (result.status == 1) {
                            chart.dataProvider.shift();
                            resultData = $(result.response).last()[0];
                            var val = (resultData.date).replace(' ', '').replace(/\-/g, '').replace(/\:/g, '');
                            $("div.container-fluid").find("div[id='chart-" + post_id + "-" + data_names + "']").data('last', val);
                            if (resultData.count == 1) {
                                chart.dataProvider.push({
                                    date: resultData.date,
                                    value0: resultData.value0
                                });
                            }
                            if (resultData.count == 2) {
                                chart.dataProvider.push({
                                    date: resultData.date,
                                    value0: resultData.value0,
                                    value1: resultData.value1
                                });
                            }
                            if (resultData.count == 3) {
                                chart.dataProvider.push({
                                    date: resultData.date,
                                    value0: resultData.value0,
                                    value1: resultData.value1,
                                    value2: resultData.value2
                                });
                            }
                            chart.validateData();
                        }
                    });

                }, 50000);
            });


        }
    });
}


