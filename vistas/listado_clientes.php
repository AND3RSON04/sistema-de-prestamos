<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <?php
    include("../conexion/conexion.php");
    $consulta="select * from clientes order by apellidos";
    if(isset($_POST['b_bc'])){
        $par=$_POST['t_ab'];
        $consulta="select * from clientes where apellidos like CONCAT('$par','%')";
    }
    $datos=mysqli_query($cnn,$consulta);
    ?>
    <form action="" method="post">
        ingrese apellido del cliente:
        <input type="text"  name="t_ab" id="t_ab">
        <input type="submit" value="filtrar" name="b_bc">
    </form>
    <div class="card">
        <div class="card-header text-white bg-secondary">
            <h4>Listado de Clientes</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Nº</th>
                        <th scope="col">DNI</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Referencia</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        
                        $i=0;
                        while($fila=mysqli_fetch_array($datos)){ 
                            $i++;
                            $dni=$fila['dni'];
                            $ape=$fila['apellidos'];
                            $nom=$fila['nombres'];
                            $dir=$fila['direccion'];
                            $ref=$fila['referencia'];
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $dni; ?></td>
                        <td><?php echo $ape; ?></td>
                        <td><?php echo $nom; ?></td>
                        <td><?php echo $dir; ?></td>
                        <td><?php echo $ref; ?></td>
                       
                            
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

    
</body>
</html>