/*
 ** Get min/max/med from sensor
 */

/*
 ** Helper function to find the table body out of the layout
 */
function findThatBody(obj) {
    var found = false;
    for (key in obj) {
        if (obj[key] instanceof Array) {
            if (found = findThatBody(obj[key])) {
                return found;
            }
        } else if (obj[key] instanceof Object) {
            if (obj[key].table) {
                return obj[key];
            } else {
                if (found = findThatBody(obj[key])) {
                    return found;
                }
            }
        }
    }
    return found;
}

function createReport($report_local, callback) {
    var pdf_layout = layout_relatorio($report_local); // global reference from layouts/layout_1.js

    console.log($report_local.amchart.export);
    // Capture the current state of the chart
    $report_local.amchart.export.capture({}, function () {
        // Export to PNG
        this.toPNG({
            multiplier: 2
            // Add image to the layout reference
        }, function (data) {

            pdf_layout.images["image_1"] = data;

            // Once all has been processed create the PDF
            // Build the table dynamically
            rows = new Array();
            i_row = 0;
            rows[i_row] = [
                {text: 'Indicador(es)', bold: true, fontSize: 12},
                {text: 'Mínimo', bold: true, fontSize: 12},
                {text: 'Máximo', bold: true, fontSize: 12},
                {text: 'Média', bold: true, fontSize: 12},
                {text: 'Acumulado', bold: true, fontSize: 12}];

            medias = $report_local.report['medias'];
            colors = $report_local.report['colors'];

            var DateFormat = 'dd MMM yyyy HH:mm';
            switch ($report_local.report['tipo'].toLowerCase()) {
                case 'semanalmente':
                    DateFormat = 'ddd';
                    break;
                case 'mensalmente':
                    DateFormat = 'dd MMM yyyy';
                    break;
            }
            $.each(medias, function (i, value) {
                console.log(value);
                i_row++;

                if (value.indice == 'ipa') {
                    rows[i_row] = [
                        {text: value.base + ' (' + value.escala + ')', fontSize: 11, bold: true, color: colors[i]},
                        {text: value.min + ' (' + $.format.date(value.data_min, DateFormat) + ')', fontSize: 10},
                        {text: value.max + ' (' + $.format.date(value.data_max, DateFormat) + ')', fontSize: 10},
                        {text: value.med.toString(), fontSize: 10},
                        {text: value.acum.toString() + ' (' + value.acum_p.toString() + '%)', fontSize: 10}
                    ];
                } else {
                    rows[i_row] = [
                        {text: value.base + ' (' + value.escala + ')', fontSize: 11, bold: true, color: colors[i]},
                        {text: value.min + ' (' + $.format.date(value.data_min, DateFormat) + ')', fontSize: 10},
                        {text: value.max + ' (' + $.format.date(value.data_max, DateFormat) + ')', fontSize: 10},
                        {text: value.med.toString(), fontSize: 10},
                        {text: '-', fontSize: 10}
                    ];
                }

            });

            x = 1;
            findThatBody(pdf_layout).table.body = rows;

            console.log(pdf_layout);
            // Save as single PDF and offer as download
            this.toPDF(pdf_layout, function (data) {
                this.download(data, this.defaults.formats.PDF.mimeType, $report_local.report['filename']);
                if (callback != "") window[callback]();
                return true;
            });
        });
    });
}