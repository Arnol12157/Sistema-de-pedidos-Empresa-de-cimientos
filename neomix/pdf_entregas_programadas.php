<?php

require_once("../assets/dompdf/dompdf_config.inc.php");

include("Conexion.php");

$fecha_inicial=$_GET['fi'];
$fecha_final=$_GET['ff'];

$query_reporte = "SELECT entregas.codigo_distribuidor_asignado, detalle_pedido.fecha_com, entregas.id_pedido
                  FROM entregas LEFT JOIN detalle_pedido ON entregas.id_pedido=detalle_pedido.id_pedido
                  WHERE entregas.estado='T' AND detalle_pedido.cantidad_pro!=0 AND detalle_pedido.fecha_com BETWEEN '$fecha_inicial' AND '$fecha_final'
                  GROUP BY entregas.id_pedido
                  ORDER BY detalle_pedido.fecha_com;";
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
    <td colspan="5"><CENTER><strong>ENTREGAS PROGRAMADAS</strong></CENTER></td>
  </tr>
  <tr bgcolor="#adff2f">
    <td><strong>Codigo de distribuidor</strong></td>
    <td><strong>Nombre o razon social</strong></td>
    <td><strong>Fecha de entrega comprometida</strong></td>
    <td><strong>Lugar de entrega comprometido</strong></td>
    <td><strong>Hora de entrega aproximada</strong></td>
  </tr>';

while($res=mysql_fetch_array($resultado_reporte)){

    $id_pedido=$res['id_pedido'];

    $query_cli_reporte = "SELECT * FROM pedidos WHERE id_pedido='$id_pedido';";
    $resultado_cli_reporte = mysql_query($query_cli_reporte, $conex);
    $dato_cli_rep=mysql_fetch_array($resultado_cli_reporte);

    $id_cli_rep=$dato_cli_rep['id_cliente'];
    $query_cli_fin = "SELECT * FROM clientes WHERE id_cliente='$id_cli_rep';";
    $resultado_cli_fin = mysql_query($query_cli_fin, $conex);
    $dato_cli_fin=mysql_fetch_array($resultado_cli_fin);
    $in_nom_cli="";
    if(strcasecmp($dato_cli_fin['nombres'],'')==0)
    {
        $in_nom_cli=$dato_cli_fin['razon_social'];
    }
    elseif(strcasecmp($dato_cli_fin['nombres'],'')!=0)
    {
        $in_nom_cli=$dato_cli_fin['nombres'] . " " . $dato_cli_fin['apellidos'];
    }

    if(strcasecmp($dato_cli_rep['estado'],'X')!=0)
    {
        $codigoHTML .= '
        <tr>
            <td>' . $res['codigo_distribuidor_asignado'] . '</td>
            <td>' . $in_nom_cli . '</td>
            <td>' . $res['fecha_com'] . '</td>
            <td>' . $dato_cli_rep['lugar_convenido'] . '</td>
            <td>' . $dato_cli_rep['hora_entrega'] . '</td>
        </tr>';
    }

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
$dompdf->stream("Entregas_programadas.pdf");
?>