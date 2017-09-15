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

$id_dis=$_GET['idd'];
$query_distri = "SELECT * FROM distribuidores WHERE id_distribuidor='$id_dis';";
$resultado_distri = mysql_query($query_distri, $conex);
$datos_distri = mysql_fetch_array($resultado_distri);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Distribuidores</title>

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
                        Modificacion del distribuidor
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="Ldistribuidor_modificacion.php" method="post">
                            <div class="section">
                                <div class="section-title">Llene los campos para modificar el articulo seleccionado</div>
                                <div class="section-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Codigo</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" readonly onkeyup="conMayusculas(this)" name="codigo" value="<?php echo $datos_distri['id_distribuidor'] ?>" placeholder="<?php echo $datos_distri['id_distribuidor'] ?>">
                                            <input type="hidden" class="form-control" name="idd" maxlength="5" value="<?php echo $id_dis ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Descripcion</label>
                                            <p class="control-label-help">( Breve descripcion sobre el distribuidor , 60 letras como maximo )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" style="text-transform: uppercase" name="descripcion" maxlength="60" placeholder="<?php echo $datos_distri['descripcion'] ?>"><?php echo $datos_distri['descripcion'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Estado</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <select class="select2" name="estado_dis">
                                                    <?php
                                                    if(strcasecmp($datos_distri['estado'],'A')==0)
                                                    {
                                                        echo "<option value='".$datos_distri['estado']."'>ACTIVO (Actual)</option>";
                                                    }
                                                    elseif(strcasecmp($datos_distri['estado'],'I')==0)
                                                    {
                                                        echo "<option value='".$datos_distri['estado']."'>INACTIVO (Actual)</option>";
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