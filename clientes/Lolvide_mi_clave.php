<?php
    $clave=$_REQUEST['clave'];

    include("Conexion.php");

    $consulta=mysql_query("SELECT * FROM clientes WHERE num_cliente='$clave'");
    $filas=mysql_num_rows($consulta);


    if(isset($clave) && !empty($clave) && $filas==1)
    {
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
<p>Credenciales de acceso.</p>


<table align='center' width='36%' border='10'>
  <tbody>
    <tr>
      <td width='32%'>Numero de cliente:</td>
      <td width='68%'>".$filas['num_cliente']."</td>
    </tr>
    <tr>
      <td>Clave de acceso:</td>
      <td>".$filas['clave_acceso']."</td>
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

        mail($filas['email'],$subject,$message,$headers) ;

        echo '<script language = javascript>
                    alert("Tus credenciales fueron enviados a tu email")
                    self.location = "login.php"
                  </script>';
    }
    else
    {
        echo '<script language = javascript>
                    alert("Datos incorretos")
                    self.location = "olvide_mi_clave.php"
                  </script>';
    }
?>