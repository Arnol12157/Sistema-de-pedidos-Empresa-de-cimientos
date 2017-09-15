<?php

require_once("../assets/dompdf/dompdf_config.inc.php");

include("Conexion.php");

$clientes_estado=$_GET['est'];
$numero_inicial=$_GET['ni'];
$numero_final=$_GET['nf'];
$query_clientes = "SELECT * FROM clientes WHERE estado='$clientes_estado' AND id_cliente BETWEEN '$numero_inicial' AND '$numero_final' ORDER BY num_cliente;";
$resultado_clientes = mysql_query($query_clientes, $conex);

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
    <td colspan="9"><CENTER><strong>CLIENTES POR ESTADO</strong></CENTER></td>
  </tr>
  <tr bgcolor="#adff2f">
    <td><strong>Numero de cliente</strong></td>
    <td><strong>Nombre o Razon social</strong></td>
    <td><strong>Tipo de cliente</strong></td>
    <td><strong>Direccion</strong></td>
    <td><strong>Zona</strong></td>
    <td><strong>Telefono</strong></td>
    <td><strong>Email</strong></td>
    <td><strong>Categoria</strong></td>
    <td><strong>Fecha de ultimo pedido</strong></td>
  </tr>';

while($res=mysql_fetch_array($resultado_clientes)){

    $nombre_em="";
    $nomape="";

    if(strcasecmp($res['nombres'],'')==0)
    {
        $nombre_em="EMPRESA";
        $nomape=$res['razon_social'];
    }
    elseif(strcasecmp($res['nombres'],'')!=0)
    {
        $nombre_em="PARTICULAR";
        $nomape=$res['nombres']." ".$res['apellidos'];
    }

    $codigoHTML.='
	<tr>
		<td>'.$res['num_cliente'].'</td>
		<td>'.$nomape.'</td>
		<td>'.$nombre_em.'</td>
		<td>'.$res['direccion'].'</td>
		<td>'.$res['zona'].'</td>
		<td>'.$res['telefonos'].'</td>
		<td>'.$res['email'].'</td>
		<td>'.$res['categoria'].'</td>
		<td>'.$res['fecha_ult_pedido'].'</td>
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
$dompdf->set_paper('a4','landscape'); //Esta línea es para hacer la página del PDF más grande
$dompdf->render();
$dompdf->stream("Clientes_por_estado.pdf");
?>