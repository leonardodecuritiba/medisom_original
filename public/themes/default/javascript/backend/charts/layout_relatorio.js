//$REPORT_GLOBAL deve estar definido previamente
function layout_relatorio($REPORT_GLOBAL) {
    return {
        pageSize: 'A4',
        pageOrientation: 'landscape',
        pageMargins: [40, 60, 40, 40],
        header: {
            columns: [
                {
                    image: 'logo',
                    width: parseInt($REPORT_GLOBAL.report['logo_medisom']['size'][0]),
                    heigth: parseInt($REPORT_GLOBAL.report['logo_medisom']['size'][1]),
                    alignment: 'left',
                    margin: [40, 10, 0, 0]
                },
                {
                    text: $REPORT_GLOBAL.header,
                    fontSize: 10,
                    margin: [50, 15, 0, 0]
                }, {
                    image: 'logo_cliente',
                    width: parseInt($REPORT_GLOBAL.report['logo_cliente']['size'][0]),
                    heigth: parseInt($REPORT_GLOBAL.report['logo_cliente']['size'][1]),
                    margin: [10, 10, 0, 0],
                    alignment: 'right'
                }
            ]
        },
        content: [
            {text: $REPORT_GLOBAL.title, style: ["header", "safetyDistance"]},
            {
                columnGap: 10, columns: [{
                stack: [{
                    text: "Nome do relatório (ID)",
                    style: "subheader"
                }, {
                    text: $REPORT_GLOBAL.report['nome'] + ' (' + $REPORT_GLOBAL.report['id'] + ')',
                    style: "description"
                }]
            },
                {
                stack: [{
                    text: "Sensor",
                    style: "subheader"
                }, {
                    text: $REPORT_GLOBAL.report['sensor_nome'],
                    style: "description"
                }]
            },
                {
                stack: [{
                    text: "Criado Por",
                    style: "subheader"
                }, {
                    text: $REPORT_GLOBAL.report['author'],
                    style: "description"
                }]
            }
            ], style: "safetyDistance"
            },
            {
                columnGap: 10, columns: [{
                stack: [{
                    text: "Tipo",
                    style: "subheader"
                }, {
                    text: $REPORT_GLOBAL.report['tipo'],
                    style: "description"
                }]
            }, {
                stack: [{
                    text: "Período",
                    style: "subheader"
                }, {
                    text: $REPORT_GLOBAL.report['periodo'],
                    style: "description"
                }]
            }, {
                stack: [{
                    text: "Intervalo",
                    style: "subheader"
                }, {
                    text: $REPORT_GLOBAL.report['intervalo'],
                    style: "description"
                }]
            }
            ], style: "safetyDistance"
            },
            {
                columnGap: 10, columns: [
                {
                    table: {
                        headerRows: 1,
                        widths: [250, 150, 150, 75, 75],
                        body: []
                    }, layout: 'lightHorizontalLines'
                }
            ], style: "safetyDistance"
            },

            {
                image: "image_1",
                width: 750,
                style: "safetyDistance"
            }
        ],
        footer: function (currentPage, totalPage) {
            return {
                text: [currentPage, "/", totalPage].join(""),
                alignment: "center"
            }
        },
        styles: {
            header: {
                fontSize: 18,
                bold: true
            },
            subheader: {
                bold: true
            },
            description: {
                fontSize: 10,
                color: "#555555",
                margin: [0, 5, 0, 0]
            },
            safetyDistance: {
                margin: [0, 0, 0, 10]
            }
        },
        images: {
            logo: $REPORT_GLOBAL.report['logo_medisom']['url'],
            logo_cliente: $REPORT_GLOBAL.report['logo_cliente']['url']
        }
    };
}