<?php
$direccion=$_REQUEST['direccion'];
$zona=$_REQUEST['zona'];
$telefonos=$_REQUEST['telefonos'];
$comentario=$_REQUEST['comentario'];
$categoria=$_REQUEST['categoria'];
$credito=$_REQUEST['credito'];
$idc=$_REQUEST['idc'];

if(isset($direccion) && !empty($direccion) && isset($zona) && !empty($zona) && isset($comentario) && !empty($comentario) && isset($categoria) && !empty($categoria) && isset($idc) && !empty($idc))
{
    include("Conexion.php");

//    $validate=2;
//    while($validate>=1)
//    {
//        $num_cliente=rand(10000,99998);
        $clave_acceso=rand(1000,9999);

//        $resultado_validate=mysql_query("SELECT * FROM clientes WHERE num_cliente='$num_cliente'",$conex);
//        $validate=mysql_num_rows($resultado_validate);
//    }

//        str_pad($value, 5, '0', STR_PAD_LEFT);

    $query_particular = "SELECT * FROM solicitudes_clientes WHERE id_sol_cliente='$idc';";
    $resultado_particular = mysql_query($query_particular, $conex);
    $dato_particular = mysql_fetch_array($resultado_particular);
    $sucursal=$dato_particular['oficina'];
    $nombres=$dato_particular['nombres'];
    $apellidos=$dato_particular['apellidos'];
    $nombres=$dato_particular['nombres'];
    $telefono_contacto=$dato_particular['tel_contacto'];
    $email=$dato_particular['email'];
    $celular=$dato_particular['celular'];
    $razon_social=$dato_particular['razon_social'];
    $persona_contacto=$dato_particular['persona_contacto'];
    $telefono_empresa=$dato_particular['telefono_empresa'];

    mysql_query("INSERT INTO clientes VALUES (DEFAULT,'$sucursal','$nombres','$apellidos','$telefono_contacto','$email','$celular','$razon_social','$persona_contacto','$telefono_empresa','A','0','$clave_acceso','$direccion','$zona','$telefonos','$comentario','$categoria','NULL','','','','','','','','','','','','','$credito','')",$conex);
    $query_newnum = "SELECT * FROM clientes WHERE email='$email';";
    $resultado_newnum = mysql_query($query_newnum, $conex);
    $dato_newnum = mysql_fetch_array($resultado_newnum);
    $id_new=$dato_newnum['id_cliente'];
    $new_num=str_pad($dato_newnum['id_cliente'], 5, '0', STR_PAD_LEFT);
    mysql_query("UPDATE clientes SET num_cliente='$new_num' WHERE id_cliente='$id_new'",$conex);

    mysql_query("DELETE FROM solicitudes_clientes WHERE id_sol_cliente='$idc';", $conex);

//        header("location: registro_particular.php");

    $link='<a href="http://www.neomixltda.com/sis_pedidos/test/clientes/login.php">menu de clientes</a>';


    $subject = "Informacion de datos de acceso";
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
      <td width='68%'>".$new_num."</td>
    </tr>
    <tr>
      <td>Clave de acceso:</td>
      <td>".$clave_acceso."</td>
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

    mail($email,$subject,$message,$headers) ;

    echo '<script language = javascript>
                alert("Un email fue enviado al cliente con las credenciales para ingresar al sistema")
                self.location = "aceptar_solicitudes.php"
              </script>';
}
else
{
    echo "<script language = javascript>
                alert('Datos erroneos')
                self.location = 'aceptar_solicitudes.php'
              </script>";
}
?>