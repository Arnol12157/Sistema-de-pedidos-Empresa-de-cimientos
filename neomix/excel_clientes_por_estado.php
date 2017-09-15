<?php

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Clientes_por_estado.xls");

include("Conexion.php");

$clientes_estado=$_GET['est'];
$numero_inicial=$_GET['ni'];
$numero_final=$_GET['nf'];
$query_clientes = "SELECT * FROM clientes WHERE estado='$clientes_estado' AND id_cliente BETWEEN '$numero_inicial' AND '$numero_final' ORDER BY num_cliente;";
$resultado_clientes = mysql_query($query_clientes, $conex);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>CLIENTES POR ESTADO</title>
</head>
<body>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="9"><CENTER><strong>REPORTE DE CLIENTES POR ESTADO</strong></CENTER></td>
    </tr>
    <tr>
        <td bgcolor="#adff2f"><strong>Numero de cliente</strong></td>
        <td bgcolor="#adff2f"><strong>Nombre o Razon social</strong></td>
        <td bgcolor="#adff2f"><strong>Tipo de cliente</strong></td>
        <td bgcolor="#adff2f"><strong>Direccion</strong></td>
        <td bgcolor="#adff2f"><strong>Zona</strong></td>
        <td bgcolor="#adff2f"><strong>Telefono</strong></td>
        <td bgcolor="#adff2f"><strong>Email</strong></td>
        <td bgcolor="#adff2f"><strong>Categoria</strong></td>
        <td bgcolor="#adff2f"><strong>Fecha de ultimo pedido</strong></td>
    </tr>

    <?PHP

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
        ?>
        <tr>
            <td><?php echo $res['num_cliente']; ?></td>
            <td><?php echo $nomape; ?></td>
            <td><?php echo $nombre_em; ?></td>
            <td><?php echo $res['direccion']; ?></td>
            <td><?php echo $res['zona']; ?></td>
            <td><?php echo $res['telefonos']; ?></td>
            <td><?php echo $res['email']; ?></td>
            <td><?php echo $res['categoria']; ?></td>
            <td><?php echo $res['fecha_ult_pedido']; ?></td>
        </tr>
        <?php
    }
    ?>
</table>
</body>
</html>