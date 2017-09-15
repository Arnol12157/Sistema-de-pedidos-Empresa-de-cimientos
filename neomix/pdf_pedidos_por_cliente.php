<?php

require_once("../assets/dompdf/dompdf_config.inc.php");

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

$codigoHTML='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="9"><CENTER><strong>PEDIDOS POR CLIENTE</strong></CENTER></td>
  </tr>
  <tr bgcolor="#adff2f">
    <td><strong>Estado</strong></td>
    <td><strong>Fecha del pedido</strong></td>
    <td><strong>Nombre o razon social</strong></td>
    <td><strong>NIT</strong></td>
    <td><strong>Fecha de entrega solicitada</strong></td>
    <td><strong>Lugar de entrega solicitada</strong></td>
    <td><strong>Fecha de entrega comprometido</strong></td>
    <td><strong>Lugar de entrega convenido</strong></td>
    <td><strong>Costo del pedido</strong></td>
  </tr>';

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

    $codigoHTML.='
	<tr>
		<td>'.$res['estado'].'</td>
		<td>'.$res['fecha'].'</td>
		<td>'.$res['razon_social'].'</td>
		<td>'.$res['nit'].'</td>
		<td>'.$res['fecha_entrega_sol'].'</td>
		<td>'.$res['lugar_entrega_sol'].'</td>
		<td>'.$dato_com['fecha_com'].'</td>
		<td>'.$res['lugar_convenido'].'</td>
		<td>'.$res['costo_total'].'</td>
	</tr>';

}
$codigoHTML.='
</table>
</body>
</html>';
$codigoHTML=utf8_encode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("Pedidos_pendientes.pdf");
?>