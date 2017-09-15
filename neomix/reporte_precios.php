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

$cantidad=$_REQUEST['cantidad'];
//$final=$_REQUEST['final'];

//$query_precio = "SELECT * FROM precios WHERE codigo LIKE '[".$inicial."-".$final."]*';";
$query_precio = "SELECT * FROM precios WHERE cantidad='$cantidad';";
$resultado_precio = mysql_query($query_precio, $conex);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reporte de precios</title>

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
            <li class="navbar-title">Reporte de precios</li>
            <div class="text-right col-md-3">
                <a type="button" class="btn btn-success" href="pdf_reporte_precios.php?c=<?php echo $cantidad ?>">REPORTE EN PDF</a>
            </div>
        </ul>
        <ul class="nav navbar-nav navbar-left">
            <div class="text-right col-md-3">
                <a type="button" class="btn btn-success" href="excel_reporte_precios.php?c=<?php echo $cantidad ?>">REPORTE EN EXCEL</a>
            </div>
        </ul>
        <?php include_once("template_navbar1.php");?>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Reporte de precios
                    </div>
                    <div class="card-body no-padding">
                        <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Codigo del articulo</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                                <th>Precio contado a domicilio</th>
                                <th>Precio contado en planta</th>
                                <th>Precio credito a domicilio</th>
                                <th>Precio credito en planta</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($dato_precio = mysql_fetch_array($resultado_precio))
                            {
                                $idcodigo=$dato_precio['codigo_articulo'];
                                $query_idcodigo = "SELECT * FROM articulos WHERE codigo='$idcodigo';";
                                $resultado_idcodigo = mysql_query($query_idcodigo, $conex);
                                $dato_codigo = mysql_fetch_array($resultado_idcodigo);

                                $id_precio=$dato_precio['id_precio'];
                                echo "<tr>";
                                echo "<td>" . $dato_precio['codigo_articulo'] . "</td>";
                                echo "<td>" . $dato_codigo['descripcion'] . "</td>";
                                echo "<td>" . $dato_precio['cantidad'] . "</td>";
                                echo "<td>" . $dato_precio['precio_contado_domicilio'] . "</td>";
                                echo "<td>" . $dato_precio['precio_contado_planta'] . "</td>";
                                echo "<td>" . $dato_precio['precio_credito_domicilio'] . "</td>";
                                echo "<td>" . $dato_precio['precio_credito_planta'] . "</td>";
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