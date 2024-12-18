<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Corporativo</title>
  <link rel="shortcut icon" href="../img/login.ico" type="image/x-icon">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/estilos.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<body>
  <div class="login-container">
  <img src="../img/empresa.gif" alt="Descripción del GIF" />
    <h3>Acceso Corporativo</h3>
    <form action="../procesos/login.php" method="post">
      <div class="form-group position-relative">
        <i class="bi bi-person-fill"></i>
        <input type="text" class="form-control" placeholder="Usuario" name="usuario" required>
      </div>
      <div class="form-group position-relative">
        <i class="bi bi-lock-fill"></i>
        <input type="password" class="form-control" placeholder="Contraseña" name="clave" required>
      </div>
      <button type="submit" class="btn btn-custom btn-block">Ingresar</button>
    </form>
  </div>

  <script>
 window.addEventListener('load', function() {
    const urlParams = new URLSearchParams(window.location.search); 
    if (urlParams.has('loginerr') && urlParams.get('loginerr') === 'true') {
      
      swal({
        title: "Contraseña o Usuario incorrectos",
        text: "Vuelva a intentarlo",
        icon: "error",
        button: "Aceptar",
      });
    }
  });
  </script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
