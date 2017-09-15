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

$consulta=mysql_query("SELECT * FROM clientes WHERE id_cliente='".$id."'");
$row=mysql_fetch_array($consulta);
$tel_contacto=$row['tel_contacto'];
$celular=$row['celular'];
$email=$row['email'];

if(strcasecmp($estado,'I')==0 || strcasecmp($estado,'S')==0 || strcasecmp($estado,'M')==0)
{
    echo '<script language = javascript>
                alert("Debido a su estado, usted no puede realizar un pedido")
                self.location = "index.php"
              </script>';
}
elseif(strcasecmp($estado,'O')==0)
{
    echo '<script language = javascript>
                alert("Usted fue observado, podra realizar el pedido pero no sera aceptado hasta que cambie su estado")
              </script>';
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Realizar pedido</title>

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
            <li class="navbar-title">Realizar pedido</li>
        </ul>
        <?php include_once("template_navbar1.php");?>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Selecciona el tipo de pedido a realizar
                    </div>
                    <div class="card-body text-center">
                        <form class="form form-horizontal" action="entregar.php" method="post">
                            <div class="section">
                                <div class="section-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Credito a utilizar</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <select class="select2" name="credito">
                                                    <option value="NO">Contado</option>
                                                    <?php
                                                    if(strcasecmp($row['credito'],'SI')==0)
                                                    {
                                                        echo "<option value='SI'>Credito</option>";
                                                    }
                                                    ?>
                                                    <!--<option value="SI">Credito</option>-->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Lugar de entrega</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <select class="select2" name="lugar">
                                                    <option value="domicilio">Domicilio</option>
                                                    <option value="planta">Planta</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary">Siguiente</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--
                        <a href="entrega_domicilio.php"><h1>Entrega a domicilio <span><h5>Zonas urbanas de La Paz y El Alto</h5></span></h1></a>
                        <a href="entrega_planta.php"><h1>Entrega en planta</h1></a>
                        -->
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