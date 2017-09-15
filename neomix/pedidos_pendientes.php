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
                self.location = "pedidos_pendientes_pri.php"
              </script>';
}

$query_pedidos = "SELECT * FROM pedidos WHERE estado='P' AND fecha BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY fecha_entrega_sol;";
$resultado_pedidos = mysql_query($query_pedidos, $conex);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pedidos pendientes</title>

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
            <li class="navbar-title">Pedidos pendientes</li>
            <div class="text-right col-md-3">
                <a type="button" class="btn btn-success" href="pdf_pedidos_pendientes.php?fi=<?php echo $fecha_inicial ?>&ff=<?php echo $fecha_final ?>">REPORTE EN PDF</a>
            </div>
        </ul>
        <ul class="nav navbar-nav navbar-left">
            <div class="text-right col-md-3">
                <a type="button" class="btn btn-success" href="excel_pedidos_pendientes.php?fi=<?php echo $fecha_inicial ?>&ff=<?php echo $fecha_final ?>">REPORTE EN EXCEL</a>
            </div>
        </ul>
        <?php include_once("template_navbar1.php");?>

        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Pedidos pendientes
                    </div>
                    <div class="card-body no-padding">
                        <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Numero de cliente</th>
                                <th>Nombre o razon social</th>
                                <th>Fecha de realizacion del pedido</th>
                                <th>Fecha de entrega solicitada</th>
                                <th>Lugar de entrega</th>
                                <th>Costo del pedido</th>
                                <th>Detalle del pedido</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($dato_pedido = mysql_fetch_array($resultado_pedidos))
                            {
                                $id_pedido=$dato_pedido['id_pedido'];
                                $id_cliente=$dato_pedido['id_cliente'];
                                $query_cliente="SELECT * FROM clientes WHERE id_cliente='$id_cliente'";
                                $resultado_cliente=mysql_query($query_cliente,$conex);
                                $dato_cliente=mysql_fetch_array($resultado_cliente);
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
                                echo "<td>" . $dato_pedido['fecha'] . "</td>";
                                echo "<td>" . $dato_pedido['fecha_entrega_sol'] . "</td>";
                                echo "<td>" . $dato_pedido['lugar_entrega_sol'] . "</td>";
                                echo "<td>" . $dato_pedido['costo_total'] . "</td>";
                                echo "<td><a type='button' class='btn btn-primary' href='ver_pedidos_pendientes.php?idp=".$id_pedido."'>Detalle del pedido</a></td>";
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