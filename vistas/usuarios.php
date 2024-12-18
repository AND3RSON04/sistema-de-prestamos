<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema De Préstamos</title>    
</head>
<body>
<div class="container my-5">
    <!-- Formulario de clientes -->
    <div class="card mb-4">
        <div class="card-header text-white bg-primary">
            <h4>Formulario de Usuarios</h4>
        </div>
        <div class="card-body">
            <form action="#" method="post">
                <div class="row mb-3">
                    <label for="tdni" class="col-sm-2 col-form-label">Datos</label>
                    <div class="col-sm-10">
                        <input type="text" name="tdatos" id="tdatos" class="form-control" required >
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tape" class="col-sm-2 col-form-label">Usuario</label>
                    <div class="col-sm-10">
                        <input type="text" name="tusu" id="tusu" class="form-control" required >
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="tdir" class="col-sm-2 col-form-label">Clave</label>
                    <div class="col-sm-10">
                        <input type="password" name="tpass" id="tpass" class="form-control" required >
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tnom" class="col-sm-2 col-form-label">Rol</label>
                    <div class="col-sm-10">
                <select class="form-select form-select-m mb-3" aria-label="Large select example">
                    <option value="1">Administrador</option>
                    <option value="2">Empleado</option>
                </select>
                </div>
            </div>
                <div class="text-center">
                <button type="submit"  class="btn btn-success"><i class="bi bi-person-fill-add me-2 " ></i>Agregar</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-arrow-clockwise me-2"></i></i>Actualizar</button>
                <input type="hidden" name="topcion" value="<?php echo $opcion; ?>">
                </div>
            </form>
        </div>
    </div>

        <div class="card">
        <div class="card-header text-white bg-secondary">
            <h4>Listado de usuarios</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Nº</th>
                        <th scope="col">Datos</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Clave</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include("../conexion/conexion.php");
                        $consulta="SELECT * FROM usuarios ORDER BY Datos";
                        $datos=mysqli_query($cnn, $consulta);
                        $i=0;
                        while($fila=mysqli_fetch_array($datos)){ 
                            $i++;
                            $da=$fila['Datos'];
                            $usu=$fila['usuario'];
                            $cla=$fila['clave'];
                            $rol=$fila['rol'];
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $da; ?></td>
                        <td><?php echo $usu; ?></td>
                        <td><?php echo $cla; ?></td>
                        <td><?php echo $rol; ?></td>
                        <td>
                        <button onclick="confirmDeletion('<?php echo $da; ?>')" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i> 
                        </button>
                            <a href="clientes.php?dni=<?php echo $da; ?>&usu=<?php echo $usu; ?>&cla=<?php echo $cla; ?>&rol=<?php echo $rol;?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


   
<!-- Bootstrap y Scripts de JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeo3z7ZVUxL00T4Jr8RXl4ZSA2Yxxm1i5J5xsw/TOv6j6zLo" crossorigin="anonymous"></script>
</body>
</html>
