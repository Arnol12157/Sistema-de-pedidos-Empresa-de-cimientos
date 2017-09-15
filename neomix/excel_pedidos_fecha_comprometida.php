<?php

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Pedidos_fecha_comprometida.xls");

include("Conexion.php");

$fecha_inicial=$_GET['fi'];
$fecha_final=$_GET['ff'];

$query_pedidos = "SELECT * FROM pedidos WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND (estado='P' OR estado='A' OR estado='R' OR estado='X') ORDER BY fecha_entrega_sol;";
$resultado_pedidos = mysql_query($query_pedidos, $conex);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PEDIDOS POR FECHA COMPROMETIDA</title>
</head>
<body>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="9"><CENTER><strong>REPORTE DE PEDIDOS POR FECHA COMPROMETIDA</strong></CENTER></td>
    </tr>
    <tr>
        <td bgcolor="#adff2f"><strong>Numero de cliente</strong></td>
        <td bgcolor="#adff2f"><strong>Nombre o razon social</strong></td>
        <td bgcolor="#adff2f"><strong>Fecha de realizacion del pedido</strong></td>
        <td bgcolor="#adff2f"><strong>Fecha de entrega solicitado</strong></td>
        <td bgcolor="#adff2f"><strong>Lugar de entrega solicitado</strong></td>
        <td bgcolor="#adff2f"><strong>Fecha de entrega comprometido</strong></td>
        <td bgcolor="#adff2f"><strong>Lugar de entrega comprometido</strong></td>
        <td bgcolor="#adff2f"><strong>Costo del pedido</strong></td>
        <td bgcolor="#adff2f"><strong>Estado</strong></td>
    </tr>

    <?PHP

    while($res=mysql_fetch_array($resultado_pedidos)){
        $id_pedido=$res['id_pedido'];
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

        $estado_mostrar="";
        if(strcasecmp($res['estado'],'P')==0)
        {
            $estado_mostrar="PENDIENTE";
        }
        elseif(strcasecmp($res['estado'],'A')==0)
        {
            $estado_mostrar="ACEPTADO";
        }
        elseif(strcasecmp($res['estado'],'R')==0)
        {
            $estado_mostrar="RECHAZADO";
        }
        elseif(strcasecmp($res['estado'],'T')==0)
        {
            $estado_mostrar="EN TRANSITO";
        }
        elseif(strcasecmp($res['estado'],'M')==0)
        {
            $estado_mostrar="PARCIALMENTE ENTREGADO";
        }
        elseif(strcasecmp($res['estado'],'C')==0)
        {
            $estado_mostrar="CUMPLIDO";
        }
        elseif(strcasecmp($res['estado'],'X')==0)
        {
            $estado_mostrar="CANCELADO";
        }

        $query_minfecha="SELECT * FROM detalle_pedido WHERE id_pedido='$id_pedido' AND fecha_com=(SELECT MIN(fecha_com) FROM detalle_pedido WHERE id_pedido='$id_pedido');";
        $resultado_minfecha=mysql_query($query_minfecha,$conex);
        $dato_minfecha=mysql_fetch_array($resultado_minfecha);

        ?>
        <tr>
            <td><?php echo $dato_cliente['num_cliente']; ?></td>
            <td><?php echo $nomraz; ?></td>
            <td><?php echo $res['fecha']; ?></td>
            <td><?php echo $res['fecha_entrega_sol']; ?></td>
            <td><?php echo $res['lugar_entrega_sol']; ?></td>
            <td><?php echo $dato_minfecha['fecha_com']; ?></td>
            <td><?php echo $res['lugar_convenido']; ?></td>
            <td><?php echo $res['costo_total']; ?></td>
            <td><?php echo $estado_mostrar; ?></td>
        </tr>
        <?php
    }
    ?>
</table>
</body>
</html>