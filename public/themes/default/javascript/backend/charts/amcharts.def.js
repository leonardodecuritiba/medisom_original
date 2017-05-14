function get_minimax_ind(valores) {
    // Fazer a média logaritmica
    //valores = [50.00,49.16,55.08,50.27,50.88,49.24,49.86,50.53,50.88,55.12];

    n = valores[0].count;
    tam = valores.length;
    _media = [];
    var nomes = valores[0].category.split(',');
    var range_indicadores = [];
    range_indicadores['ipa'] = {
        min: 0,
        max: 100
    };
    range_indicadores['time_leq'] = {
        min: 0,
        max: 30
    };
    range_indicadores['default'] = {
        min: 30,
        max: 130
    };
    range_indicadores['temp'] = {
        min: 0,
        max: 50
    };
    range_indicadores['ilum'] = {
        min: 0,
        max: 65000
    };
    range_indicadores['umid'] = {
        min: 0,
        max: 100
    };


    for (i = 0; i < n; i++) {

        cont = 0;
        sum = 0;
        sum_pond = 0;


        _indicador = nomes[i].toLowerCase();

        if (_indicador == 'ipa' || _indicador == 'time_leq' || _indicador == 'temp' || _indicador == 'ilum' || _indicador == 'umid') {
            min = range_indicadores[_indicador].min;
            max = range_indicadores[_indicador].max;
        } else {
            min = range_indicadores['default'].min;
            max = range_indicadores['default'].max;
        }

        var iv = 0;
        console.log(iv + 'value' + i + '=' + valores[iv]['value' + i]);
        while (iv < tam
        &&
        (
            !$.isNumeric(valores[iv]['value' + i])
            || (valores[iv]['value' + i] < min)
            || (valores[iv]['value' + i] == null)
        )
            ) {
            console.log(iv + 'value' + i + '=' + valores[iv]['value' + i]);
            iv++;
        }

        if (iv < tam) { //isso quer dizer que todo o vetor foi percorrido e não foi encontrado nenhum valor
            _media[i] = {};
            _media[i].nome = _indicador;
            _media[i].max = parseFloat(valores[iv]['value' + i]); // Recebe primeiro valor
            _media[i].min = parseFloat(valores[iv]['value' + i]); // Recebe primeiro valor
            _media[i].max_data = valores[iv]['date']; // Recebe primeira data
            _media[i].min_data = valores[iv]['date']; // Recebe primeira data

            // console.log('--------NOVO----------');
            $.each(valores, function () {
                //_value = this;
                _value = parseFloat(this['value' + i]);

                // console.log(_value);
                if (!isNaN(_value)) {
                    // console.log(_indicador + ":" + _value);
                    if ((_value > min) && (_value < max)) {
                        if (_value < _media[i].min) {
                            _media[i].min = _value;
                            _media[i].min_data = this['date'];
                        }
                        if (_value > _media[i].max) {
                            _media[i].max = _value;
                            _media[i].max_data = this['date'];
                        }
                        sum += Math.pow(10, (_value / 10));
                        sum_pond += _value;
                        cont++;
                    }
                }
            });
            if (!isNaN(sum)) {
                _media[i].mpond = (sum_pond / cont).toFixed(1);
                _media[i].mlog = (10 * Math.log(sum / cont) / Math.log(10)).toFixed(1);
            }
        } else {

            _media[i] = {};
            _media[i].nome = _indicador;
            _media[i].max = '-'; // Recebe primeiro valor
            _media[i].min = '-'; // Recebe primeiro valor
            _media[i].max_data = '-'; // Recebe primeira data
            _media[i].min_data = '-'; // Recebe primeira data
            _media[i].mpond = '-';
            _media[i].mlog = '-';
        }


        // console.log(_media);
    }
    return _media;
}

function update_chart_response($CHART, data_names, post_id) {
    console.log('update_chart_response()');
    $CHART.dataProvider.shift();
    // add new one at the end

    console.log(Ajax.json_url + '/SensorLog/charts/?type=add&base=' + data_names + '&post_id=' + post_id);
    $.getJSON(Ajax.json_url + '/SensorLog/charts/?type=add&base=' + data_names + '&post_id=' + post_id, function (result) {

        resultData = result.response[0];
        console.log(resultData);
        /*
         if (resultData.count > 0){
         for(i = 0; i < resultData.count; i ++){
         }
         }
         */
        if (resultData.count == 1) {
            $CHART.dataProvider.push({
                date: resultData.date,
                value0: resultData.value0
            });
        }
        if (resultData.count == 2) {
            $CHART.dataProvider.push({
                date: resultData.date,
                value0: resultData.value0,
                value1: resultData.value1
            });
        }
        if (resultData.count == 3) {
            $CHART.dataProvider.push({
                date: resultData.date,
                value0: resultData.value0,
                value1: resultData.value1,
                value2: resultData.value2
            });
        }

        $CHART.validateData();
    });
}

