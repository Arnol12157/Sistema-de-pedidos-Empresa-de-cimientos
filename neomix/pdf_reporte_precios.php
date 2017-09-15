<?php

require_once("../assets/dompdf/dompdf_config.inc.php");

include("Conexion.php");

$cantidad=$_REQUEST['c'];

$query_precios = "SELECT * FROM precios WHERE cantidad='$cantidad';";
$resultado_precios = mysql_query($query_precios, $conex);

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
    <td colspan="7"><CENTER><strong>REPORTE DE PRECIOS</strong></CENTER></td>
  </tr>
  <tr bgcolor="#adff2f">
    <td><strong>Codigo del articulo</strong></td>
    <td><strong>Descripcion</strong></td>
    <td><strong>Cantidad</strong></td>
    <td><strong>Precio contado a domicilio</strong></td>
    <td><strong>Precio contado en planta</strong></td>
    <td><strong>Precio credito a domicilio</strong></td>
    <td><strong>Precio credito en planta</strong></td>
  </tr>';

while($res=mysql_fetch_array($resultado_precios)){

  $idcodigo=$res['codigo_articulo'];
  $query_idcodigo = "SELECT * FROM articulos WHERE codigo='$idcodigo';";
  $resultado_idcodigo = mysql_query($query_idcodigo, $conex);
  $dato_codigo = mysql_fetch_array($resultado_idcodigo);

    $codigoHTML.='
	<tr>
		<td>'.$res['codigo_articulo'].'</td>
		<td>'.$dato_codigo['descripcion'].'</td>
		<td>'.$res['cantidad'].'</td>
		<td>'.$res['precio_contado_domicilio'].'</td>
		<td>'.$res['precio_contado_planta'].'</td>
		<td>'.$res['precio_credito_domicilio'].'</td>
		<td>'.$res['precio_credito_planta'].'</td>
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
$dompdf->stream("Reporte_precios.pdf");
?>