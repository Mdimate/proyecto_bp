<head>
<link rel="stylesheet" type="text/css" href="<?php echo APP_URL; ?>app/views/css/vencimiento.css">
</head>
<body>
    <main>
        <h1>Certificados proximos a vencer</h1>
        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped" id="tabla">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Fecha de Vencimiento</th>
                            <th scope="col">Grupo de vencimiento</th>
                            <th scope="col">Correo alertamiento</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th> <!-- Índice automático -->
                            <td>Ejemplo 1</td> <!-- Nombre -->
                            <td>2024-08-14</td> <!-- Fecha de vencimiento -->
                            <td>Grupo 1</td> <!-- Grupo de vencimiento -->
                            <td>ejemplo1@correo.com</td> <!-- Correo de alertamiento -->
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Editar</a>
                                <a href="#" class="btn btn-sm btn-danger">Eliminar</a>
                            </td>
                        </tr>
                        <!-- Puedes añadir más filas según necesites -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script src="<?php echo APP_URL; ?>app/views/css/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>
</html>