<?php

require_once("../assets/dompdf/dompdf_config.inc.php");

include("Conexion.php");

$fecha_inicial=$_GET['fi'];
$fecha_final=$_GET['ff'];

$query_pedidos = "SELECT * FROM pedidos WHERE estado='A' AND fecha BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY costo_total;";
$resultado_pedidos = mysql_query($query_pedidos, $conex);

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
    <td colspan="6"><CENTER><strong>PEDIDOS ACEPTADOS</strong></CENTER></td>
  </tr>
  <tr bgcolor="#adff2f">
    <td><strong>Numero de cliente</strong></td>
    <td><strong>Nombre o razon social</strong></td>
    <td><strong>Fecha de realizacion del pedido</strong></td>
    <td><strong>Fecha de entrega solicitada</strong></td>
    <td><strong>Lugar de entrega</strong></td>
    <td><strong>Costo del pedido</strong></td>
  </tr>';

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

    $codigoHTML.='
	<tr>
		<td>'.$dato_cliente['num_cliente'].'</td>
		<td>'.$nomraz.'</td>
		<td>'.$res['fecha'].'</td>
		<td>'.$res['fecha_entrega_sol'].'</td>
		<td>'.$res['lugar_entrega_sol'].'</td>
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
$dompdf->stream("Pedidos_aceptados.pdf");
?>