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

$query_usuarios = "SELECT * FROM usuarios WHERE estado='1';";
$resultado_usuarios = mysql_query($query_usuarios, $conex);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Permisos de acceso</title>

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
            <li class="navbar-title">Permisos de acceso</li>
        </ul>
        <?php include_once("template_navbar1.php");?>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Usuarios
                    </div>
                    <div class="card-body no-padding">
                        <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Descripcion</th>
                                <th>Acceso</th>
                                <th>Codigo de usuario</th>
                                <th>Fecha de alta</th>
                                <th>Dar permisos</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($dato_usuario = mysql_fetch_array($resultado_usuarios))
                            {
                                $id_usuario=$dato_usuario['clave'];
                                echo "<tr>";
                                echo "<td>" . $dato_usuario['nombre'] . "</td>";
                                echo "<td>" . $dato_usuario['email'] . "</td>";
                                echo "<td>" . $dato_usuario['clave'] . "</td>";
                                echo "<td>" . $dato_usuario['fecha_alta'] . "</td>";
                                echo "<td><a type='button' class='btn btn-primary' href='ver_accesos.php?idu=".$id_usuario."'>Dar permisos</a></td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
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