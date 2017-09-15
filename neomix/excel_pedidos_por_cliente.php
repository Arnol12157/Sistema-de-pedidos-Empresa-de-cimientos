<?php

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Pedidos_por_cliente.xls");

include("Conexion.php");

$codigo=$_REQUEST['co'];
$fecha_inicial=$_GET['fi'];
$fecha_final=$_GET['ff'];
$estado_pedido=$_REQUEST['ep'];

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
//$query_pedidos = "SELECT * FROM pedidos WHERE estado='P' AND fecha BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY fecha_entrega_sol;";
//$resultado_pedidos = mysql_query($query_pedidos, $conex);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PEDIDOS POR CLIENTE</title>
</head>
<body>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="9"><CENTER><strong>REPORTE DE PEDIDOS POR CLIENTE</strong></CENTER></td>
    </tr>
    <tr>
        <td bgcolor="#adff2f"><strong>Estado</strong></td>
        <td bgcolor="#adff2f"><strong>Fecha del pedido</strong></td>
        <td bgcolor="#adff2f"><strong>Nombre o razon social</strong></td>
        <td bgcolor="#adff2f"><strong>NIT</strong></td>
        <td bgcolor="#adff2f"><strong>Fecha de entrega solicitada</strong></td>
        <td bgcolor="#adff2f"><strong>Lugar de entrega solicitado</strong></td>
        <td bgcolor="#adff2f"><strong>Fecha de entrega comprometido</strong></td>
        <td bgcolor="#adff2f"><strong>Lugar de entrega convenido</strong></td>
        <td bgcolor="#adff2f"><strong>Costo del pedido</strong></td>
    </tr>

    <?PHP

    while($res=mysql_fetch_array($resultado_pedidos)){
        $id_pedido=$res['id_pedido'];
        //$id_cliente=$dato_pedido['id_cliente'];
        $query_com="SELECT * FROM detalle_pedido WHERE id_pedido='$id_pedido'";
        $resultado_com=mysql_query($query_com,$conex);
        $dato_com=mysql_fetch_array($resultado_com);

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

        ?>
        <tr>
            <td><?php echo $res['estado']; ?></td>
            <td><?php echo $res['fecha']; ?></td>
            <td><?php echo $res['razon_social']; ?></td>
            <td><?php echo $res['nit']; ?></td>
            <td><?php echo $res['fecha_entrega_sol']; ?></td>
            <td><?php echo $res['lugar_entrega_sol']; ?></td>
            <td><?php echo $dato_com['fecha_com']; ?></td>
            <td><?php echo $res['lugar_convenido']; ?></td>
            <td><?php echo $res['costo_total']; ?></td>
        </tr>
        <?php
    }
    ?>
</table>
</body>
</html>