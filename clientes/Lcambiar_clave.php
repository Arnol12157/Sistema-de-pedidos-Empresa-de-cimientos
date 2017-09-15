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
$id = $_SESSION['id_cliente'];
$estado = $_SESSION['estado'];
$num_cliente = $_SESSION['num_cliente'];
$clave = $_SESSION['clave_acceso'];
$categoria = $_SESSION['categoria'];

$clave_anterior=$_REQUEST['clave_anterior'];
$clave_nueva=$_REQUEST['clave_nueva'];
$clave_repe=$_REQUEST['clave_repe'];

$consulta=mysql_query("SELECT * FROM clientes WHERE id_cliente='".$id."'");
$row=mysql_fetch_array($consulta);
$clave_old=$row['clave_acceso_antigua'];

if(isset($clave_anterior) && !empty($clave_anterior) && isset($clave_nueva) && !empty($clave_nueva) && isset($clave_repe) && !empty($clave_repe) && strcasecmp($clave_nueva,$clave_repe)==0 && strcasecmp($clave_anterior,$clave)==0)
{
    mysql_query("UPDATE clientes SET clave_acceso='$clave_nueva', clave_acceso_antigua='$clave_anterior' WHERE id_cliente='$id'",$conex);

    $link='<a href="http://www.neomixltda.com/sis_pedidos/test/clientes/login.php">menu de clientes</a>';


    $subject = "Cambio de clave de acceso";
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
<p>Cambio de clave de acceso.</p>


<table align='center' width='36%' border='10'>
  <tbody>
    <tr>
      <td width='32%'>Numero de cliente:</td>
      <td width='68%'>".$num_cliente."</td>
    </tr>
    <tr>
      <td>Clave de acceso:</td>
      <td>".$clave_nueva."</td>
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

    mail($row['email'],$subject,$message,$headers) ;

    echo '<script language = javascript>
                alert("Vuelve a iniciar sesion porfavor, un email fue enviado con tu nueva clave")
                self.location = "cerrarsesion.php"
              </script>';
}
else
{
    echo '<script language = javascript>
                alert("Datos incorretos")
                self.location = "cambiar_clave.php"
              </script>';
}
?>