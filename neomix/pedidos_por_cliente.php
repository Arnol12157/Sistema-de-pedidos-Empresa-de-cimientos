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

$codigo=$_REQUEST['codigo'];
$fecha_inicial=$_REQUEST['fecha_inicial'];
$fecha_final=$_REQUEST['fecha_final'];
$estado_pedido=$_REQUEST['estado_pedido'];

if(empty($fecha_final) || empty($fecha_inicial) || empty($codigo))
{
    echo '<script language = javascript>
                alert("Seleccione un rango de fechas para ver el reporte o introduzca un codigo de cliente")
                self.location = "pedidos_por_cliente_pri.php"
              </script>';
}

$codigo=str_pad($codigo, 5, '0', STR_PAD_LEFT);
$query_cli="SELECT * FROM clientes WHERE num_cliente='$codigo'";
$resultado_cli=mysql_query($query_cli,$conex);
$dato_cli=mysql_fetch_array($resultado_cli);
$idcli=$dato_cli['id_cliente'];
if(strcasecmp($estado_pedido,'T')==0)
{
    $query_pedidos = "SELECT * FROM pedidos WHERE id_cliente='$idcli' AND fecha BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY fecha_entrega_sol;";
}
else
{
    $query_pedidos = "SELECT * FROM pedidos WHERE id_cliente='$idcli' AND estado='$estado_pedido' AND fecha BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY fecha_entrega_sol;";
}
$resultado_pedidos = mysql_query($query_pedidos, $conex);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pedidos por cliente</title>

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
            <li class="navbar-title">Pedidos por cliente</li>
            <div class="text-right col-md-3">
                <a type="button" class="btn btn-success" href="pdf_pedidos_por_cliente.php?ep=<?php echo $estado_pedido ?>&co=<?php echo $codigo ?>&fi=<?php echo $fecha_inicial ?>&ff=<?php echo $fecha_final ?>">REPORTE EN PDF</a>
            </div>
        </ul>
        <ul class="nav navbar-nav navbar-left">
            <div class="text-right col-md-3">
                <a type="button" class="btn btn-success" href="excel_pedidos_por_cliente.php?ep=<?php echo $estado_pedido ?>&co=<?php echo $codigo ?>&fi=<?php echo $fecha_inicial ?>&ff=<?php echo $fecha_final ?>">REPORTE EN EXCEL</a>
            </div>
        </ul>
        <?php include_once("template_navbar1.php");?>

        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Pedidos por cliente
                    </div>
                    <div class="card-body no-padding">
                        <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Estado</th>
                                <th>Fecha del pedido</th>
                                <th>Nombre o razon social</th>
                                <th>NIT</th>
                                <th>Fecha de entrega solicitada</th>
                                <th>Lugar de entrega solicitado</th>
                                <th>Fecha de entrega comprometido</th>
                                <th>Lugar de entrega convenido</th>
                                <th>Costo del pedido</th>
                                <th>Detalle del pedido</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($dato_pedido = mysql_fetch_array($resultado_pedidos))
                            {
                                $id_pedido=$dato_pedido['id_pedido'];
                                //$id_cliente=$dato_pedido['id_cliente'];
                                $query_com="SELECT * FROM detalle_pedido WHERE id_pedido='$id_pedido'";
                                $resultado_com=mysql_query($query_com,$conex);
                                $dato_com=mysql_fetch_array($resultado_com);
                                echo "<tr>";
                                echo "<td>" . $dato_pedido['estado'] . "</td>";
                                echo "<td>" . $dato_pedido['fecha'] . "</td>";

                                if(strcasecmp($dato_cli['nombres'],'')==0)
                                {
                                    $nombre_em="EMPRESA";
                                    $nomape=$dato_cli['razon_social'];
                                }
                                elseif(strcasecmp($dato_cli['nombres'],'')!=0)
                                {
                                    $nombre_em="PARTICULAR";
                                    $nomape=$dato_cli['nombres']." ".$dato_cli['apellidos'];
                                }

                                echo "<td>" . $dato_pedido['razon_social'] . "</td>";
                                echo "<td>" . $dato_pedido['nit'] . "</td>";
                                echo "<td>" . $dato_pedido['fecha_entrega_sol'] . "</td>";
                                echo "<td>" . $dato_pedido['lugar_entrega_sol'] . "</td>";
                                echo "<td>" . $dato_com['fecha_com'] . "</td>";
                                echo "<td>" . $dato_pedido['lugar_convenido'] . "</td>";
                                echo "<td>" . $dato_pedido['costo_total'] . "</td>";
                                echo "<td><a type='button' class='btn btn-primary' href='ver_pedidos_por_cliente.php?idp=".$id_pedido."'>Detalle del pedido</a></td>";
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