<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Préstamo</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="container my-5">
    <div class="row">
        <?php
        include("../conexion/conexion.php");
        $codi = isset($_GET['codigo']) ? $_GET['codigo'] : null;  // Cambiar según cómo recibes el código

        if ($codi) {
            $sql = "SELECT p.*, c.nombres, c.apellidos
                FROM prestamos p
                INNER JOIN clientes c ON p.dni = c.dni
                WHERE p.codigo = ?";
            $stmt = $cnn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("i", $codi);  // Usar 'i' para números, 's' para cadenas
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // 5. Mostrar la información del préstamo en detalle
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-12">';
                        echo '<div class="card shadow-sm">';
                        echo '<div class="card-header bg-primary text-white text-center">';
                        echo '<h4 class="card-title">Detalle del Préstamo - Código: ' . $row['codigo'] . '</h4>';
                        echo '</div>';
                        echo '<div class="card-body">';
                        echo '<div class="row">';

                        // Columna de la izquierda (datos principales)
                        echo '<div class="col-md-6">';
                        echo '<h5 class="card-title">Información Principal</h5>';
                        echo '<ul class="list-group list-group-flush">';
                        echo '<li class="list-group-item"><strong>DNI del solicitante:</strong> ' . $row['dni'] . '</li>';
                        echo '<li class="list-group-item"><strong>Cliente: </strong> ' . $row['nombres']." ".$row['apellidos'] . '</li>';
                        echo '<li class="list-group-item"><strong>Cantidad a prestar:</strong> S/. ' . number_format($row['cantidad_prestar'], 2) . '</li>';
                        echo '</ul>';
                        echo '</div>';

                        // Columna de la derecha (detalles adicionales)
                        echo '<div class="col-md-6">';
                        echo '<h5 class="card-title">Detalles del Préstamo</h5>';
                        echo '<ul class="list-group list-group-flush">';
                        echo '<li class="list-group-item"><strong>Cuotas:</strong> ' . $row['cuotas'] . ' cuotas</li>';
                        echo '<li class="list-group-item"><strong>Interés:</strong> ' . $row['interes'] . '%</li>';
                        echo '<li class="list-group-item"><strong>Fecha del préstamo:</strong> ' . date("Y/m/d", strtotime($row['fecha'])) . '</li>';
                        echo '</ul>';
                        echo '</div>';
                        echo '</div>';

                        // Tabla de cuotas dentro del mismo detalle del préstamo
                        echo '<div class="mt-4">';
                        echo '<h5>Detalles de las Cuotas</h5>';
                        echo '<table class="table table-bordered">';
                        echo '<thead><tr><th>N°</th><th>Fecha de Pago</th><th>Monto a Pagar</th><th>Estado</th><th>Acción</th></tr></thead>';
                        echo '<tbody>';

                        $cantidad_prestar = $row['cantidad_prestar'];
                        $cuotas = $row['cuotas'];
                        $interes = $row['interes'];
                        $monto_por_cuota =  (float) str_replace(',', '.', $row['pago_mensual']);

                        $fecha_pago = strtotime($row['fecha']);
                        $frecuencia = $row['tipo'];  // Suponiendo que la frecuencia se almacena en la base de datos

                        for ($i = 1; $i <= $cuotas; $i++) {
                            // Calcular la fecha de pago según la frecuencia
                            switch ($frecuencia) {
                                case 'diario':
                                    $fecha_pago = strtotime("+1 day", $fecha_pago);
                                    break;
                                case 'semanal':
                                    $fecha_pago = strtotime("+1 week", $fecha_pago);
                                    break;
                                case 'mensual':
                                    $fecha_pago = strtotime("+1 month", $fecha_pago);
                                    break;
                            }

                            $fecha_pago_formateada = date("Y/m/d", $fecha_pago);

                            // Obtener la fecha de hoy sin la hora
                            $fecha_hoy = strtotime("today");

                            // Comparar la fecha de pago con la fecha de hoy
                            if ($fecha_pago < $fecha_hoy) {
                                // Si la fecha de pago es anterior a hoy, el estado será "Vencido"
                                $estado = 'Vencido';
                                $estado_clase = 'bg-danger';  // Clase CSS para fondo rojo
                            } else {
                                $estado = 'Pendiente';
                                $estado_clase = 'bg-primary';  // Clase CSS para fondo celeste
                            }

                            echo '<tr>';
                            echo '<td>' . $i . '</td>';
                            echo '<td>' . $fecha_pago_formateada . '</td>';
                            echo '<td>S/. ' . number_format($monto_por_cuota, 2) . '</td>';
                            echo '<td class="' . $estado_clase . ' text-white">' . $estado . '</td>';
                            echo '<td><button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#pagoModal" onclick="setPagoDetails(' . $row['codigo'] . ', \'' . $fecha_pago_formateada . '\', \'' . $estado . '\', ' . $monto_por_cuota . ')">Pagar Cuota</button></td>';
                            echo '</tr>';
                        }

                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';

                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-12">';
                    echo '<div class="alert alert-warning" role="alert">';
                    echo 'No se encontró información para el código de préstamo: ' . $codi;
                    echo '</div>';
                    echo '</div>';
                }

                $stmt->close();
            } else {
                echo '<div class="col-12">';
                echo '<div class="alert alert-danger" role="alert">';
                echo 'Error al preparar la consulta: ' . $cnn->error;
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="col-12">';
            echo '<div class="alert alert-info" role="alert">';
            echo 'Por favor, proporcione un código de préstamo válido.';
            echo '</div>';
            echo '</div>';
        }
        $cnn->close();
        ?>
    </div>
</div>

<!-- Modal para registrar el pago -->
<div class="modal fade" id="pagoModal" tabindex="-1" aria-labelledby="pagoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pagoModalLabel">Registrar Pago de Cuota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="procesos/agregar_cuota.php" method="POST" name="frcu" id="frcu"> 
                    <input type="hidden" id="codigoPrestamo" name="codigo" value="">
                    <div class="mb-3">
                        <label for="fechaPago" class="form-label">Fecha de Pago</label>
                        <input type="text" class="form-control" id="fechaPago" name="fecha_pago" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Pagado">Pagado</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cantidadPagada" class="form-label">Numero de cuota</label>
                        <input type="number" class="form-control" id="numerocuota" name="numero_cuota" required>
                    </div>
                    <div class="mb-3">
                        <label for="cantidadPagada" class="form-label">Cantidad Pagada</label>
                        <input type="number" class="form-control" id="cantidadPagada" name="cantidad_pagada" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Registrar Pago</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Link to Bootstrap JS and dependencies (Popper and Bootstrap Bundle) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>



<script>
    // Función para establecer los detalles del pago en el modal
    function setPagoDetails(codigo, fecha, estado, monto) {
        let hoy = new Date();
        let fecha1 = hoy.toISOString().split('T')[0];  // Formato YYYY-MM-DD

        // Establecer los valores en el modal
        document.getElementById('codigoPrestamo').value = codigo;
        document.getElementById('fechaPago').value = fecha1;  // Mostrar la fecha de hoy
        document.getElementById('estado').value = estado;
        document.getElementById('cantidadPagada').value = monto;
    }
</script>
</body>
</html>

