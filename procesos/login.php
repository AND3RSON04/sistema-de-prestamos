<?php

include('../conexion/conexion.php');

$usuario = $_POST['usuario'];
$contraseña = $_POST['clave'];


$sql = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
$stmt = $cnn->prepare($sql);
$stmt->bind_param("ss", $usuario, $contraseña);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {
    session_start();
    $_SESSION['usuario'] = $usuario; 
    header("Location:../vistas/clientes.php?login=true");
} else {
    
    header("Location:../index.php?loginerr=true");
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>