<?php
session_start();
$page = 'reportes';
if (isset($_SESSION["current_email"]) && $_SESSION["current_email"] != '') {

} else {
    echo "Usuario no Autorizado";
    exit();
}

if ($_SESSION['current_rol'] == 'admin') {

} else {
    echo "No tienes Permisos para acceder a este lugar";
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>.:Reportes:.</title>
    <?php include 'layout/library.php' ?>
    <script src="library/js/apexcharts.js"></script>
    <script src="library/js/download.js"></script>
    <style>
        .m-0 {
            margin: 0 !important;

        }

        .p-0 {
            padding: 0 !important;
        }
    </style>
</head>
<body class="">
<?php include 'layout/userNavBar.php' ?>
<div class="container">
    <div class="row" style="margin-top: 15px">
        <div class="col s12">
            <h5 class="center-align">Reportes</h5>

        </div>
    </div>
    <div class="row" style="margin-top: 15px">
        <div class="col s12 m12 l6 p-0 m-0">
            <div class="card-panel teal grey">
                <h6>Ventas el ultimo año</h6>
                <div id="chart"></div>
                <div class="center-align">
                    <div style="margin-bottom: 5px">

                        <small class="black-text" style="display: block">Selecciona un mes</small>
                        <input class="center-align" type="month" id="monthSelector" name="start"
                               min="2020-02" max="<?= date('Y-m'); ?>">
                    </div>
                    <button id="btnExportarPrimerReporte"
                            class="btn btn-flat white-text black waves-effect waves-light">Exportar detalle <i
                                class="material-icons right">
                            cloud_download
                        </i>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
<?php include 'layout/userFooter.php' ?>
<script>
    const D = document;
    const monthSelectorElement = D.getElementById('monthSelector');
    const btnExportarPrimerReporte = D.getElementById('btnExportarPrimerReporte');

    document.addEventListener('DOMContentLoaded', async () => {
        await construirPrimerReporte();

    });
    btnExportarPrimerReporte.addEventListener('click', () => {
        if (!monthSelectorElement.value) {
            alert('Elije un mes');
            return false;
        }
        descargarPrimerExcel(monthSelectorElement.value);


    });


    /*primer reporte*/
    async function construirPrimerReporte() {
        const report1Data = await fetchPrimerReporte();
        let options = {
            series: [{
                name: 'Total ventas',
                data: []
            }],
            chart: {
                foreColor: '#000000',
                height: 350,
                type: 'bar',
                events: {
                    click: function (chart, w, e) {
                        // console.log(chart, w, e)
                    }
                },
                toolbar: {
                    tools: {
                        download: '<i class="material-icons" style="color: black">\n' +
                            'menu\n' +
                            '</i>',
                    }
                }
            },
            plotOptions: {
                bar: {
                    distributed: true
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            xaxis: {
                categories: [],
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            }
        };

        report1Data.forEach(item => {
            options.series[0].data.push(item.montoVentas * 1);
            options.xaxis.categories.push(item.mes);

        });

        let chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    }
    async function fetchPrimerReporte() {
        return fetch('script/reportes/ventasUltimos6Meses.php')
            .then(value => {
                if (value.ok) {
                    return value.json();
                } else {
                    throw Error('Servicio no disponibles')
                }
            }).then(value => value)
    }

    /*end primer reporte*/


    function descargarPrimerExcel(monthAndYear) {

        const body = new FormData();
        body.append('monthAndYear', monthAndYear);

        fetch('excel/totalVentasPorMes.php', {method: 'POST', body}).then(value => {
            if (value.ok) {
                return value.blob();
            } else {
                throw  new Error('Servicio no disponible');
            }
        }).then(value => {
            download(value, `reporte-${monthAndYear}`);
        })
    }
</script>
</body>
</html>
