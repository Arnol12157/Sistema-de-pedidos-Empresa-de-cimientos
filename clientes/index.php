<?php
    //Iniciar Sesi?n
    session_start();

    include("Conexion.php");

    //Validar si se est? ingresando con sesi?n correctamente
    if (!$_SESSION)
    {
    echo '<script language = javascript>
        alert("usuario no autenticado")
        self.location = "login.php"
    </script>';
    }
    //Inicio variables de sesion
    $id = $_SESSION['id_cliente'];
    $estado = $_SESSION['estado'];
    $num_cliente = $_SESSION['num_cliente'];
    $clave = $_SESSION['clave_acceso'];
    $categoria = $_SESSION['categoria'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Menu Principal</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="../assets/css/vendor.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/flat-admin.css">

    <!-- Theme -->
    <link rel="stylesheet" type="text/css" href="../assets/css/theme/blue-sky.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/theme/blue.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/theme/red.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/theme/yellow.css">

</head>
<body>
<div class="app app-default">

    <?php include_once("template_sidebar.php");?>

    <div class="app-container">

        <?php include_once("template_navbar.php");?>
                    <ul class="nav navbar-nav navbar-left">
                        <li class="navbar-title">Menu Principal</li>
                    </ul>
        <?php include_once("template_navbar1.php");?>
        <div class="row">

        </div>
        <?php include_once("template_footer.php");?>
    </div>

</div>

<script type="text/javascript" src="../assets/js/vendor.js"></script>
<script type="text/javascript" src="../assets/js/app.js"></script>

</body>
</html>