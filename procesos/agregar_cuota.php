<?php
include("../conexion/conexion.php");
$codigo=$_POST['codigo'];
$num_cuot=$_POST['cuota_numero'];
$fecha=$_POST['fecha_pago'];
$cuota=$_POST['cantidad_pagada'];
$estado=$_POST['estado'];
echo $codigo."-". $num_cuot."-". $fecha."-". $cuota."-".$estado;
$sql = "INSERT INTO detalle_prestamos (codigo, numero_cuota, fecha, cuota, estado) VALUES ($codigo, $num_cuot, '$fecha', $cuota, '$estado')";

if ($cnn->query($sql) === TRUE) {
    echo "Nuevo registro agregado correctamente";
echo '<meta http-equiv="refresh" content="1;URL=../principal.php">';
} else {
    echo "Error: " . $sql . "<br>" . $cnn->error;
}

// Cerrar la conexión
$cnn->close();
?>