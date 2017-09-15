<?php

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Entregas_realizadas.xls");

include("Conexion.php");

$fecha_inicial=$_GET['fi'];
$fecha_final=$_GET['ff'];

$query_reporte = "SELECT * FROM entregas WHERE estado='E' AND fecha_hora_entrega BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY fecha_hora_entrega;";
$resultado_reporte = mysql_query($query_reporte, $conex);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ENTREGAS REALIZADAS</title>
</head>
<body>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="6"><CENTER><strong>REPORTE DE ENTREGAS REALIZADAS</strong></CENTER></td>
    </tr>
    <tr>
        <td bgcolor="#adff2f"><strong>Fecha y hora de la entrega realizada</strong></td>
        <td bgcolor="#adff2f"><strong>Distribuidor</strong></td>
        <td bgcolor="#adff2f"><strong>Numero de cliente</strong></td>
        <td bgcolor="#adff2f"><strong>Nombre o razon social</strong></td>
        <td bgcolor="#adff2f"><strong>Nombre del receptor</strong></td>
        <td bgcolor="#adff2f"><strong>CI del receptor</strong></td>
    </tr>

    <?PHP

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
        ?>
        <tr>
            <td><?php echo $res['fecha_hora_entrega']; ?></td>
            <td><?php echo $res['codigo_distribuidor_final']; ?></td>
            <td><?php echo $nombre_cl; ?></td>
            <td><?php echo $nomraz; ?></td>
            <td><?php echo $res['nombre_receptor']; ?></td>
            <td><?php echo $res['ci_receptor']; ?></td>
        </tr>
        <?php
    }
    ?>
</table>
</body>
</html>