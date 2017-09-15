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

$query_articulo = "SELECT * FROM articulos;";
$resultado_articulo = mysql_query($query_articulo, $conex);
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
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Listado de articulos
                    </div>
                    <div class="card-body no-padding">
                        <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Descripcion</th>
                                <th>Aplicacion</th>
                                <th>Estado</th>
                                <th>Fecha de alta</th>
                                <th>Modificar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($dato_art = mysql_fetch_array($resultado_articulo))
                            {
                                $id_art=$dato_art['codigo'];

                                echo "<tr>";
                                echo "<td>" . $dato_art['codigo'] . "</td>";
                                echo "<td>" . $dato_art['descripcion'] . "</td>";
                                echo "<td>" . nl2br($dato_art['aplicacion']) . "</td>";
                                if(strcasecmp($dato_art['estado'],'A')==0)
                                {
                                    echo "<td>ACTIVO</td>";
                                }
                                elseif(strcasecmp($dato_art['estado'],'I')==0)
                                {
                                    echo "<td>INACTIVO</td>";
                                }
                                echo "<td>" . $dato_art['fecha_alta'] . "</td>";
                                echo "<td><a type='button' class='btn btn-primary' href='ver_articulo_modificacion.php?ida=" . $id_art ."'>Modificar</a></td>";
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
<script>
    function conMayusculas(field)
    {
        field.value = field.value.toUpperCase();
    }
</script>


</body>
</html>