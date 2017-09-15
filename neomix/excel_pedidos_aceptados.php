<?php

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Pedidos_aceptados.xls");

include("Conexion.php");

$fecha_inicial=$_GET['fi'];
$fecha_final=$_GET['ff'];

$query_pedidos = "SELECT * FROM pedidos WHERE estado='A' AND fecha BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY costo_total;";
$resultado_pedidos = mysql_query($query_pedidos, $conex);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PEDIDOS ACEPTADOS</title>
</head>
<body>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="6"><CENTER><strong>REPORTE DE PEDIDOS ACEPTADOS</strong></CENTER></td>
    </tr>
    <tr>
        <td bgcolor="#adff2f"><strong>Numero de cliente</strong></td>
        <td bgcolor="#adff2f"><strong>Nombre o razon social</strong></td>
        <td bgcolor="#adff2f"><strong>Fecha de realizacion del pedido</strong></td>
        <td bgcolor="#adff2f"><strong>Fecha de entrega solicitado</strong></td>
        <td bgcolor="#adff2f"><strong>Lugar de entrega solicitado</strong></td>
        <td bgcolor="#adff2f"><strong>Costo del pedido</strong></td>
    </tr>

    <?PHP

    while($res=mysql_fetch_array($resultado_pedidos)){
        $id_cliente=$res['id_cliente'];
        $query_cliente="SELECT * FROM clientes WHERE id_cliente='$id_cliente'";
        $resultado_cliente=mysql_query($query_cliente,$conex);
        $dato_cliente=mysql_fetch_array($resultado_cliente);

        $nomraz="";
        if(strcasecmp($dato_cliente['nombres'],'')==0)
        {
            $nomraz=$dato_cliente['razon_social'];
        }
        elseif(strcasecmp($dato_cliente['nombres'],'')!=0)
        {
            $nomraz=$dato_cliente['nombres']." ".$dato_cliente['apellidos'];
        }
        ?>
        <tr>
            <td><?php echo $dato_cliente['num_cliente']; ?></td>
            <td><?php echo $nomraz; ?></td>
            <td><?php echo $res['fecha']; ?></td>
            <td><?php echo $res['fecha_entrega_sol']; ?></td>
            <td><?php echo $res['lugar_entrega_sol']; ?></td>
            <td><?php echo $res['costo_total']; ?></td>
        </tr>
        <?php
    }
    ?>
</table>
</body>
</html>