<?php

include("Conexion.php");

$archivo=fopen("../param.txt","r") or die("Error");
$linea=fgets($archivo);
$datos=explode(";",$linea);

$sucursal=$datos[4];

fclose($archivo);

//    $sucursal=$_REQUEST['sucursal'];
    $nombres=$_REQUEST['nombres'];
    $apellidos=$_REQUEST['apellidos'];
    $telefono_contacto=$_REQUEST['telefono_contacto'];
    $email=$_REQUEST['email'];
    $celular=$_REQUEST['celular'];
//    $captcha=$_POST['g-recaptcha-response'];

$resultado_validate=mysql_query("SELECT * FROM solicitudes_clientes WHERE email='$email'",$conex);
$validate=mysql_num_rows($resultado_validate);

$resultado_validate1=mysql_query("SELECT * FROM clientes WHERE email='$email'",$conex);
$validate1=mysql_num_rows($resultado_validate1);

if($validate>=1 || $validate1>=1)
{
    echo '<script language = javascript>
                alert("Ya existe un cliente con el mismo email, porfavor cambielo")
                self.location = "registro_particular.php"
              </script>';
}
else
{
    if (isset($sucursal) && !empty($sucursal) && isset($nombres) && !empty($nombres) && isset($apellidos) && !empty($apellidos) && isset($telefono_contacto) && !empty($telefono_contacto) && isset($email) && !empty($email)/* && isset($captcha) && !empty($captcha)*/) {

        /*
        $secret = "6LeroxEUAAAAABpq-8T4RH6ggfsEakRevjc0yeX7";
        $ip = $_SERVER['REMOTE_ADDR'];
        $result = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
        $array = json_decode($result, TRUE);
        if ($array['success']) {
*/
//        str_pad($value, 5, '0', STR_PAD_LEFT);

            $resultado_fecha = mysql_query("SELECT NOW() AS fecha", $conex);
            $row_fecha = mysql_fetch_array($resultado_fecha);
            $fecha = $row_fecha['fecha'];

            mysql_query("INSERT INTO solicitudes_clientes VALUES (DEFAULT,'$sucursal','$nombres','$apellidos','$telefono_contacto','$email','$celular','','','','$fecha','P')", $conex);
            $resultado_entregas=mysql_query("SELECT MAX(id_sol_cliente) AS id FROM solicitudes_clientes",$conex);
            $row_entrega=mysql_fetch_array($resultado_entregas);
            $last_id=$row_entrega['id'];

            $link='<a href="http://www.neomixltda.com/sis_pedidos/test/clientes/Lverificar_registro.php?sol='.$last_id.'">AQUI</a>';

            $subject = "Verificacion de registro";
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
<p>Verificacion de registro.</p>
<p>Para validar su registro haga clic ".$link.".<br>
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


//        header("location: registro_particular.php");
            echo '<script language = javascript>
                alert("Espera un mail para validar tu registro")
                self.location = "login.php"
              </script>';
 //       }
        /*
        else
        {
            echo '<script language = javascript>
                alert("Recaptcha erroneo")
                self.location = "login.php"
              </script>';
        }
        */
    } else {
        echo '<script language = javascript>
                alert("Datos incorretos")
                self.location = "registro_particular.php"
              </script>';
    }
}
?>