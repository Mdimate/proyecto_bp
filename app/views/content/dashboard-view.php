<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/index.css">
    <style>
        canvas {
            max-width: 100%; /* Asegura que se ajusten al contenedor */
            margin: 20px auto; /* Centra las gráficas y añade espacio entre ellas */
            display: block; /* Hace que el canvas se comporte como un bloque */
        }
        .bienvenido {
            color: green; /* Cambia el color a verde */
            font-size: 2rem; /* Aumenta el tamaño de la fuente */
            text-align: center; /* Centra el texto */
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0"></script>
</head>
<body>

<div class="columns is-flex is-justify-content-center" style="padding-top: 20px;">
    <h2 class="subtitle bienvenido">¡Bienvenido!</h2>
</div>

<!-- Gráfica: Top 5 Aplicaciones Próximas a Vencer -->
<h3 class="title is-4" style="text-align: center;">Top 5 Aplicaciones Próximas a Vencer</h3>
<canvas id="top5Aplicaciones" width="300" height="150"></canvas>

<!-- Gráfica: Certificados Próximos a Vencer -->
<h3 class="title is-4" style="text-align: center;">Certificados Próximos a Vencer</h3>
<canvas id="certificadosProximos" width="300" height="150"></canvas>

<!-- Gráfica: Top 5 Áreas con Certificados Próximos a Vencer -->
<h3 class="title is-4" style="text-align: center;">Top 5 Áreas con Certificados Próximos a Vencer</h3>
<canvas id="top5Areas" width="300" height="150"></canvas>

<!-- Contador de gestiones pendientes -->
<p id="pendientesCount" style="text-align: center;"></p>

<script>
$(document).ready(function() {
    // Función para obtener datos del dashboard
    function obtenerDatosDashboard() {
        $.ajax({
            url: '<?php echo APP_URL; ?>app/ajax/vencimientoAjax.php',
            type: 'POST',
            data: { action: 'obtenerDatosDashboard' },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                crearGraficas(response);
            },
            error: function(xhr, status, error) {
                console.error('Error en la llamada AJAX:', error);
            }
        });
    }

    // Llamar a la función al cargar la página
    obtenerDatosDashboard();

    // Función para crear las gráficas
    function crearGraficas(data) {
        // Gráfica 1: Top 5 Aplicaciones Próximas a Vencer
        const aplicacionesCtx = document.getElementById('top5Aplicaciones').getContext('2d');
        const aplicacionesLabels = data.top5_aplicaciones ? data.top5_aplicaciones.map(app => app.aplicacion) : [];
        const aplicacionesData = data.top5_aplicaciones ? data.top5_aplicaciones.map(app => app.fecha_vencimiento) : [];

        new Chart(aplicacionesCtx, {
            type: 'bar',
            data: {
                labels: aplicacionesLabels,
                datasets: [{
                    label: 'Próximas a Vencer',
                    data: aplicacionesData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        type: 'category'
                    }
                }
            }
        });

        // Gráfica 2: Certificados Próximos a Vencer (Gráfico de Barras)
        const certificadosCtx = document.getElementById('certificadosProximos').getContext('2d');
        const certificadosLabels = data.certificados_proximos ? data.certificados_proximos.map(cert => cert.nombre) : [];
        const certificadosData = data.certificados_proximos ? data.certificados_proximos.map(cert => cert.dias_restantes) : []; // Cambia 'valor' por 'dias_restantes'

        new Chart(certificadosCtx, {
            type: 'bar',
            data: {
                labels: certificadosLabels,
                datasets: [{
                    label: 'Días Restantes para Vencer',
                    data: certificadosData,
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Días Restantes'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Certificados'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });

        // Gráfica 3: Top 5 Áreas con Certificados Próximos a Vencer
        const areasCtx = document.getElementById('top5Areas').getContext('2d');
        const areasLabels = data.top5_areas ? data.top5_areas.map(area => area.area_responsable) : [];
        const areasData = data.top5_areas ? data.top5_areas.map(area => area.total) : [];

        new Chart(areasCtx, {
            type: 'pie',
            data: {
                labels: areasLabels,
                datasets: [{
                    label: 'Áreas con Certificados Próximos',
                    data: areasData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });

        // Contador de gestiones pendientes de correos
        $('#pendientesCount').text(`Correos pendientes por enviar: ${data.total_pendientes}`);
    }
});
</script>
</body>
</html>
