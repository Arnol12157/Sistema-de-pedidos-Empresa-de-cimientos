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

?>
<!DOCTYPE html>
<html>
<head>
    <title>Modificar datos</title>

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
            <li class="navbar-title">Modificar datos</li>
        </ul>
        <?php include_once("template_navbar1.php");?>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Debido a politicas de la empresa solo puede modificar los siguientes campos
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="Lmodificar_datos.php" method="post">
                            <div class="section">
                                <div class="section-body">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Telefono de contacto</label>
                                            <p class="control-label-help">( Ingrese el nuevo telefono de contacto )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="tel_contacto" max="99999999" min="1000000" value="<?php echo $tel_contacto ?>" placeholder="<?php echo $tel_contacto ?> (Actual)" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Email</label>
                                            <p class="control-label-help">( Ingrese el nuevo email de contacto )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="email" class="form-control" name="email" value="<?php echo $email ?>" placeholder="<?php echo $email ?> (Actual)" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Celular</label>
                                            <p class="control-label-help">( Ingrese el nuevo numero de celular )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="celular" max="99999999" min="1000000" value="<?php echo $celular ?>" placeholder="<?php echo $celular ?> (Actual)" />
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