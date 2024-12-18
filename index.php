<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn-login {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-login:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-size: 12px;
        }
    </style>
</head>
<?php session_start(); ?>
<body>

    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form id="loginForm" method="post" action="">
            <input type="text" id="username" name="username" class="input-field" 
            placeholder="Usuario" required>
            <input type="password" id="password" name="password" class="input-field"
             placeholder="Contraseña" required>
            <button type="submit" class="btn-login" name="botoni">
                Iniciar Sesión</button>
        </form>
        <div id="error-message" class="error"></div>
    </div>
<?php
include("conexion/conexion.php");

if(isset($_POST['botoni'])){
$usuario=$_POST['username'];
$clave=$_POST['password'];
$consulta="select * from usuarios where usuario='$usuario'
and clave='$clave' ";
$resultado=mysqli_query($cnn,$consulta);
$resultado_a=mysqli_fetch_assoc($resultado);
$filas=mysqli_num_rows($resultado);
if($filas==1){
    $_SESSION['usuarios']['dni']=$resultado_a['id_usuario'];
    $_SESSION['usuarios']['datos']=$resultado_a['Datos'];
    $_SESSION['usuarios']['nivel']=$resultado_a['nivel'];
    header("Location:principal.php");
}else{
    session_destroy();
    echo("Error en datos");
}
}
?>

</body>
</html>
