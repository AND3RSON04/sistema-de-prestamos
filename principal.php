<?php session_start(); 
if(!isset($_SESSION['usuarios']['dni'])){
header("Location:../index.php");
exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de prestamos</title>
    <script src="jquery/jquery-3.7.1.min.js"></script>
    <script src="jquery/prestamos.js"></script>
    <link rel="shortcut icon" href="../img/prestamo.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="css/listado.css">
</head>
<body>
    <div id="contenedor">
        <div id="usuario">
            
        </div>
        <div id="menu">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <img class="pres" src="img/icopres.jpg" alt="" >
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <ul class="navbar-nav ms-auto nav-pills">
        <li class="nav-item">
          <a class="nav-link" href="#" id="usuarios">
            <i class="bi bi-person"></i> Usuarios
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#" id="clientes">
            <i class="bi bi-people"></i> Clientes
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" id="pagos">
          <i class="bi bi-wallet"></i> Pedidos
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" id="prestamos">
          <i class="bi bi-cash-coin"></i> Prestamos
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" id="listado_prestamos">
          <i class="bi bi-search"></i> Listado Prestamos
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="bi bi-clock-history"></i> Historial
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="bi bi-file-earmark-bar-graph"></i> Reportes
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../index.php" id="salir">
          <i class="bi bi-box-arrow-left fs-6 me-2"></i>Salir
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
        </div>
        <div id="paginas">


        </div>
    </div>
    <!-- Bootstrap y Scripts de JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeo3z7ZVUxL00T4Jr8RXl4ZSA2Yxxm1i5J5xsw/TOv6j6zLo" crossorigin="anonymous"></script>
</body>
</html>