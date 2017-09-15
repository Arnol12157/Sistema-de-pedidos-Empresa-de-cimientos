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

$fecha_inicial=$_REQUEST['fecha_inicial'];
$fecha_final=$_REQUEST['fecha_final'];

if(empty($fecha_final) || empty($fecha_inicial))
{
    echo '<script language = javascript>
                alert("Seleccione un rango de fechas para ver el reporte")
                self.location = "entregas_programadas_pri.php"
              </script>';
}

//$query_pedidos = "SELECT * FROM pedidos WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY fecha_entrega_sol;";  AND detalle_pedido.fecha_com BETWEEN '$fecha_inicial' AND '$fecha_final'

$query_reporte = "SELECT entregas.codigo_distribuidor_asignado, detalle_pedido.fecha_com, entregas.id_pedido
                  FROM entregas LEFT JOIN detalle_pedido ON entregas.id_pedido=detalle_pedido.id_pedido
                  WHERE entregas.estado='T' AND detalle_pedido.cantidad_pro!=0 AND detalle_pedido.fecha_com BETWEEN '$fecha_inicial' AND '$fecha_final'
                  GROUP BY entregas.id_pedido
                  ORDER BY detalle_pedido.fecha_com;";
$resultado_reporte = mysql_query($query_reporte, $conex);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Entregas programadas</title>

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
            <li class="navbar-title">Entregas programadas</li>
            <div class="text-right col-md-5">
                <a type="button" class="btn btn-success" href="pdf_entregas_programadas.php?fi=<?php echo $fecha_inicial ?>&ff=<?php echo $fecha_final ?>">REPORTE EN PDF</a>
            </div>
        </ul>
        <ul class="nav navbar-nav navbar-left">
            <div class="text-right col-md-3">
                <a type="button" class="btn btn-success" href="excel_entregas_programadas.php?fi=<?php echo $fecha_inicial ?>&ff=<?php echo $fecha_final ?>">REPORTE EN EXCEL</a>
            </div>
        </ul>
        <?php include_once("template_navbar1.php");?>

        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Entregas programadas
                    </div>
                    <div class="card-body no-padding">
                        <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Codigo de distribuidor</th>
                                <th>Nombre o razon social</th>
                                <th>Fecha de entrega comprometida</th>
                                <th>Lugar de entrega comprometido</th>
                                <th>Hora de entrega aproximada</th>
                                <th>Detalle del pedido</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($dato_reporte = mysql_fetch_array($resultado_reporte))
                            {
                                $id_pedido=$dato_reporte['id_pedido'];
                                $query_cli_reporte = "SELECT * FROM pedidos WHERE id_pedido='$id_pedido';";
                                $resultado_cli_reporte = mysql_query($query_cli_reporte, $conex);
                                $dato_cli_rep=mysql_fetch_array($resultado_cli_reporte);
                                if(strcasecmp($dato_cli_rep['estado'],'X')!=0)
                                {
                                    echo "<tr>";
                                    echo "<td>" . $dato_reporte['codigo_distribuidor_asignado'] . "</td>";


                                    $id_cli_rep=$dato_cli_rep['id_cliente'];
                                    $query_cli_fin = "SELECT * FROM clientes WHERE id_cliente='$id_cli_rep';";
                                    $resultado_cli_fin = mysql_query($query_cli_fin, $conex);
                                    $dato_cli_fin=mysql_fetch_array($resultado_cli_fin);
                                    if(strcasecmp($dato_cli_fin['nombres'],'')==0)
                                    {
                                        echo "<td>" . $dato_cli_fin['razon_social'] . "</td>";
                                    }
                                    elseif(strcasecmp($dato_cli_fin['nombres'],'')!=0)
                                    {
                                        echo "<td>" . $dato_cli_fin['nombres'] . " " . $dato_cli_fin['apellidos'] . "</td>";
                                    }
                                    echo "<td>" . $dato_reporte['fecha_com'] . "</td>";
                                    echo "<td>" . $dato_cli_rep['lugar_convenido'] . "</td>";
                                    echo "<td>" . $dato_cli_rep['hora_entrega'] . "</td>";
                                    echo "<td><a type='button' class='btn btn-primary' href='ver_entregas_programadas.php?idp=".$id_pedido."'>Detalle del pedido</a></td>";
                                    echo "</tr>";
                                }
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