function generate_amchart($div_chart, resultData, post_id) {

    var chartData = resultData;
    var indices = chartData[0].category.split(',');
    var display_name = chartData[0].display_name.split(',');
    var bullet = ["round", "square", "triangleUp"];
    var colors = ["#FF6600", "#FCD202", "#B0DE09"];
    var graph = [];

    _medias = get_minimax_ind(chartData);
    for (var i in indices) {

        var v = "value" + (i);
        // var vid = "v" + (i);
        // var gid = "g" + (i);
        var customBullet = bullet[i];

        graph.push({
            "valueField": v,
            "balloonText": display_name[i] + ": [[" + v + "]]",
            "lineColor": colors[i],
            "bullet": customBullet,
            "bulletBorderColor": "#FFFFFF",
            "bulletBorderThickness": 2,
            "hideBulletsCount": 30,
            "lineThickness": 2,
            "lineAlpha": 0.5,
            "valueAxis": v,
            "title": display_name[i],
            "fillAlphas": 0
        });
        set_minimax_layout(indices[i], post_id, i, colors, _medias, display_name[i]);
    }
    var $CHART = AmCharts.makeChart($div_chart, {
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

    return $CHART;
}

function create_amchart($o, e) {
    //e: element selector
    //o: object contain chart definitions
    //o.dataProvider: data
    //o.graphs: graphs
    //o.graphType
    var categoryAxis_ = [];
    if ($o.graphType == 'line') {
        categoryAxis_ = {"parseDates": true, "minPeriod": "mm", "axisColor": "#DADADA", "minorGridEnabled": true};
    } else if ($o.graphType == 'bar') {
        //categoryAxis_.push({"gridPosition": "start"});
        categoryAxis_ = {"parseDates": true, "gridPosition": "start", "axisColor": "#DADADA"};
    } else {
        categoryAxis_ = {"gridPosition": "start"};
    }
    return AmCharts.makeChart(e, {
        "type": "serial",
        "theme": "light",
        "dataProvider": $o.dataProvider,
        "valueAxes": [{
            "position": "left",
            "title": "Decibéis"
        }],
        "graphs": $o.graphs,
        "plotAreaFillAlphas": 0.1,
        "categoryField": "date",
        "categoryAxis": categoryAxis_,
        "legend": {
            "useGraphSettings": true
        },
        "zoomOutText": "Tudo",
        "chartScrollbar": {},
        "chartCursor": {
            "cursorPosition": "mouse",
            "categoryBalloonDateFormat": "DD MMM YYYY JJ:NN",
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
}

function create_amchart_report_custom($o, e) {
    //e: element selector
    //o: object contain chart definitions
    //o.dataProvider: data
    //o.graphs: graphs
    return AmCharts.makeChart(e, {
        "type": "serial",
        "theme": "light",
        "dataProvider": $o.dataProvider,//[{"date":"21-02-2016","laeq":50.93,"lceq":40.00},{"date":"22-02-2016","laeq":57.03,"lceq":40.00},{"date":"23-02-2016","laeq":56.50,"lceq":40.00},{"date":"24-02-2016","laeq":57.26,"lceq":40.00},{"date":"25-02-2016","laeq":55.31,"lceq":40.00},{"date":"26-02-2016","laeq":56.33,"lceq":40.00},{"date":"27-02-2016","laeq":53.73,"lceq":40.00}],
        "valueAxes": [{
            "position": "left",
            "title": "Decibéis",
        }],
        "startDuration": 1,
        "graphs": $o.graphs,
        /* [{
         "balloonText": "LAeq: [[value]]",
         "fillAlphas": 0.8,
         "id": "laeq",
         "lineAlpha": 0.2,
         "title": "LAeq",
         "type": "column",
         "valueField": "laeq"
         },{
         "balloonText": "LCeq: [[value]]",
         "fillAlphas": 0.8,
         "id": "lceq",
         "lineAlpha": 0.2,
         "title": "LCeq",
         "type": "column",
         "valueField": "lceq"
         }],*/
        "plotAreaFillAlphas": 0.1,
        "categoryField": "date",
        "categoryAxis": {
            "gridPosition": "start"
        },
        "legend": {
            "useGraphSettings": true
        },
        "zoomOutText": "Tudo",
        "chartScrollbar": {},
        "chartCursor": {
            "cursorPosition": "mouse",
            "categoryBalloonDateFormat": "DD MMM YYYY JJ:NN",
        },
        "export": {
            "enabled": true,
            "position": "top-right",
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


}

function create_amchart_print_report($o, e) {
    //e: element selector
    //o: object contain chart definitions
    //o.dataProvider: data
    //o.graphs: graphs
    //o.graphType
    var categoryAxis_ = [];
    if ($o.graphType == 'line') {
        categoryAxis_ = {"parseDates": true, "minPeriod": "mm", "axisColor": "#DADADA", "minorGridEnabled": true};
    } else if ($o.graphType == 'bar') {
        //categoryAxis_.push({"gridPosition": "start"});
        categoryAxis_ = {"parseDates": true, "gridPosition": "start", "axisColor": "#DADADA"};
    } else {
        categoryAxis_ = {"gridPosition": "start"};
    }
    return AmCharts.makeChart(e, {
        "type": "serial",
        "theme": "light",
        "dataProvider": $o.dataProvider,
        "valueAxes": [{
            "position": "left",
            "title": "Decibéis"
        }],
        "graphs": $o.graphs,
        "plotAreaFillAlphas": 0.1,
        "categoryField": "date",
        "categoryAxis": categoryAxis_,
        "legend": {
            "useGraphSettings": true
        },
        "zoomOutText": "Tudo",
        "chartScrollbar": {},
        "chartCursor": {
            "cursorPosition": "mouse",
            "categoryBalloonDateFormat": "DD MMM YYYY JJ:NN",
        },
        "export": {
            "enabled": true,
            "libs": {
                "path": "//amcharts.com/lib/3/plugins/export/libs/"
            },
            "menu": [] //
        }
    });
}