<?php session_start(); 
if(!isset($_SESSION['usuarios']['dni'])){
header("Location:../login.php");
exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery/jquery-3.7.1.min.js"></script>
    <script src="jquery/prestamos.js"></script>
    <link rel="shortcut icon" href="../img/prestamo.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>



<div class="container my-5">
    <!-- Formulario de clientes -->
    <div class="card mb-4">
        <div class="card-header text-white bg-primary">
            <h4>Formulario de Clientes</h4>
        </div>
        <div class="card-body">
            <?php
                $dni="";$ape="";$nom="";$dir="";$ref=""; $opcion=1;
                if (isset($_GET['dni'])){
                    $dni=$_GET['dni'];
                    $ape=$_GET['ape'];
                    $nom=$_GET['nom'];
                    $dir=$_GET['dir'];
                    $ref=$_GET['ref'];
                    $opcion=2;
                }
            ?>
            <form action="procesos/agregar_clientes.php" method="post">
            <div class="row mb-3">
            <label for="tdni" class="col-sm-2 col-form-label">DNI</label>
         <div class="col-sm-10">
        <div class="input-group">
            <input type="text" name="tdni" id="tdni" class="form-control" required value="<?php echo $dni; ?>">
            <button class="btn btn-outline-secondary" type="button" id="btnbus">
                <i class="bi bi-search"></i> Buscar
            </button>
        </div>
        </div>
    </div>
                <div class="row mb-3">
                    <label for="tape" class="col-sm-2 col-form-label">Apellidos</label>
                    <div class="col-sm-10">
                        <input type="text" name="tape" id="tape" class="form-control" required value="<?php echo $ape; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tnom" class="col-sm-2 col-form-label">Nombres</label>
                    <div class="col-sm-10">
                        <input type="text" name="tnom" id="tnom" class="form-control" required value="<?php echo $nom; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tdir" class="col-sm-2 col-form-label">Dirección</label>
                    <div class="col-sm-10">
                        <input type="text" name="tdir" id="tdir" class="form-control" required value="<?php echo $dir; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tref" class="col-sm-2 col-form-label">Referencia</label>
                    <div class="col-sm-10">
                        <input type="text" name="tref" id="tref" class="form-control" required value="<?php echo $ref; ?>">
                    </div>
                </div>
                <div class="text-center">
                <button type="submit"  class="btn btn-success"><i class="bi bi-person-fill-add me-2 "></i>Agregar</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-arrow-clockwise me-2"></i></i>Actualizar</button>
                <input type="hidden" name="topcion" value="<?php echo $opcion; ?>">
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de clientes -->
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
                        include("../conexion/conexion.php");
                        $consulta="SELECT * FROM clientes ORDER BY apellidos";
                        $datos=mysqli_query($cnn, $consulta);
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
                        <td>
                        <button onclick="confirmDeletion('<?php echo $dni; ?>')" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i> 
                        </button>
                            <a href="clientes.php?dni=<?php echo $dni; ?>&ape=<?php echo $ape; ?>&nom=<?php echo $nom; ?>&dir=<?php echo $dir; ?>&ref=<?php echo $ref; ?>" class="btn btn-primary btn-sm">
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
<script>
  window.addEventListener('load', function() {
    const urlParams = new URLSearchParams(window.location.search); // Declara la variable aquí
    if (urlParams.has('login') && urlParams.get('login') === 'true') {
      
      swal({
        title: "Bienvenido!",
        text: "Al panel de control de la empresa",
        icon: "info",
        button: "Aceptar",
      });
    }
  });
  window.addEventListener('load', function() {
    const urlParams = new URLSearchParams(window.location.search); // Declara la variable aquí
    if (urlParams.has('agregar') && urlParams.get('agregar') === 'true') {
      
      swal({
        title: "Registro Correctamente",
        text: "El registro ha sido agregado correctamente.",
        icon: "success",
        button: "Aceptar",
      });
    }
  });
  window.addEventListener('load', function() {
    const urlParams = new URLSearchParams(window.location.search); // Declara la variable aquí
    if (urlParams.has('actua') && urlParams.get('actua') === 'true') {
      
      swal({
        title: "Actualizo Correctamente",
        text: "El registro se actualizo correctamente.",
        icon: "success",
        button: "Aceptar",
      });
    }
  });
  window.addEventListener('load', function() {
    const urlParams = new URLSearchParams(window.location.search); // Declara la variable aquí
    if (urlParams.has('deleted') && urlParams.get('deleted') === 'true') {
     
      swal({
        title: "Registro Eliminado",
        text: "El registro ha sido eliminado con éxito.",
        icon: "error",
        button: "Aceptar",
   
      });
    }
  });
  function confirmDeletion(dni) {
    swal({
      title: "¿Estás seguro?",
      text: "Una vez eliminado, no podrás recuperar este registro.",
      icon: "warning",
      buttons: ["Cancelar", "Eliminar"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        
        // Redirige a la página de eliminación con el DNI
        window.location.href = `procesos/eliminar_clientes.php?dni=${dni}`;
      } else {
        swal("El registro está a salvo.");
      }
    });
  }
</script>
<!-- Bootstrap y Scripts de JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeo3z7ZVUxL00T4Jr8RXl4ZSA2Yxxm1i5J5xsw/TOv6j6zLo" crossorigin="anonymous"></script>
</body>
</html>
