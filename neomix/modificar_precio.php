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

$id_precio=$_GET['idp'];

$consulta=mysql_query("SELECT * FROM precios WHERE id_precio='".$id_precio."'");
$row=mysql_fetch_array($consulta);
$cantidad=$row['cantidad'];
$codigo_articulo=$row['codigo_articulo'];
$precio_contado_domicilio=$row['precio_contado_domicilio'];
$precio_contado_planta=$row['precio_contado_planta'];
$precio_credito_domicilio=$row['precio_credito_domicilio'];
$precio_credito_planta=$row['precio_credito_planta'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Modificacion de precios</title>

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
            <li class="navbar-title">Modificacion de precios</li>
        </ul>
        <?php include_once("template_navbar1.php");?>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Solo se pueden modificar los campos habilitados
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="Lmodificar_precio.php" method="post">
                            <div class="section">
                                <div class="section-body">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Cantidad</label>
                                            <p class="control-label-help">( Este dato no puede ser cambiado )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="cantidad" disabled placeholder="<?php echo $cantidad ?> (Actual)" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Codigo de articulo</label>
                                            <p class="control-label-help">( Este dato no puede ser cambiado )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="email" class="form-control" disabled name="codigo_articulo" placeholder="<?php echo $codigo_articulo ?> (Actual)" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Precio contado a domicilio</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" step="0.01" name="precio_contado_dom" placeholder="<?php echo $precio_contado_domicilio ?> (Actual)" />
                                            <input type="hidden" class="form-control" name="idp" value="<?php echo $id_precio ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Precio contado en planta</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" step="0.01" name="precio_contado_planta" placeholder="<?php echo $precio_contado_planta ?> (Actual)" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Precio credito a domicilio</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" step="0.01" name="precio_credito_dom" placeholder="<?php echo $precio_credito_domicilio ?> (Actual)" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Precio credito en planta</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" step="0.01" name="precio_credito_planta" placeholder="<?php echo $precio_credito_planta ?> (Actual)" />
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