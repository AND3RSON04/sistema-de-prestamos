<?php
/* Haciendo la conexion a la Base De Datos MySQL del XAMPP*/
$cnn=mysqli_connect("localhost","root","")or die("Error en servidor");
//selecionando la base de datos
mysqli_select_db($cnn,"bdprestamos")or die("Error en BD");
//echo "Aperturado Correctamente";
?>