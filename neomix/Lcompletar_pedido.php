<?php
//Iniciar Sesi?n
session_start();

include("Conexion.php");

//Validar si se est? ingresando con sesi?n correctamente
if (!$_SESSION)
{
    echo '<script language = javascript>
        alert("usuario no autenticado")
        self.location = "login.php"
    </script>';
}

$archivo=fopen("../param.txt","r") or die("Error");
$linea=fgets($archivo);
$datos=explode(";",$linea);

$email_neomix=$datos[4];

fclose($archivo);

//Inicio variables de sesion
$id = $_SESSION['id'];
$nombre = $_SESSION['nombre'];
$email = $_SESSION['email'];
$contra = $_SESSION['contra'];
$clave = $_SESSION['clave'];
$fecha = $_SESSION['fecha'];
$estado = $_SESSION['estado'];

$nit=$_REQUEST['nit'];
$razon_social=$_REQUEST['razon_social'];
$lugar_entrega=$_REQUEST['lugar_entrega'];
//$hora_entrega=$_REQUEST['hora_entrega'];
//$hora_entrega=time()
$id_pedido=$_REQUEST['id_pedido'];
$fecha_comprometida=$_REQUEST['fecha_comprometida'];
$distribuidor=$_REQUEST['distribuidor'];

$idDetalle=$_REQUEST['idDetalle'];
$cantidad=$_REQUEST['cantidad'];
//$fecha_com=$_REQUEST['fechacom'];
//$fecha_com=date("Y-m-d", strtotime($_REQUEST['fechacom']));
$count= count($idDetalle);

