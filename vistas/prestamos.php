<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .contenedor_p{margin:10px;}
    
</style>
<body>
<div class="container my-5">
    <!-- Formulario de clientes -->
    <div class="card mb-4">
        <div class="card-header text-white bg-primary">
            <h4>Formulario de Prestamos</h4>
        </div>
        <div class="card-body">
            <form action="#" method="post" id="frmp" name="frmp">
                    <?php
                    include("../conexion/conexion.php");
                    $consulta="select * from clientes order by apellidos";
                    $registros=mysqli_query($cnn,$consulta);
                    ?>

                <div class="row mb-3">
                    <label for="tdni" class="col-sm-2 col-form-label">Codigo</label>
                    <div class="col-sm-10">
                        <input type="text" name="tcod" id="tcod" class="form-control" required >
                    </div>
                </div>
        
                <div class="row mb-3">
                    <label for="tape" class="col-sm-2 col-form-label">Clientes</label>
                    <div class="col-sm-10">
                        <select class="form-select form-select-m mb-3" aria-label="Large select example" name="tcliente" id="tcliente">
                            <?php while($f=mysqli_fetch_array($registros)){
                              $datos=$f['apellidos']." ".$f['nombres'];
                            ?>
                            <option value="<?php echo $f['dni']; ?>">
                            <?php  echo $datos;?>
                        </option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tnom" class="col-sm-2 col-form-label">Tipo De Prestamo</label>
                    <div class="col-sm-10">
                <select class="form-select form-select-m mb-3" aria-label="Large select example" name="ttip" id="ttip">
                    <option value="diario">Diario</option>
                    <option value="semanal">Semanal</option>
                    <option value="mensual">Mensual</option>
                </select>
                </div>
                <div class="row mb-3">
                    <label for="tdir" class="col-sm-2 col-form-label">Cantidad Prestada</label>
                    <div class="col-sm-10">
                        <input type="text" name="tcan" id="tcan" class="form-control" required >
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tref" class="col-sm-2 col-form-label">Interes</label>
                    <div class="col-sm-10">
                        <input type="number" name="tint" id="tint" class="form-control" required >
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tref" class="col-sm-2 col-form-label">Cuota</label>
                    <div class="col-sm-10">
                        <input type="number" name="tcuo" id="tcuo" class="form-control" required >
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tref" class="col-sm-2 col-form-label">Pago Mensual</label>
                    <div class="col-sm-10">
                        <input type="number" name="tmen" id="tmen" class="form-control" required >
                    </div>
                </div>
                <div id="titulos_p">Color</div>
            <div id="control">
                <input type="radio" name="tcolor" id="trojo" value="1"><font color="red"> Rojo </font>
                <input type="radio" name="tcolor" id="tverde" value="2"><font color="green"> verde </font>
                <input type="radio" name="tcolor" id="tceleste" value="3"><font color="sky-blue"> celeste </font>
            </div>
        </div>
    </div>
    <div class="text-center">
    <div>
        <button type="button" id="breg" class="btn btn-primary" onclick="enviar()">Registrar</button>
    </div>
</div>
            </form>
        </div>
    </div>    
</body>
<script>
    function enviar(){
    document.getElementById('frmp').method='post';
    document.getElementById('frmp').action='procesos/agregar_prestamos.php';
    document.getElementById('frmp').submit();
}
</script>
</html>