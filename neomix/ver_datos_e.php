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

$query_clientes = "SELECT * FROM clientes WHERE id_cliente='$idc';";
$resultado_clientes = mysql_query($query_clientes, $conex);
$dato_cliente = mysql_fetch_array($resultado_clientes)
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ver datos</title>

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
            <li class="navbar-title">Ver datos</li>
        </ul>
        <?php include_once("template_navbar1.php");?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Datos
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal">
                            <div class="section">
                                <div class="section-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Numero de cliente</label>
                                        <div class="col-md-9">
                                            <input type="text" disabled class="form-control" placeholder="<?php echo $dato_cliente['num_cliente'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Razon social</label>
                                        <div class="col-md-9">
                                            <input type="text" disabled class="form-control" placeholder="<?php echo $dato_cliente['razon_social'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Persona de contacto</label>
                                        <div class="col-md-9">
                                            <input type="text" disabled class="form-control" placeholder="<?php echo $dato_cliente['persona_contacto'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Telefono de contacto</label>
                                        <div class="col-md-9">
                                            <input type="text" disabled class="form-control" placeholder="<?php echo $dato_cliente['tel_contacto'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Email</label>
                                        <div class="col-md-9">
                                            <input type="text" disabled class="form-control" placeholder="<?php echo $dato_cliente['email'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Celular</label>
                                        <div class="col-md-9">
                                            <input type="text" disabled class="form-control" placeholder="<?php echo $dato_cliente['celular'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Telefono de la empresa</label>
                                        <div class="col-md-9">
                                            <input type="text" disabled class="form-control" placeholder="<?php echo $dato_cliente['telefono_empresa'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Direccion</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" disabled><?php echo $dato_cliente['direccion'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Zona</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" disabled><?php echo $dato_cliente['zona'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Telefonos alternativos</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" disabled><?php echo $dato_cliente['telefonos'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Comentario</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" disabled><?php echo $dato_cliente['comentario'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Categoria</label>
                                        <div class="col-md-9">
                                            <input type="text" disabled class="form-control" placeholder="<?php echo $dato_cliente['categoria'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3">
                                        <a type="button" href="Lenvio_claves.php?idc=<?php echo $idc ?>" class="btn btn-primary">Enviar clave</a>
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