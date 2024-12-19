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
// Paso 1: Conexión a la base de datos
include("../conexion/conexion.php"); // Asegúrate de que este archivo establece la conexión en la variable $cnn

// Paso 2: Obtener y sanitizar el código
$codi = isset($_GET['codigo']) ? $_GET['codigo'] : null;

if ($codi) {
    // Preparar la consulta para obtener los detalles del préstamo
    $sql = "SELECT p.*, c.nombres, c.apellidos
            FROM prestamos p
            INNER JOIN clientes c ON p.dni = c.dni
            WHERE p.codigo = ?";
    $stmt = $cnn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $codi);  // Usar 'i' para números
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Obtener los datos del préstamo
            while ($row = $result->fetch_assoc()) {
                // Obtener todas las cuotas pagadas para este préstamo
                $sqlCuotasPagadas = "SELECT numero_cuota FROM detalle_prestamos WHERE codigo = ? AND estado = 'Pagado'";
                $stmtCuotasPagadas = $cnn->prepare($sqlCuotasPagadas);
                $stmtCuotasPagadas->bind_param("i", $codi);
                $stmtCuotasPagadas->execute();
                $resultCuotasPagadas = $stmtCuotasPagadas->get_result();
                
                $cuotasPagadasArray = [];
                while ($cuota = $resultCuotasPagadas->fetch_assoc()) {
                    $cuotasPagadasArray[] = $cuota['numero_cuota'];
                }
                $cuotasPagadas = count($cuotasPagadasArray);

                echo '<div class="col-12">';
                echo '<div class="card shadow-sm">';
                echo '<div class="card-header bg-primary text-white text-center">';
                echo '<h4 class="card-title">Detalle del Préstamo - Código: ' . htmlspecialchars($row['codigo']) . '</h4>';
                echo '</div>';
                echo '<div class="card-body">';
                echo '<div class="row">';

                // Columna de la izquierda (datos principales)
                echo '<div class="col-md-6">';
                echo '<h5 class="card-title">Información Principal</h5>';
                echo '<ul class="list-group list-group-flush">';
                echo '<li class="list-group-item"><strong>DNI del solicitante:</strong> ' . htmlspecialchars($row['dni']) . '</li>';
                echo '<li class="list-group-item"><strong>Cliente: </strong> ' . htmlspecialchars($row['nombres'] . " " . $row['apellidos']) . '</li>';
                echo '<li class="list-group-item"><strong>Cantidad Prestada:</strong> S/. ' . number_format($row['cantidad_prestar'], 2) . '</li>';
                echo '<li class="list-group-item"><strong>Nº Total de Cuotas:</strong> ' . intval($row['cuotas']) . ' cuotas</li>';
                echo '</ul>';
                echo '</div>';

                // Columna de la derecha (detalles adicionales)
                echo '<div class="col-md-6">';
                echo '<h5 class="card-title">Detalles del Préstamo</h5>';
                echo '<ul class="list-group list-group-flush">';
                echo '<li class="list-group-item"><strong>Nº Cuotas Pagadas:</strong> ' . intval($cuotasPagadas) . ' cuotas</li>';
                echo '<li class="list-group-item"><strong>Nº Cuotas Pendientes :</strong> ' . (intval($row['cuotas']) - intval($cuotasPagadas)) . ' cuotas</li>';
                echo '<li class="list-group-item"><strong>Interés:</strong> ' . htmlspecialchars($row['interes']) . '%</li>';
                echo '<li class="list-group-item"><strong>Fecha del préstamo:</strong> ' . htmlspecialchars(date("Y/m/d", strtotime($row['fecha']))) . '</li>';
                echo '</ul>';
                echo '</div>';
                echo '</div>';

                // Tabla de cuotas dentro del mismo detalle del préstamo
                echo '<div class="mt-4">';
                echo '<h5>Detalles de las Cuotas</h5>';
                echo '<table class="table table-bordered">';
                echo '<thead><tr><th>N°</th><th>Fecha de Pago</th><th>Monto a Pagar</th><th>Estado</th><th>Acción</th></tr></thead>';
                echo '<tbody>';

                $cantidad_prestar = floatval($row['cantidad_prestar']);
                $cuotas = intval($row['cuotas']);
                $interes = floatval($row['interes']);
                $monto_por_cuota = floatval(str_replace(',', '.', $row['pago_mensual']));

                $fecha_pago_inicial = strtotime($row['fecha']);
                $frecuencia = strtolower($row['tipo']);  // Convertir a minúsculas para consistencia

                // Preparar una consulta para obtener el estado de cada cuota
                $sqlDetalle = "SELECT numero_cuota, estado FROM detalle_prestamos WHERE codigo = ?";
                $stmtDetalle = $cnn->prepare($sqlDetalle);
                $stmtDetalle->bind_param("i", $codi);
                $stmtDetalle->execute();
                $resultDetalle = $stmtDetalle->get_result();

                $detallePrestamos = [];
                while ($detalle = $resultDetalle->fetch_assoc()) {
                    $detallePrestamos[intval($detalle['numero_cuota'])] = strtolower($detalle['estado']);
                }

                // Iterar sobre cada cuota
                for ($i = 1; $i <= $cuotas; $i++) {
                    // Calcular la fecha de pago según la frecuencia
                    switch ($frecuencia) {
                        case 'diario':
                            $fecha_pago_inicial = strtotime("+1 day", $fecha_pago_inicial);
                            break;
                        case 'semanal':
                            $fecha_pago_inicial = strtotime("+1 week", $fecha_pago_inicial);
                            break;
                        case 'mensual':
                            $fecha_pago_inicial = strtotime("+1 month", $fecha_pago_inicial);
                            break;
                        default:
                            // Si la frecuencia no está definida, asumir mensual por defecto
                            $fecha_pago_inicial = strtotime("+1 month", $fecha_pago_inicial);
                            break;
                    }

                    $fecha_pago_formateada = date("Y/m/d", $fecha_pago_inicial);

                    // Verificar el estado de la cuota desde el array de detallePrestamos
                    if (isset($detallePrestamos[$i]) && $detallePrestamos[$i] === 'pagado') {
                        // Cuota pagada
                        $estado = 'Pagada';
                        $estado_clase = 'bg-success';
                    } else {
                        // Obtener la fecha de hoy sin la hora
                        $fecha_hoy = strtotime("today");

                        // Comparar la fecha de pago con la fecha de hoy
                        if ($fecha_pago_inicial < $fecha_hoy) {
                            // Si la fecha de pago es anterior a hoy, el estado será "Vencido"
                            $estado = 'Vencido';
                            $estado_clase = 'bg-danger';  // Clase CSS para fondo rojo
                        } else {
                            // Si la fecha de pago es hoy o en el futuro
                            $estado = 'Pendiente';
                            $estado_clase = 'bg-primary';  // Clase CSS para fondo celeste
                        }
                    }

                    echo '<tr>';
                    echo '<td>' . $i . '</td>';
                    echo '<td>' . htmlspecialchars($fecha_pago_formateada) . '</td>';
                    echo '<td>S/. ' . number_format($monto_por_cuota, 2) . '</td>';
                    echo '<td class="' . $estado_clase . ' text-white">' . $estado . '</td>';

                    // Solo permitir pagar si la cuota no está pagada
                    if ($estado === 'Pagada') {
                        echo '<td><button class="btn btn-secondary" disabled>Cuota Pagada</button></td>';
                    } else if ($estado === 'Vencido') {
                        echo '<td><button class="btn btn-danger" disabled>Cuota Vencida</button></td>';
                    } else {
                        echo '<td><button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#pagoModal" 
                               onclick="setPagoDetails(' . htmlspecialchars($row['codigo']) . ', \'' . htmlspecialchars($fecha_pago_formateada) . '\', \'' . htmlspecialchars($estado) . '\', ' . htmlspecialchars($monto_por_cuota) . ', ' . htmlspecialchars($i) . ')">Pagar Cuota</button></td>';
                    }   
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
                echo '</div>'; // Fin de la tabla de cuotas

                echo '</div>'; // Fin del card-body
                echo '</div>'; // Fin del card
                echo '</div>'; // Fin del col-12
            }
        } else {
            // No se encontró el préstamo
            echo '<div class="col-12">';
            echo '<div class="alert alert-warning" role="alert">';
            echo 'No se encontró información para el código de préstamo: ' . htmlspecialchars($codi);
            echo '</div>';
            echo '</div>';
        }

        $stmt->close();
    } else {
        // Error al preparar la consulta principal
        echo '<div class="col-12">';
        echo '<div class="alert alert-danger" role="alert">';
        echo 'Error al preparar la consulta: ' . htmlspecialchars($cnn->error);
        echo '</div>';
        echo '</div>';
    }
} else {
    // No se proporcionó un código válido
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
                <form action="procesos/agregar_cuota.php" method="POST">
                    <input type="hidden" id="codigoPrestamo" name="codigo" value="">
                    
                    <!-- Mostrar el número de cuota -->
                    <div class="mb-3">
                        <label for="cuotaNumero" class="form-label">Número de Cuota</label>
                        <input type="text" class="form-control" id="cuotaNumero" name="cuota_numero" readonly>
                    </div>

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
                        <label for="cantidadPagada" class="form-label">Cantidad Pagada</label>
                        <input type="number" class="form-control" id="cantidadPagada" name="cantidad_pagada" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">Registrar Pago</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function setPagoDetails(codigo, fecha_pago, estado, monto, cuota_num) {
        let hoy = new Date();

// Ajustar la fecha a la zona horaria de Lima (UTC-5)
        let fechaLima = new Date(hoy.toLocaleString("en-US", { timeZone: "America/Lima" }));

// Obtener el formato YYYY-MM-DD
    let fecha1 = fechaLima.toISOString().split('T')[0];

        // Establecer los valores en el modal
        document.getElementById('codigoPrestamo').value = codigo;
        document.getElementById('fechaPago').value = fecha1;  
        document.getElementById('estado').value = estado;
        document.getElementById('cantidadPagada').value = monto;

        // Agregar el número de cuota en el modal
        document.getElementById('cuotaNumero').value = cuota_num;
    }
</script>
</body>
</html>

