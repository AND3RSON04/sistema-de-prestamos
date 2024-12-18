
<?php
include("../conexion/conexion.php");
$codigo=$_POST['tcod'];
$dni=$_POST['tcliente'];
$tipo=$_POST['ttip'];
$cantidad=$_POST['tcan'];
$interes=$_POST['tint'];
$cuotas=$_POST['tcuo'];
$pago=$_POST['tmen'];
$color=$_POST['tcolor'];
$estado="en curso";
echo $codigo.'-'.$dni.'-'.$tipo.'-'.$cantidad.'-'.$interes.'-'.$cuotas.'-'.$pago.'-'.$color.'-'.$estado;

$consulta="insert into prestamos valueS($codigo,'$dni','$tipo',$cantidad,$interes,$cuotas,$pago,$color,'$estado',now())";
mysqli_query($cnn,$consulta);
echo "Registrado correctamente";
echo '<meta http-equiv="refresh" content="1;URL=../principal.php">';
?>