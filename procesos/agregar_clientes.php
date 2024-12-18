<?php
include("../conexion/conexion.php");
$dni=$_POST['tdni'];
$ape=$_POST['tape'];
$nom=$_POST['tnom'];
$dir=$_POST['tdir'];
$ref=$_POST['tref'];

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