if(isset($lugar_entrega) && !empty($lugar_entrega))
{
    $resultado_fecha=mysql_query("SELECT NOW() AS fecha",$conex);
    $row_fecha=mysql_fetch_array($resultado_fecha);
    $fecha=$row_fecha['fecha'];

//    mysql_query("UPDATE pedidos SET nit='$nit', razon_social='$razon_social', lugar_convenido='$lugar_entrega', hora_entrega='$hora_entrega', estado='A' WHERE id_pedido='$id_pedido'",$conex);
    mysql_query("UPDATE pedidos SET nit='$nit', razon_social='$razon_social', lugar_convenido='$lugar_entrega', estado='A', distribuidor='$distribuidor' WHERE id_pedido='$id_pedido'",$conex);

    $sum=0;
    for ( $i = 0 ; $i < $count ; $i++ )
    {
        if($cantidad[$i] !== "0" &&  !empty($cantidad[$i]))
        {
            $resultado_ped=mysql_query("SELECT * FROM detalle_pedido WHERE id_detalle='$idDetalle[$i]'");
            $row_ped=mysql_fetch_array($resultado_ped);
            $monto=$cantidad[$i]*$row_ped['precio_venta'];
//            mysql_query("UPDATE detalle_pedido SET pendiente=$cantidad[$i], monto=$monto, cantidad_com='$cantidad[$i]', fecha_com='$fecha_com[$i]', lugar_com='$lugar_entrega' WHERE id_detalle='$idDetalle[$i]'",$conex);
            mysql_query("UPDATE detalle_pedido SET pendiente=$cantidad[$i], monto=$monto, cantidad_com='$cantidad[$i]', fecha_com='$fecha_comprometida', lugar_com='$lugar_entrega' WHERE id_detalle='$idDetalle[$i]'",$conex);
//            $SQL = "INSERT INTO detalle_pedido VALUES (DEFAULT,'$IdPedido','$descripcion[$i]','$precio[$i]','$monto','$cantidad[$i]','$fecha_entrega','PLANTA','','','','','','','','','')";
//            mysql_query($SQL,$conex);
        }
        $result = mysql_query("SELECT SUM( precio_venta * cantidad_com ) AS total FROM detalle_pedido WHERE id_pedido = '$id_pedido'",$conex);
        $asd = mysql_fetch_array($result);
        $sum = $asd['total'];
        $sql2 = mysql_query("UPDATE pedidos SET costo_total='$sum' WHERE id_pedido='$id_pedido'",$conex);
    }

    $sql3 = mysql_query("SELECT * FROM pedidos WHERE id_pedido='$id_pedido'",$conex);
    $sql3r = mysql_fetch_array($sql3);
    $id_cliente = $sql3r['id_cliente'];
    $sql4 = mysql_query("SELECT * FROM clientes WHERE id_cliente='$id_cliente'",$conex);
    $sql4r = mysql_fetch_array($sql4);
    $email_cliente = $sql4r['email'];
    $codigo_cliente=$sql4r['num_cliente'];
    $nombres_cliente=$sql4r['nombres'];
    $apellidos_cliente=$sql4r['apellidos'];
    $razon_social_cliente=$sql4r['razon_social'];

// obteniendo nuevos datos
$query_pedido = "SELECT * FROM pedidos WHERE id_pedido='$id_pedido';";
$resultado_pedido = mysql_query($query_pedido, $conex);
$row_pedido=mysql_fetch_array($resultado_pedido);
$query_detalle = "SELECT * FROM detalle_pedido WHERE id_pedido='$id_pedido';";
$resultado_detalle = mysql_query($query_detalle, $conex);


    $subject = "Pedido aceptado";
    $headers = "From: noreply@neomixltda.com" . "\r\n";
    $headers .= "Reply-To: infolp@neomixltda.com\r\n";
//$headers .= "Return-Path: infolp@neomixltda.com\r\n";
//$headers .= "CC: infolp@neomixltda.com\r\n";
//$headers .= "BCC: infolp@neomixltda.com\r\n";
    $headers  .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
    $message =  "<!doctype html>
<html>
<head align='center'>
<meta charset='utf-8'>
<title>Untitled Document</title>

</head >
<body align='center'>

<div align='center' >
<p>&nbsp;</p>
<p>Pedido aceptado.</p>
<table align='center' width='90%' border='10'>
  <tbody>
    <tr>
      <td width='32%'>Numero de cliente:</td>
      <td width='68%'>".$codigo_cliente."</td>
    </tr>
    <tr>
      <td width='32%'>Nombre y apellido / Razon social:</td>
      <td width='68%'>".$razon_social_cliente."".$nombres_cliente." ".$apellidos_cliente."</td>
    </tr>
    <tr>
      <td width='32%'>Lugar de entrega solicitado:</td>
      <td width='68%'>".$row_pedido['lugar_entrega_sol']."</td>
    </tr>
    <tr>
      <td width='32%'>Fecha de entrega solicitado:</td>
      <td width='68%'>".$row_pedido['fecha_entrega_sol']."</td>
    </tr>
    <tr>
      <td width='32%'>NIT:</td>
      <td width='68%'>".$row_pedido['nit']."</td>
    </tr>
    <tr>
      <td width='32%'>Nombre o razon social:</td>
      <td width='68%'>".$row_pedido['razon_social']."</td>
    </tr>
    <tr>
      <td width='32%'>Lugar de entrega convenido:</td>
      <td width='68%'>".$row_pedido['lugar_convenido']."</td>
    </tr>
    <tr>
      <td width='32%'>Fecha de entrega comprometida:</td>
      <td width='68%'>".$fecha_comprometida."</td>
    </tr>
    <tr>
      <td width='32%'>Codigo de distribuidor:</td>
      <td width='68%'>".$distribuidor."</td>
    </tr>
  </tbody>
</table>
<br>
<table align='center' width='90%' border='10'>
    <thead>
        <tr>
            <th>Codigo</th>
            <th>Descripcion</th>
            <th>Precio</th>
            <th>Cantidad solicitada</th>
            <th>Monto</th>
        </tr>
    </thead>
    <tbody>";
            $suma=0;
            $suma_cantidad=0;
            while ($dato_detalle = mysql_fetch_array($resultado_detalle))
            {
                $suma+=$dato_detalle['monto'];
                $suma_cantidad+=$dato_detalle['cantidad_sol'];
                $id_articulo=$dato_detalle['articulo'];
                $query_articulo = "SELECT * FROM articulos WHERE codigo='$id_articulo';";
                $resultado_articulo = mysql_query($query_articulo, $conex);
                $row_articulo=mysql_fetch_array($resultado_articulo);
                $message.="<tr>";
                $message.= "<td>".$id_articulo."</td>";
                $message.= "<td>".$row_articulo['descripcion']."</td>";
                $message.= "<td>".$dato_detalle['precio_venta']."</td>";
                $message.= "<td>".$dato_detalle['cantidad_sol']."</td>";
                $message.= "<td>".$dato_detalle['monto']."</td>";
                $message.= "</tr>";
            }
$message.= "
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>Total: ".$suma_cantidad."</td>
            <td>Total: ".$suma."</td>
            <td></td>
        </tr>
    </tbody>
</table>
<br>
<br>
<p>&nbsp;</p>
<p>GRACIAS POR SU PEDIDO</p>
<p>NEOMIX LTDA</p>
</div>
</body>
</html>

";

    mail($email_cliente,$subject,$message,$headers) ;
//    mail($email_neomix,$subject,$message,$headers) ;



// obteniendo nuevos datos
    $query_pedido = "SELECT * FROM pedidos WHERE id_pedido='$id_pedido';";
    $resultado_pedido = mysql_query($query_pedido, $conex);
    $row_pedido=mysql_fetch_array($resultado_pedido);
    $query_detalle = "SELECT * FROM detalle_pedido WHERE id_pedido='$id_pedido';";
    $resultado_detalle = mysql_query($query_detalle, $conex);


    $subject = "Pedido Aceptado";
    $headers = "From: noreply@neomixltda.com" . "\r\n";
    $headers .= "Reply-To: infolp@neomixltda.com\r\n";
//$headers .= "Return-Path: infolp@neomixltda.com\r\n";
//$headers .= "CC: infolp@neomixltda.com\r\n";
//$headers .= "BCC: infolp@neomixltda.com\r\n";
    $headers  .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
    $message =  "<!doctype html>
<html>
<head align='center'>
<meta charset='utf-8'>
<title>Untitled Document</title>

</head >
<body align='center'>

<div align='center' >
<p>&nbsp;</p>
<p>Pedido aceptado.</p>
<table align='center' width='90%' border='10'>
  <tbody>
    <tr>
      <td width='32%'>Numero de cliente:</td>
      <td width='68%'>".$codigo_cliente."</td>
    </tr>
    <tr>
      <td width='32%'>Nombre y apellido / Razon social:</td>
      <td width='68%'>".$razon_social_cliente."".$nombres_cliente." ".$apellidos_cliente."</td>
    </tr>
    <tr>
      <td width='32%'>Lugar de entrega solicitado:</td>
      <td width='68%'>".$row_pedido['lugar_entrega_sol']."</td>
    </tr>
    <tr>
      <td width='32%'>Fecha de entrega solicitado:</td>
      <td width='68%'>".$row_pedido['fecha_entrega_sol']."</td>
    </tr>
    <tr>
      <td width='32%'>NIT:</td>
      <td width='68%'>".$row_pedido['nit']."</td>
    </tr>
    <tr>
      <td width='32%'>Nombre o razon social:</td>
      <td width='68%'>".$row_pedido['razon_social']."</td>
    </tr>
    <tr>
      <td width='32%'>Lugar de entrega convenido:</td>
      <td width='68%'>".$row_pedido['lugar_convenido']."</td>
    </tr>
    <tr>
      <td width='32%'>Fecha de entrega comprometida:</td>
      <td width='68%'>".$fecha_comprometida."</td>
    </tr>
    <tr>
      <td width='32%'>Codigo de distribuidor:</td>
      <td width='68%'>".$distribuidor."</td>
    </tr>
  </tbody>
</table>
<br>
<table align='center' width='90%' border='10'>
    <thead>
        <tr>
            <th>Codigo</th>
            <th>Descripcion</th>
            <th>Precio</th>
            <th>Cantidad solicitada</th>
            <th>Monto</th>
        </tr>
    </thead>
    <tbody>";
    $suma=0;
    $suma_cantidad=0;
    while ($dato_detalle = mysql_fetch_array($resultado_detalle))
    {
        $suma+=$dato_detalle['monto'];
        $suma_cantidad+=$dato_detalle['cantidad_sol'];
        $id_articulo=$dato_detalle['articulo'];
        $query_articulo = "SELECT * FROM articulos WHERE codigo='$id_articulo';";
        $resultado_articulo = mysql_query($query_articulo, $conex);
        $row_articulo=mysql_fetch_array($resultado_articulo);
        $message.="<tr>";
        $message.= "<td>".$id_articulo."</td>";
        $message.= "<td>".$row_articulo['descripcion']."</td>";
        $message.= "<td>".$dato_detalle['precio_venta']."</td>";
        $message.= "<td>".$dato_detalle['cantidad_sol']."</td>";
        $message.= "<td>".$dato_detalle['monto']."</td>";
        $message.= "</tr>";
    }
    $message.= "
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>Total: ".$suma_cantidad."</td>
            <td>Total: ".$suma."</td>
            <td></td>
        </tr>
    </tbody>
</table>
<br>
<br>
<p>&nbsp;</p>
<p>GRACIAS POR SU PEDIDO</p>
<p>NEOMIX LTDA</p>
</div>
</body>
</html>

";

    mail($email_neomix,$subject,$message,$headers) ;
//    mail($email_neomix,$subject,$message,$headers) ;



    echo '<script language = javascript>
                alert("Pedido aceptado")
                self.location = "aceptar_pedidos.php"
              </script>';
}
else
{
    echo '<script language = javascript>
                alert("Datos incorretos")
                self.location = "aceptar_pedidos.php"
              </script>';
}
?>