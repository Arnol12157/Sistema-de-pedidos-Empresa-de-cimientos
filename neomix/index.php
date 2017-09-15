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
    $id = $_SESSION['id'];
    $nombre = $_SESSION['nombre'];
    $email = $_SESSION['email'];
    $contra = $_SESSION['contra'];
    $clave = $_SESSION['clave'];
    $fecha = $_SESSION['fecha'];
    $estado = $_SESSION['estado'];

    $query_solicitudes_aceptar = "SELECT * FROM solicitudes_clientes WHERE estado='S';";
    $resultado_solicitudes_aceptar = mysql_query($query_solicitudes_aceptar, $conex);
    $num_rows_sol_acept=mysql_num_rows($resultado_solicitudes_aceptar);

$query_clientes_mod = "SELECT * FROM clientes WHERE estado='M';";
$resultado_clientes_mod = mysql_query($query_clientes_mod, $conex);
$num_rows_clientes_mod=mysql_num_rows($resultado_clientes_mod);

$query_pedidos_aceptar = "SELECT * FROM pedidos WHERE estado='P';";
$resultado_pedidos_aceptar = mysql_query($query_pedidos_aceptar, $conex);
$num_rows_ped_acept=mysql_num_rows($resultado_pedidos_aceptar);

$query_pedidos_transito = "SELECT * FROM pedidos WHERE estado='T';";
$resultado_pedidos_transito = mysql_query($query_pedidos_transito, $conex);
$num_rows_ped_tran=mysql_num_rows($resultado_pedidos_transito);

$query_pedidos_programar = "SELECT * FROM pedidos WHERE estado='A' OR estado='M';";
$resultado_pedidos_programar = mysql_query($query_pedidos_programar, $conex);
$num_rows_ped_programar=mysql_num_rows($resultado_pedidos_programar);

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
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a class="card card-banner card-green-light">
                    <div class="card-body">
                        <i class="icon fa fa-user-plus fa-4x"></i>
                        <div class="content">
                            <div class="title">Solicitudes a aceptar</div>
                            <div class="value"><span class="sign"></span><?php echo $num_rows_sol_acept ?></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a class="card card-banner card-orange-light">
                    <div class="card-body">
                        <i class="icon fa fa-user-plus fa-4x"></i>
                        <div class="content">
                            <div class="title">Modificaciones a autorizar</div>
                            <div class="value"><span class="sign"></span><?php echo $num_rows_clientes_mod ?></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a class="card card-banner card-blue-light">
                    <div class="card-body">
                        <i class="icon fa fa-truck fa-4x"></i>
                        <div class="content">
                            <div class="title">Pedidos a aceptar</div>
                            <div class="value"><span class="sign"></span><?php echo $num_rows_ped_acept ?></div>
                        </div>
                    </div>
                </a>
            </div>
            <!--
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a class="card card-banner card-green-light">
                    <div class="card-body">
                        <i class="icon fa fa-truck fa-4x"></i>
                        <div class="content">
                            <div class="title">Entregas a programar</div>
                            <div class="value"><span class="sign"></span><?php // echo $num_rows_ped_programar ?></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a class="card card-banner card-yellow-light">
                    <div class="card-body">
                        <i class="icon fa fa-bus fa-4x"></i>
                        <div class="content">
                            <div class="title">Entregas a procesar</div>
                            <div class="value"><span class="sign"></span><?php // echo $num_rows_ped_tran ?></div>
                        </div>
                    </div>
                </a>
            </div>
            -->
        </div>
        <?php include_once("template_footer.php");?>
    </div>

</div>

<script type="text/javascript" src="../assets/js/vendor.js"></script>
<script type="text/javascript" src="../assets/js/app.js"></script>

</body>
</html>