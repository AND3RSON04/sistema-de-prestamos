<?php
$dni=$_GET['dni'];
include("../conexion/conexion.php");
$consulta_eliminar="DELETE FROM clientes WHERE dni='$dni'";

mysqli_query($cnn,$consulta_eliminar)or die("Error: Consulta de eliminar");

header("Location:../principal.php");
exit();

?>