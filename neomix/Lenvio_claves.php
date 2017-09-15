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

$id_cliente=$_GET['idc'];
$query_clientes = "SELECT * FROM clientes WHERE id_cliente='$id_cliente';";
$resultado_clientes = mysql_query($query_clientes, $conex);
$dato_clientes = mysql_fetch_array($resultado_clientes);

$link='<a href="http://www.neomixltda.com/sis_pedidos/test/clientes/login.php">menu de clientes</a>';


$subject = "Peticion de datos de acceso";
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
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Restitucion de datos de acceso.</p>


<table align='center' width='36%' border='10'>
  <tbody>
    <tr>
      <td width='32%'>Numero de cliente:</td>
      <td width='68%'>".$dato_clientes['num_cliente']."</td>
    </tr>
    <tr>
      <td>Clave de acceso:</td>
      <td>".$dato_clientes['clave_acceso']."</td>
    </tr>
  </tbody>
</table>
<p>Pidio la restitucion de su informacion, acceda en ".$link.".<br>
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

mail($dato_clientes['email'],$subject,$message,$headers) ;
echo '<script language = javascript>
                alert("Se envio la clave de acceso al email del cliente")
                self.location = "envio_claves.php"
              </script>';
exit();
?>