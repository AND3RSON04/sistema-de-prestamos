<?php
include("../conexion/conexion.php");
$datos=$_POST['tdatos'];
$usuario=$_POST['tusu'];
$clave=$_POST['tpass'];
$rol=$_POST['tdir'];

$opcion=$_POST['topcion'];
if ($opcion==1){
    $consulta="INSERT INTO clientes
    VALUES('$dni','$ape','$nom','$dir','$ref')";
    header("Location:../principal.php");
}
if ($opcion==2){
    $consulta="UPDATE clientes SET
    apellidos='$ape',nombres='$nom',direccion='$dir',referencia='$ref'
    WHERE dni='$dni' ";
    header("Location:../principal.php");
}

mysqli_query($cnn,$consulta)or die("Error:consulta..!");

?>