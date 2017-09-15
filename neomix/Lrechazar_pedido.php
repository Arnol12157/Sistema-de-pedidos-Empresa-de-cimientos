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
//Inicio variables de sesion
$id = $_SESSION['id'];
$nombre = $_SESSION['nombre'];
$email = $_SESSION['email'];
$contra = $_SESSION['contra'];
$clave = $_SESSION['clave'];
$fecha = $_SESSION['fecha'];
$estado = $_SESSION['estado'];

$observacion=$_REQUEST['observacion'];
$id_pedido=$_REQUEST['id_pedidoobs'];

if(isset($observacion) && !empty($observacion))
{
    mysql_query("UPDATE pedidos SET estado='R', observacion='$observacion' WHERE id_pedido='$id_pedido'",$conex);

    $sql3 = mysql_query("SELECT * FROM pedidos WHERE id_pedido='$id_pedido'",$conex);
    $sql3r = mysql_fetch_array($sql3);
    $id_cliente = $sql3r['id_cliente'];
    $sql4 = mysql_query("SELECT * FROM clientes WHERE id_cliente='$id_cliente'",$conex);
    $sql4r = mysql_fetch_array($sql4);
    $email_cliente = $sql4r['email'];

    // obteniendo nuevos datos
$query_pedido = "SELECT * FROM pedidos WHERE id_pedido='$id_pedido';";
$resultado_pedido = mysql_query($query_pedido, $conex);
$row_pedido=mysql_fetch_array($resultado_pedido);

    $link='<a href="http://www.neomixltda.com/sis_pedidos/test/clientes/login.php">menu de clientes</a>';

    $subject = "Pedido rechazado";
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
<p>Pedido Rechazado.</p>
<table align='center' width='90%' border='10'>
  <tbody>
    <tr>
      <td width='32%'>Lugar de entrega solicitado:</td>
      <td width='68%'>".$row_pedido['lugar_entrega_sol']."</td>
    </tr>
    <tr>
      <td width='32%'>Fecha de entrega solicitado:</td>
      <td width='68%'>".$row_pedido['fecha_entrega_sol']."</td>
    </tr>
  </tbody>
</table>
<br>
<p>Observacion del pedido.</p>
<table align='center' width='36%' border='10'>
  <tbody>
    <tr>
      <td width='32%'>Observacion:</td>
      <td width='68%'>".$observacion."</td>
    </tr>
  </tbody>
</table>
<p>Para ingresar al sistema, acceda en ".$link.".<br>
</p>
<br>
<br>
<br>
<p>&nbsp;</p>
<p>NEOMIX LTDA</p>
</div>

</body>
</html>

";

    mail($email_cliente,$subject,$message,$headers) ;

    echo '<script language = javascript>
                alert("Pedido rechazado")
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