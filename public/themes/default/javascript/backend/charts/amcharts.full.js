if ($('body').find(".charts")) {
    $('body').find(".charts").each(function () {

        $(this).html("Aguarde, carregando gráfico...");

        var data_names = $(this).attr('data-names');
        var chart_type = $(this).attr('data-type');
        var post_id = $(this).attr('data-postid');
        var graph_id = $(this).attr('data-graphid');
        var NAMES_ = data_names.split(',');
        var TYPE_GRAPH_ = 'line';

        var $CHART;
        var chartData = [];
        var chartCursor;
        var day = 0;


        var seriesOptions = [],
            seriesCounter = 0;
        if (chart_type != 'widget') {


            var chartData1 = [];
            var fieldMap = [];
            var stockPG = [];
            /*

             $.each(NAMES_, function (i, name) {
             $.get(Ajax.json_url + '/SensorLog/charts/', {
             'type': 'media',
             'name': name,
             'post_id': post_id
             }, function (media) {
             var media = $.parseJSON(media);
             $('#widget-' + post_id + ' div.media p.min-' + name + ' strong').html(media.min);
             $('#widget-' + post_id + ' div.media p.max-' + name + ' strong').html(media.max);
             });
             });

             */
            function get_data_chart(result) {
                if (!result) {
                    $('#chart-' + post_id + '-' + graph_id).html("Nenhum registro, utilize o filtro para buscar outros períodos.");
                    return false;
                }
                var chartData = result;
                var nomes = result[0].category.split(',');
                var graph = [];
                var bullet = ["round", "square", "triangleUp"];
                var color = ["#FF6600", "#FCD202", "#B0DE09"];
                var not_mlog = ["time_leq", "alarm_set", "ipa"];
                valores = chartData;

                for (var i in nomes) {

                    var idc = nomes[i]; //indicador
                    var v = "value" + (i);
                    var vid = "v" + (i);
                    var gid = "g" + (i);
                    var customBullet = bullet[i];

                    /*
                     graph.push({
                     "type": "column",
                     "balloonText": "LAeq: [[value]]",
                     "fillAlphas": 0.8,
                     "id": "laeq",
                     "lineAlpha": 0.2,
                     "title": "LAeq",
                     "valueField": "laeq" })
                     */
                    if (TYPE_GRAPH_ == 'bar') {
                        graph.push({
                            "type": "column",
                            "balloonText": idc + ": [[" + v + "]]",
                            "fillAlphas": 0.8,
                            "id": idc,
                            "lineAlpha": 0.2,
                            "title": idc,
                            "valueField": v,

                            ////"lineColor": color[i],
                            /*"valueAxis": v,
                             "bullet": customBullet,
                             "bulletBorderThickness": 1,
                             "hideBulletsCount": 30,
                             */
                        });
                    } else {
                        graph.push({
                            "valueAxis": v,
                            //"lineColor": color[i],
                            "bullet": customBullet,
                            "balloonText": idc + ": [[" + v + "]]",
                            "bulletBorderThickness": 1,
                            "hideBulletsCount": 30,
                            "title": idc,
                            "valueField": v,
                            "fillAlphas": 0
                        });
                    }

                    sum = 0;
                    sum_pond = 0;
                    // Fazer a média logaritmica
                    //valores = [50.00,49.16,55.08,50.27,50.88,49.24,49.86,50.53,50.88,55.12];

                    _media = {};
                    _media.max = parseFloat(valores[0]['value' + i]); // Recebe primeiro valor
                    _media.min = parseFloat(valores[0]['value' + i]); // Recebe primeiro valor
                    _media.max_data = valores[0]['date']; // Recebe primeira data
                    _media.min_data = valores[0]['date']; // Recebe primeira data
                    $.each(valores, function () {
                        //_value = this;
                        _value = parseFloat(this['value' + i]);
                        if (_value < _media.min) {
                            _media.min = _value;
                            _media.min_data = this['date'];
                        }
                        if (_value > _media.max) {
                            _media.max = _value;
                            _media.max_data = this['date'];
                        }
                        sum += Math.pow(10, (_value / 10));
                        sum_pond += _value;
                    });
                    _media.mpond = (sum_pond / valores.length).toFixed(1);
                    _media.mlog = (10 * Math.log10(sum / valores.length)).toFixed(1);

                    console.log(idc);
                    console.log("min: " + _media.min);
                    console.log("max: " + _media.max);
                    console.log("mlog: " + _media.mlog);

                    //console.log(color[i]);
                    $('#widget-' + post_id + ' .media p.sensor-' + idc).html('<small>' + idc + '</small>').append(' <i class="ico-minus" style="color: ' + color[i] + '"></i>');
                    $('#widget-' + post_id + ' .media p.max-' + idc).html('<strong>' + _media.max + '</strong> (' + $.format.date(_media.max_data, "dd MMM yyyy - HH:mm") + ')');
                    $('#widget-' + post_id + ' .media p.min-' + idc).html('<strong>' + _media.min + '</strong> (' + $.format.date(_media.min_data, "dd MMM yyyy - HH:mm") + ')');
                    if ($.inArray(idc, not_mlog) < 0) {
                        $('#widget-' + post_id + ' .media p.mlog-' + idc).html('<strong>' + _media.mlog + '</strong>');
                    } else {
                        $('#widget-' + post_id + ' .media p.mlog-' + idc).html('<strong>' + _media.mpond + '</strong>');
                    }
                }

                $o = {};
                $o.dataProvider = chartData;
                $o.graphs = graph;
                $o.graphType = TYPE_GRAPH_;
                var e = 'chart-' + post_id + '-' + graph_id;
                $CHART = null;
                //if(typeof $CHART != 'undefined') $CHART.clear(); //limpando chart
                $CHART = create_amchart($o, e);

                /*set up the chart to update every second*/
                setInterval(function () {
                    $CHART.dataProvider.shift();

                    // add new one at the end
                    $.getJSON(Ajax.json_url + '/SensorLog/charts/?type=add&base=' + data_names + '&post_id=' + post_id, function (result) {

                        return result;
                        if (result[0].count == 1) {
                            $CHART.dataProvider.push({
                                date: result[0].date,
                                value0: result[0].value0
                            });
                        }
                        if (result[0].count == 2) {
                            $CHART.dataProvider.push({
                                date: result[0].date,
                                value0: result[0].value0,
                                value1: result[0].value1
                            });
                        }
                        if (result[0].count == 3) {
                            $CHART.dataProvider.push({
                                date: result[0].date,
                                value0: result[0].value0,
                                value1: result[0].value1,
                                value2: result[0].value2
                            });
                        }

                        $CHART.validateData();
                    });

                }, 60000);
            }

            $('.action-filter button').off('click').on('click', function () {

                $parent = $('.action-filter button').closest('div.panel-body');
                $boxFilter = $($parent).find('div#box-filter')
                $typeReportTarget = $($parent).find('div#type_report_target')
                var period = $($boxFilter).find('select[name=period]').val();
                var type_report = $($boxFilter).find('select[name=type_report]').val();
                TYPE_GRAPH_ = $($boxFilter).find('select[name=type_graph]').val();
                NAMES_ = $($boxFilter).find('select#graph_select').val().join().toLowerCase();
                console.log(NAMES_);

                //$('div#type_report_target').find('p[data-type="'+type_report+'"]').removeClass('hide');
                switch (type_report) {
                    case 'ps':
                        var start = $($typeReportTarget).find('div[data-type="' + type_report + '"] input[name=month]').val();
                        var end = 0;
                        break;
                    case 'pd':
                        var start = $($typeReportTarget).find('div[data-type="' + type_report + '"] input[name=start_period]').val();
                        var end = $($typeReportTarget).find('div[data-type="' + type_report + '"] input[name=end_period]').val();
                        break;
                    case 'se':
                        var start = $($typeReportTarget).find('div[data-type="' + type_report + '"] input[name=week]').val();
                        var end = 0;
                        break;
                    case 'ph':
                        var start = $($typeReportTarget).find('div[data-type="' + type_report + '"] input[name=start_period]').val();
                        var end = $($typeReportTarget).find('div[data-type="' + type_report + '"] input[name=interval]').val();
                        break;
                }

                console.log(Ajax.json_url + '/SensorLog/charts/?type=full&base=' + NAMES_ +
                    '&post_id=' + post_id +
                    '&start=' + start +
                    '&end=' + end +
                    '&type_report=' + type_report);

                console.log('chart-' + post_id + '-' + graph_id);
                $('chart-' + post_id + '-' + graph_id).html("Aguarde, carregando gráfico...");
                $.getJSON(Ajax.json_url + '/SensorLog/charts/?type=full&base=' + NAMES_ +
                    '&post_id=' + post_id +
                    '&start=' + start +
                    '&end=' + end +
                    '&type_report=' + type_report,
                    function (result) {
                        get_data_chart(result)
                    });

            });

            console.log(Ajax.json_url + '/SensorLog/charts/?type=full&base=' + data_names + '&post_id=' + post_id);
            $.getJSON(Ajax.json_url + '/SensorLog/charts/?type=full&base=' + data_names +
                '&post_id=' + post_id,
                function (result) {
                    get_data_chart(result)
                });

        }
    });
}

