$.getJSON(Ajax.json_url + '/SensorLog/charts/?type=full&base=' + data_names + '&post_id=' + post_id, function (result) {
    console.log('amcharts.report.manual.js:');

    if (result.status == 0) {
        $('div.charts[data-postid="' + post_id + '"][data-graphid="' + data_names + '"]').html(result.response);
        return false;
    }

    resultData = result.response;

    var chartData = resultData[0];
    var nomes = chartData.category.split(',');

    var graph = [];
    var bullet = ["round", "square", "triangleUp"];
    var colors = ["#FF6600", "#FCD202", "#B0DE09"];

    _medias = get_minimax_ind(chartData);
    console.log(_medias);

    for (var i in nomes) {

        var idc = nomes[i];
        var v = "value" + (i);
        var vid = "v" + (i);
        var gid = "g" + (i);
        var customBullet = bullet[i];

        graph.push({
            "valueAxis": v,
            "lineColor": colors[i],
            "bullet": customBullet,
            "balloonText": idc + ": [[" + v + "]]",
            "bulletBorderThickness": 1,
            "hideBulletsCount": 30,
            "title": idc,
            "valueField": v,
            "fillAlphas": 0
        });

        set_minimax_layout(idc, post_id, i, colors, _medias, '');
    }


    var chart = AmCharts.makeChart('chart-' + post_id + '-' + graph_id, {
        "type": "serial",
        "theme": "light",
        "legend": {
            "useGraphSettings": true
        },
        "zoomOutText": "Tudo",
        "dataProvider": chartData,
        "graphs": graph,
        "chartScrollbar": {},
        "chartCursor": {
            "cursorPosition": "mouse",
            "categoryBalloonDateFormat": "DD MMM YYYY JJ:NN",
        },
        "categoryField": "date",
        "categoryAxis": {
            "parseDates": true,
            "minPeriod": "mm",
            "axisColor": "#DADADA",
            "minorGridEnabled": true
        },
        "export": {
            "enabled": true,
            "position": "bottom-right",
            "libs": {
                "path": "../../../public/themes/default/plugins/amcharts/plugins/export/libs/"
            },
            "menu": [{
                "class": "export-main",
                "label": "Export",
                "menu": [{
                    "label": "Download ...",
                    "menu": ["PNG", "JPG", "SVG", {
                        "format": "PDF",
                        "content": ["Saved from:", window.location.href, {
                            "image": "reference",
                            "fit": [523.28, 769.89] // fit image to A4
                        }]
                    }]
                }, {
                    "label": "Savar como ...",
                    "menu": ["CSV", "XLSX", "JSON"]
                }, {
                    "label": "Criar Anotação",
                    "action": "draw"
                }, {
                    "label": "Compartilhar",
                    "click": function () {
                        this.capture({}, function () {
                            this.toPNG({}, function (data) {
                                var graph = encodeURIComponent(data);
                                jQuery.post("/admin/share/save", {imageData: graph}, function (img) {
                                    jQuery('#modal-share').modal('show').find('img').attr('src', '/public/uploads/share/' + img);
                                    jQuery('#modal-share').find('input#img_shared').val(img);
                                    jQuery('#modal-share').find('.form-send').on('click', function () {
                                        var formdata = $(this).parent('div').parent('form').serialize();
                                        jQuery.post("/admin/share/share", formdata, function (response) {
                                            if (response) {
                                                jQuery('#modal-share').find('.modal-body').prepend('<div class="alert alert-dismissable alert-success">' +
                                                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
                                                    '<strong>Sucesso!</strong> Gráfico compartilhado.</div>');
                                            } else {
                                                jQuery('#modal-share').find('.modal-body').prepend('<div class="alert alert-dismissable alert-danger">' +
                                                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
                                                    '<strong>Erro!</strong> Não foi possível compartilhar o gráfico.</div>');
                                            }
                                        });
                                    });
                                });
                            });
                        });
                    }
                }, {
                    "format": "PRINT",
                    "label": "Imprimir"
                }]
            }],

            "drawing": {
                "menu": [{
                    "class": "export-drawing",
                    "menu": [{
                        "label": "Adicionar ...",
                        "menu": [{
                            "label": "Figura",
                            "action": "draw.shapes"
                        }, {
                            "label": "Texto",
                            "action": "text"
                        }]
                    }, {
                        "label": "Alterar ...",
                        "menu": [{
                            "label": "Modo ...",
                            "action": "draw.modes"
                        }, {
                            "label": "Cor ...",
                            "action": "draw.colors"
                        }, {
                            "label": "Tamanho ...",
                            "action": "draw.widths"
                        }, {
                            "label": "Opacidade ...",
                            "action": "draw.opacities"
                        }, "UNDO", "REDO"]
                    }, {
                        "label": "Download ...",
                        "menu": ["PNG", "JPG", "SVG", "PDF"]
                    }, "PRINT", "CANCEL"]
                }]
            }
        }
    });


    /*set up the chart to update every second*/
    setInterval(function () {
        chart.dataProvider.shift();

        // add new one at the end
        $.getJSON(Ajax.json_url + '/SensorLog/charts/?type=add&base=' + data_names + '&post_id=' + post_id, function (result) {

            if (result[0].count == 1) {
                chart.dataProvider.push({
                    date: result[0].date,
                    value0: result[0].value0
                });
            }
            if (result[0].count == 2) {
                chart.dataProvider.push({
                    date: result[0].date,
                    value0: result[0].value0,
                    value1: result[0].value1
                });
            }
            if (result[0].count == 3) {
                chart.dataProvider.push({
                    date: result[0].date,
                    value0: result[0].value0,
                    value1: result[0].value1,
                    value2: result[0].value2
                });
            }

            chart.validateData();
        });

    }, 60000);


});
