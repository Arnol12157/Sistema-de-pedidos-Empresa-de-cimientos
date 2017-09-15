<?php

require_once("../assets/dompdf/dompdf_config.inc.php");

include("Conexion.php");

$fecha_inicial=$_GET['fi'];
$fecha_final=$_GET['ff'];

$query_reporte = "SELECT * FROM entregas WHERE estado='E' AND fecha_hora_entrega BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY fecha_hora_entrega;";
$resultado_reporte = mysql_query($query_reporte, $conex);

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
    <td colspan="6"><CENTER><strong>ENTREGAS REALIZADAS</strong></CENTER></td>
  </tr>
  <tr bgcolor="#adff2f">
    <td><strong>Fecha y hora de la entrega realizada</strong></td>
    <td><strong>Distribuidor</strong></td>
    <td><strong>Numero de cliente</strong></td>
    <td><strong>Nombre o razon social</strong></td>
    <td><strong>Nombre del receptor</strong></td>
    <td><strong>CI del receptor</strong></td>
  </tr>';

while($res=mysql_fetch_array($resultado_reporte)){
    $id_cliente_re=$res['id_cliente'];
    $query_cliente_re = "SELECT * FROM clientes WHERE id_cliente=$id_cliente_re;";
    $resultado_cliente_re = mysql_query($query_cliente_re, $conex);
    $row_cliente_re=mysql_fetch_array($resultado_cliente_re);
    $id_entrega=$res['id_entrega'];

    $nombre_cl="";

    if(strcasecmp($id_cliente_re,'00000')==0 || strcasecmp($id_cliente_re,'99999')==0)
    {
        $nombre_cl=$id_cliente_re;
    }
    else
    {
        $nombre_cl=$row_cliente_re['num_cliente'];
    }

    $nomraz="";
    if(strcasecmp($row_cliente_re['nombres'],'')==0)
    {
        $nomraz=$row_cliente_re['razon_social'];
    }
    elseif(strcasecmp($row_cliente_re['nombres'],'')!=0)
    {
        $nomraz=$row_cliente_re['nombres']." ".$row_cliente_re['apellidos'];
    }

    $codigoHTML.='
	<tr>
		<td>'.$res['fecha_hora_entrega'].'</td>
		<td>'.$res['codigo_distribuidor_final'].'</td>
		<td>'.$nombre_cl.'</td>
		<td>'.$nomraz.'</td>
		<td>'.$res['nombre_receptor'].'</td>
		<td>'.$res['ci_receptor'].'</td>
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
$dompdf->stream("Entregas_realizadas.pdf");
?>