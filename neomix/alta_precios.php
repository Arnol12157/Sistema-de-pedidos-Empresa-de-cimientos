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

$query_codigos = "SELECT * FROM articulos ORDER BY codigo;";
$resultado_codigos = mysql_query($query_codigos, $conex);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Precios</title>

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
            <li class="navbar-title">Precios</li>
        </ul>
        <?php include_once("template_navbar1.php");?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Alta de precios
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="Lprecios_alta.php" method="post">
                            <div class="section">
                                <div class="section-title">Llene los campos para ingresar un nuevo precio</div>
                                <div class="section-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Codigo de articulo</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <select class="select2" name="codigo">
                                                    <?php
                                                    while ($dato_codigo = mysql_fetch_array($resultado_codigos))
                                                    {
                                                        echo "<option value='". $dato_codigo['codigo'] ."'>". $dato_codigo['codigo'] ."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Cantidad</label>
                                        <div class="col-md-4">
                                            <input type="number" step="1" class="form-control" name="cantidad" max="9999" min="0000" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Precio contado a domicilio</label>
                                        <div class="col-md-4">
                                            <input type="number" step="0.01" class="form-control" name="precio_contado_domicilio" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Precio contado en planta</label>
                                        <div class="col-md-4">
                                            <input type="number" step="0.01" class="form-control" name="precio_contado_planta" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Precio crecito a domicilio</label>
                                        <div class="col-md-4">
                                            <input type="number" step="0.01" class="form-control" name="precio_credito_domicilio" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Precio credito en planta</label>
                                        <div class="col-md-4">
                                            <input type="number" step="0.01" class="form-control" name="precio_credito_planta" required>
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