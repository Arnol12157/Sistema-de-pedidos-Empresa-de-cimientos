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
?>
<!DOCTYPE html>
<html>
<head>
    <title>Articulos</title>

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
            <li class="navbar-title">Articulos</li>
        </ul>
        <?php include_once("template_navbar1.php");?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Alta de articulos
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="Larticulos_alta.php" method="post">
                            <div class="section">
                                <div class="section-title">Llene los campos para ingresar un nuevo articulo</div>
                                <div class="section-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Codigo</label>
                                        <div class="col-md-9">
                                            <input type="text" maxlength="5" class="form-control" onkeyup="conMayusculas(this)" name="codigo" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Descripcion</label>
                                            <p class="control-label-help">( Breve descripcion sobre el nuevo articulo , 60 letras como maximo )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" maxlength="60" onkeyup="conMayusculas(this)" name="descripcion" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Aplicacion</label>
                                            <p class="control-label-help">( Aplicacion sobre el nuevo articulo , 500 letras como maximo )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" maxlength="500" onkeyup="conMayusculas(this)" name="aplicacion" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Estado</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <select class="select2" name="estado_art">
                                                    <option value="A">ACTIVO</option>
                                                    <option value="I">INACTIVO</option>
                                                </select>
                                            </div>
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
<script>
    function conMayusculas(field)
    {
        field.value = field.value.toUpperCase();
    }
</script>


</body>
</html>