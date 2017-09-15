<?php

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Reporte_precios.xls");

include("Conexion.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>REPORTE DE PRECIOS</title>
</head>
<body>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="7"><CENTER><strong>REPORTE DE PRECIOS</strong></CENTER></td>
    </tr>
    <tr>
        <td bgcolor="#adff2f"><strong>Codigo del articulo</strong></td>
        <td bgcolor="#adff2f"><strong>Descripcion</strong></td>
        <td bgcolor="#adff2f"><strong>Cantidad</strong></td>
        <td bgcolor="#adff2f"><strong>Precio contado a domicilio</strong></td>
        <td bgcolor="#adff2f"><strong>Precio contado en planta</strong></td>
        <td bgcolor="#adff2f"><strong>Precio credito a domicilio</strong></td>
        <td bgcolor="#adff2f"><strong>Precio credito en planta</strong></td>
    </tr>

    <?PHP

    $cantidad=$_REQUEST['c'];

    $query_precios = "SELECT * FROM precios WHERE cantidad='$cantidad';";

    $resultado_precios = mysql_query($query_precios, $conex);
    while($res=mysql_fetch_array($resultado_precios)){

        $idcodigo=$res['codigo_articulo'];
        $query_idcodigo = "SELECT * FROM articulos WHERE codigo='$idcodigo';";
        $resultado_idcodigo = mysql_query($query_idcodigo, $conex);
        $dato_codigo = mysql_fetch_array($resultado_idcodigo);

        ?>
        <tr>
            <td><?php echo $res['codigo_articulo']; ?></td>
            <td><?php echo $dato_codigo['descripcion']; ?></td>
            <td><?php echo $res['cantidad']; ?></td>
            <td><?php echo $res['precio_contado_domicilio']; ?></td>
            <td><?php echo $res['precio_contado_planta']; ?></td>
            <td><?php echo $res['precio_credito_domicilio']; ?></td>
            <td><?php echo $res['precio_credito_planta']; ?></td>
        </tr>
        <?php
    }
    ?>
</table>
</body>
</html>