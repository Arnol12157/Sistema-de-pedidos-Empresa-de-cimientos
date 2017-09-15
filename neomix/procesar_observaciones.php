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

$query_clientes = "SELECT * FROM clientes;";
$resultado_clientes = mysql_query($query_clientes, $conex);

$query_solicitudes_empresas = "SELECT * FROM clientes WHERE nombres='';";
$resultado_solicitudes_empresas = mysql_query($query_solicitudes_empresas, $conex);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Procesar observaciones</title>

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
            <li class="navbar-title">Procesar observaciones</li>
        </ul>
        <?php include_once("template_navbar1.php");?>

        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Listado de clientes
                    </div>
                    <div class="card-body no-padding">
                        <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Numero de cliente</th>
                                <th>Nombre o razon social</th>
                                <th>Estado</th>
                                <th>Observaciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($dato_cliente = mysql_fetch_array($resultado_clientes))
                            {
                                $id_cliente=$dato_cliente['id_cliente'];

                                echo "<tr>";
                                echo "<td>" . $dato_cliente['num_cliente'] . "</td>";
                                if(strcasecmp($dato_cliente['nombres'],'')==0)
                                {
                                    echo "<td>" . $dato_cliente['razon_social'] . "</td>";
                                }
                                elseif(strcasecmp($dato_cliente['nombres'],'')!=0)
                                {
                                    echo "<td>".$dato_cliente['nombres']." ".$dato_cliente['apellidos']."</td>";
                                }
                                if(strcasecmp($dato_cliente['estado'],'A')==0)
                                {
                                    echo "<td>ACTIVO</td>";
                                }
                                elseif(strcasecmp($dato_cliente['estado'],'O')==0)
                                {
                                    echo "<td>OBSERVADO</td>";
                                }
                                elseif(strcasecmp($dato_cliente['estado'],'M')==0)
                                {
                                    echo "<td>CON DATOS MODIFICADOS</td>";
                                }
                                elseif(strcasecmp($dato_cliente['estado'],'I')==0)
                                {
                                    echo "<td>INACTIVO</td>";
                                }
                                echo "<td><a type='button' class='btn btn-primary' href='ver_observaciones.php?idc=" . $id_cliente ."'>Observaciones</a></td>";
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