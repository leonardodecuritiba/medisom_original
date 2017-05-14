function set_minimax_layout(idc, post_id, i, colors, _medias, _display_name) {
    var not_mlog = ["time_leq", "alarm_set", "ipa"];
    _display_name = (_display_name == '') ? idc : _display_name;
    if (_media[i].max != '-') {

        $('#widget-' + post_id + ' .media p.sensor-' + idc).html('<small>' + _display_name + '</small>').append(' <i class="ico-minus" style="color: ' + colors[i] + '"></i>');
        $('#widget-' + post_id + ' .media p.max-' + idc).html('<strong>' + _media[i].max + '</strong> (' + $.format.date(_media[i].max_data, "dd MMM yyyy - HH:mm") + ')');
        $('#widget-' + post_id + ' .media p.min-' + idc).html('<strong>' + _media[i].min + '</strong> (' + $.format.date(_media[i].min_data, "dd MMM yyyy - HH:mm") + ')');

        if ($.inArray(idc, not_mlog) < 0) {
            $('#widget-' + post_id + ' .media p.mlog-' + idc).html('<strong>' + _media[i].mlog + '</strong>');
        } else {
            $('#widget-' + post_id + ' .media p.mlog-' + idc).html('<strong>' + _media[i].mpond + '</strong>');
        }
    }

}


if ($('body').find(".charts")) {
    $('body').find(".charts").each(function () {
        console.log('amcharts.details.js:');

        $(this).html("Aguarde, carregando gráfico...");

        var data_names = $(this).attr('data-names');
        var chart_type = $(this).attr('data-type');
        var post_id = $(this).attr('data-postid');
        var graph_id = $(this).attr('data-graphid');
        var names = data_names.split(',');
        var escalas = $(this).attr('data-escalas').split(',');

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


            $.each(names, function (i, name) {
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

            $div_chart = 'chart-' + post_id + '-' + data_names;
            console.log(Ajax.json_url + '/SensorLog/charts/?type=full&base=' + data_names + '&post_id=' + post_id);
            $.getJSON(Ajax.json_url + '/SensorLog/charts/?type=full&base=' + data_names + '&post_id=' + post_id, function (result) {

                if (result.status == 0) {
                    $('div.charts[data-postid="' + post_id + '"][data-graphid="' + data_names + '"]').html(result.response);
                    return false;
                }

                resultData = result.response;
                console.log(resultData);

                $CHART = generate_amchart($div_chart, resultData, post_id);


                /*set up the $CHART to update every second*/
                setInterval(function () {
                    update_chart_response($CHART, data_names, post_id);
                }, 60000);


            });

            $('.action-filter button').off('click').on('click', function () {
                console.log('.action-filter button');

                var start = $('input[name=start_period]').val();
                var end = $('input[name=end_period]').val();
                $('div.charts[data-postid="' + post_id + '"][data-graphid="' + data_names + '"]').html("Aguarde, carregando gráfico...");

                console.log(Ajax.json_url + '/SensorLog/charts/?type=full&base=' + data_names + '&post_id=' + post_id + '&start=' + start + '&end=' + end);
                $.getJSON(Ajax.json_url + '/SensorLog/charts/?type=full&base=' + data_names + '&post_id=' + post_id + '&start=' + start + '&end=' + end, function (result) {

                    if (result.status == 0) {
                        $('div.charts[data-postid="' + post_id + '"][data-graphid="' + data_names + '"]').html(result.response);
                        return false;
                    }

                    resultData = result.response;
                    $div_chart = 'chart-' + post_id + '-' + data_names;

                    $CHART = generate_amchart($div_chart, resultData, post_id);

                });

            });

        }
    });
}

