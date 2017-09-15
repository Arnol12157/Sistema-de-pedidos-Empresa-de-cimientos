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

$id_art=$_GET['ida'];
$query_articulo = "SELECT * FROM articulos WHERE codigo='$id_art';";
$resultado_articulo = mysql_query($query_articulo, $conex);
$datos_articulo = mysql_fetch_array($resultado_articulo);
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
                        Modificacion del articulo
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="Larticulo_modificacion.php" method="post">
                            <div class="section">
                                <div class="section-title">Llene los campos para modificar el articulo seleccionadao</div>
                                <div class="section-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Codigo</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" readonly onkeyup="conMayusculas(this)" name="codigo" value="<?php echo $datos_articulo['codigo'] ?>" placeholder="<?php echo $datos_articulo['codigo'] ?>">
                                            <input type="hidden" class="form-control" name="ida" value="<?php echo $datos_articulo['codigo'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Descripcion</label>
                                            <p class="control-label-help">( Breve descripcion sobre el nuevo articulo inscrito , 60 letras como maximo )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" style="text-transform: uppercase" maxlength="60" name="descripcion" placeholder="<?php echo $datos_articulo['descripcion'] ?>"><?php echo $datos_articulo['descripcion'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Aplicacion</label>
                                            <p class="control-label-help">( Aplicacion sobre el nuevo articulo inscrito , 500 letras como maximo )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" style="text-transform: uppercase" maxlength="500" name="aplicacion" placeholder="<?php echo $datos_articulo['aplicacion'] ?>"><?php echo $datos_articulo['aplicacion'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Estado</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <select class="select2" name="estado_art">
                                                    <?php
                                                    if(strcasecmp($datos_articulo['estado'],'A')==0)
                                                    {
                                                        echo "<option value='".$datos_articulo['estado']."'>ACTIVO (Actual)</option>";
                                                    }
                                                    elseif(strcasecmp($datos_articulo['estado'],'I')==0)
                                                    {
                                                        echo "<option value='".$datos_articulo['estado']."'>INACTIVO (Actual)</option>";
                                                    }
                                                    ?>
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