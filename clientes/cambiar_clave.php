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
    <title>Cambiar clave</title>

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
            <li class="navbar-title">Cambiar clave</li>
        </ul>
        <?php include_once("template_navbar1.php");?>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Ingrese los datos para cambiar su clave de acceso
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="Lcambiar_clave.php" method="post">
                            <div class="section">
                                <div class="section-body">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Clave anterior</label>
                                            <p class="control-label-help">( Ingrese la clave que desea cambiar )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="password" class="form-control" name="clave_anterior" placeholder="" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Nueva clave</label>
                                            <p class="control-label-help">( Ingrese la nueva clave )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="password" class="form-control" name="clave_nueva" maxlength="10" placeholder="" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Repita la clave</label>
                                            <p class="control-label-help">( Ingrese nuevamente la nueva clave )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="password" class="form-control" name="clave_repe" maxlength="10" placeholder="" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once("template_footer.php");?>
    </div>

</div>

<script type="text/javascript" src="../assets/js/vendor.js"></script>
<script type="text/javascript" src="../assets/js/app.js"></script>

</body>
</html>