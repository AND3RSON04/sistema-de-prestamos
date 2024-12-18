<?php
include("../conexion/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos enviados desde el formulario
    $codigo_prestamo = $_POST['codigo_prestamo'];
    $cuota = $_POST['numero_cuota'];
    $fecha_pago = date("Y-m-d");  // Fecha actual del pago
    $monto = $_POST['cuota'];

    // Registrar el pago en la base de datos
    $sql = "INSERT INTO pagos (codigo_prestamo, numero_cuota, fecha, monto, estado) VALUES (?, ?, ?, ?, ?)";
    $estado_pago = "Pagado";  // Estado de pago

    $stmt = $cnn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iiiss", $codigo_prestamo, $cuota, $fecha_pago, $monto, $estado_pago);
        if ($stmt->execute()) {
            echo "Pago registrado correctamente.";
            
            // Actualizar el estado del préstamo o cuota si es necesario
            // Por ejemplo, si todas las cuotas se pagaron, cambiar el estado del préstamo a "Pagado"
            // Esto es opcional, según la lógica de tu aplicación

            // Redirigir a la página de detalles de préstamo para mostrar los cambios
            header("Location: detalle_prestamo.php?codigo=" . $codigo_prestamo);
            exit();
        } else {
            echo "Error al registrar el pago: " . $stmt->error;
        }
    } else {
        echo "Error al preparar la consulta: " . $cnn->error;
    }

    $stmt->close();
} else {
    echo "Acceso no válido.";
}

$cnn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
include("../conexion/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos enviados desde el formulario
    $codigo_prestamo = $_POST['codigo_prestamo'];
    $cuota = $_POST['numero_cuota'];
    $fecha_pago = date("Y-m-d");  // Fecha actual del pago
    $monto = $_POST['cuota'];

    // Registrar el pago en la base de datos
    $sql = "INSERT INTO pagos (codigo_prestamo, numero_cuota, fecha, monto, estado) VALUES (?, ?, ?, ?, ?)";
    $estado_pago = "Pagado";  // Estado de pago

    $stmt = $cnn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iiiss", $codigo_prestamo, $cuota, $fecha_pago, $monto, $estado_pago);
        if ($stmt->execute()) {
            echo "Pago registrado correctamente.";
            
            // Actualizar el estado del préstamo o cuota si es necesario
            // Por ejemplo, si todas las cuotas se pagaron, cambiar el estado del préstamo a "Pagado"
            // Esto es opcional, según la lógica de tu aplicación

            // Redirigir a la página de detalles de préstamo para mostrar los cambios
            header("Location: detalle_prestamo.php?codigo=" . $codigo_prestamo);
            exit();
        } else {
            echo "Error al registrar el pago: " . $stmt->error;
        }
    } else {
        echo "Error al preparar la consulta: " . $cnn->error;
    }

    $stmt->close();
} else {
    echo "Acceso no válido.";
}

$cnn->close();
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
    echo '<td>';
    
    // Formulario de pago
    echo '<form action="pagar.php" method="POST">';
    echo '<input type="hidden" name="codigo_prestamo" value="' . $row['codigo'] . '">';
    echo '<input type="hidden" name="cuota" value="' . $i . '">';
    echo '<input type="hidden" name="monto" value="' . $monto_por_cuota . '">';
    echo '<button type="submit" class="btn btn-success">Pagar Cuota</button>';
    echo '</form>';
    
    echo '</td>';
    echo '</tr>';
}
$sql_check = "SELECT COUNT(*) FROM detalle_prestamos WHERE codigo_prestamo = ? AND estado = 'Pagado'";
$stmt_check = $cnn->prepare($sql_check);
$stmt_check->bind_param("i", $codigo_prestamo);
$stmt_check->execute();
$stmt_check->bind_result($pagadas);
$stmt_check->fetch();
$stmt_check->close();

$sql_update = "";
if ($pagadas == $cuotas) {
    $sql_update = "UPDATE prestamos SET estado = 'Pagado' WHERE codigo = ?";
    $stmt_update = $cnn->prepare($sql_update);
    $stmt_update->bind_param("i", $codigo_prestamo);
    $stmt_update->execute();
    $stmt_update->close();
}

?>
</body>
</html>