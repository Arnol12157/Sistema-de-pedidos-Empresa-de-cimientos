<?php

require_once("../assets/dompdf/dompdf_config.inc.php");

include("Conexion.php");

$id_entrega=$_GET['ide'];
$query_entrega = "SELECT * FROM entregas WHERE id_entrega='$id_entrega';";
$resultado_entrega = mysql_query($query_entrega, $conex);
$row_entrega=mysql_fetch_array($resultado_entrega);

$query_detalle_entrega = "SELECT * FROM detalle_entrega WHERE id_entrega='$id_entrega';";
$resultado_detalle_entrega = mysql_query($query_detalle_entrega, $conex);

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
    <td colspan="2" bgcolor="#adff2f"><CENTER><strong>DETALLE ENTREGAS REALIZADAS</strong></CENTER></td>
  </tr>
  <tr>
    <td><strong>Fecha y hora de la entrega</strong></td>
    <td><strong>'.$row_entrega['fecha_hora_entrega'].'</strong></td>
  </tr>
  <tr>
    <td><strong>Nombre del receptor</strong></td>
    <td><strong>'.$row_entrega['nombre_receptor'].'</strong></td>
  </tr>
  <tr>
    <td><strong>CI del receptor</strong></td>
    <td><strong>'.$row_entrega['ci_receptor'].'</strong></td>
  </tr>
  <tr>
    <td><strong>Numero de remito</strong></td>
    <td><strong>'.$row_entrega['numero_remito'].'</strong></td>
  </tr>
  <tr>
    <td><strong>Numero de factura</strong></td>
    <td><strong>'.$row_entrega['numero_factura'].'</strong></td>
  </tr>
  <tr>
    <td><strong>Codigo del distribuidor</strong></td>
    <td><strong>'.$row_entrega['codigo_distribuidor_final'].'</strong></td>
  </tr>';
$codigoHTML.='
</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr bgcolor="#adff2f">
    <td><strong>Descripcion</strong></td>
    <td><strong>Precio</strong></td>
    <td><strong>Cantidad entregada</strong></td>
    <td><strong>Monto</strong></td>
  </tr>';
$suma=0;
while($dato_detalle_entrega = mysql_fetch_array($resultado_detalle_entrega)){
    $codigo_articulo=$dato_detalle_entrega['articulo'];
    $query_artiulo = "SELECT * FROM articulos WHERE codigo='$codigo_articulo';";
    $resultado_articulo = mysql_query($query_artiulo, $conex);
    $row_articulo=mysql_fetch_array($resultado_articulo);


    $codigoHTML.='
	<tr>
		<td>'.$row_articulo['descripcion'].'</td>
		<td>'.$dato_detalle_entrega['precio_venta'].'</td>
		<td>'.$dato_detalle_entrega['cantidad_entregada'].'</td>
		<td>'.$dato_detalle_entrega['monto'].'</td>
	</tr>';
    $suma=$suma+$dato_detalle_entrega['monto'];
}
$codigoHTML.='
    <tr>
        <td></td>
        <td></td>
        <td>Total:</td>
        <td>'.number_format((float)$suma,2,'.','').'</td>
    </tr>
</table>
</body>
</html>';
$codigoHTML=utf8_encode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("Detalle_entregas_realizadas.pdf");
?>