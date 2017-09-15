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

$idc=$_GET['idc'];

$query_clientes = "SELECT * FROM clientes WHERE id_cliente=$idc;";
$resultado_clientes = mysql_query($query_clientes, $conex);
$dato_cliente = mysql_fetch_array($resultado_clientes);
$obse=$dato_cliente['observacion'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Observaciones</title>

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
            <li class="navbar-title">Observaciones</li>
        </ul>
        <?php include_once("template_navbar1.php");?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Observaciones del cliente
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="Lobservaciones.php" method="post">
                            <div class="section">
                                <div class="section-title">Informacion</div>
                                <div class="section-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Numero de cliente</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="idc" disabled placeholder="<?php echo $dato_cliente['num_cliente'] ?>">
                                            <input type="hidden" class="form-control" name="idc" value="<?php echo $idc ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Nombres y apellidos o razon social</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" disabled placeholder="<?php if(strcasecmp($dato_cliente['nombres'],'')==0){echo $dato_cliente['razon_social'];}elseif(strcasecmp($dato_cliente['razon_social'],'')==0){echo $dato_cliente['nombres'].' '.$dato_cliente['apellidos'];} ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Motivo</label>
                                            <p class="control-label-help">( Breve descripcion del porque el cliente quedara en estado Observado o Activo , 200 letras como maximo )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" onkeyup="conMayusculas(this)" maxlength="200" name="obs" placeholder="<?php echo $obse ?>"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Estado del cliente</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <select class="select2" name="estado_c">
                                                    <?php
                                                        if(strcasecmp($dato_cliente['estado'],'A')==0)
                                                        {
                                                            echo "<option value='".$dato_cliente['estado']."'>ACTIVO (Actual)</option>";
                                                        }
                                                        elseif(strcasecmp($dato_cliente['estado'],'O')==0)
                                                        {
                                                            echo "<option value='".$dato_cliente['estado']."'>OBSERVADO (Actual)</option>";
                                                        }
                                                    ?>
                                                    <option value="A">ACTIVO</option>
                                                    <option value="O">OBSERVADO</option>
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