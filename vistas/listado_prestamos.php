<?php
include("../conexion/conexion.php");

$consulta="select p.*,c.apellidos from prestamos p,clientes c where 
estado ='en curso' and p.dni=c.dni ";

if(isset($_GET['color'])){
$zona=$_GET['color'];
$consulta="select p.*,c.apellidos from prestamos p,clientes c where 
estado='en curso' and p.dni=c.dni and p.color=$zona ";
}
$registros=mysqli_query($cnn,$consulta);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div id="filtro_prestamos">
        <form action="" method="post">
        Seleccione zona: 
        <select name="tzona" id="tzona">
            <option value="0"> ----------</option>
            <option value="1" style="background-color: red;">Zona01</option>
            <option value="2" style="background-color: green;">Zona02</option>
            <option value="3" style="background-color: skyblue;">Zona03</option>
        </select>
        Ingrese DNI: <input type="text" name="tdni" id="tdni">
        Ingrese apellido: <input type="text" name="tapellido" id="tapellido">
    </form>
    </div>
    <div id="contenedor_listado_prestamos">
    <?php while($fila=mysqli_fetch_array($registros)) { 
            $color=$fila['color'];
            if($color==1){$xcolor="red";}
            if($color==2){$xcolor="green";}
            if($color==3){$xcolor="skyblue";}
        ?>
        <div id="prestamo" style="background-color:<?php echo $xcolor;?>"data-codigo="<?php echo $fila['codigo'];?>">
            codigo: <?php echo $fila['codigo']; ?>
            <br> 
            <?php echo $fila['apellidos']; ?>
            <br> 
            <?php echo 's/.'.$fila['pago_mensual'];?>
            </div>
       <?php } ?>
    </div>
</body>
</html>