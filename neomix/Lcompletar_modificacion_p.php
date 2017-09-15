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

$idc=$_REQUEST['idc'];
$per_con_nuevo=$_REQUEST['per_con_nuevo'];
$tel_empre_nuevo=$_REQUEST['tel_empre_nuevo'];
$tel_contacto_nuevo=$_REQUEST['tel_contacto_nuevo'];
$email_nuevo=$_REQUEST['email_nuevo'];
$celular_nuevo=$_REQUEST['celular_nuevo'];
$direccion_nuevo=$_REQUEST['direccion_nuevo'];
$zona_nuevo=$_REQUEST['zona_nuevo'];
$telefonos_nuevo=$_REQUEST['telefonos_nuevo'];
$categoria_nuevo=$_REQUEST['categoria_nuevo'];
$credito_nuevo=$_REQUEST['credito_nuevo'];
$comen_nuevo=$_REQUEST['comen_nuevo'];

$ver1=0;
$ver2=0;
$ver3=0;
$ver4=0;
$ver5=0;
$ver6=0;
$ver7=0;
$ver8=0;
$ver9=0;
$ver10=0;

$desc1="";
$desc2="";
$desc3="";
$desc4="";
$desc5="";
$desc6="";
$desc7="";
$desc8="";
$desc9="";
$desc10="";

if(isset($comen_nuevo) || isset($per_con_nuevo) || isset($tel_empre_nuevo) || isset($tel_contacto_nuevo) || isset($email_nuevo) || isset($celular_nuevo) || isset($direccion_nuevo) || isset($zona_nuevo) || isset($telefonos_nuevo) || isset($categoria_nuevo) || isset($credito_nuevo))
{
    if (isset($per_con_nuevo) && strcasecmp($per_con_nuevo,'0')!=0)
    {
        mysql_query("UPDATE clientes SET persona_contacto_nuevo='', persona_contacto='$per_con_nuevo', estado='A' WHERE id_cliente='$idc'", $conex);
        $ver1=1;
    }
    if (isset($tel_empre_nuevo) && strcasecmp($tel_empre_nuevo,'0')!=0)
    {
        mysql_query("UPDATE clientes SET telefono_empresa_nuevo='', telefono_empresa='$tel_empre_nuevo', estado='A' WHERE id_cliente='$idc'", $conex);
        $ver2=1;
    }
    if (isset($tel_contacto_nuevo) && strcasecmp($tel_contacto_nuevo,'0')!=0)
    {
        mysql_query("UPDATE clientes SET tel_contacto_nuevo='', tel_contacto='$tel_contacto_nuevo', estado='A' WHERE id_cliente='$idc'", $conex);
        $ver3=1;
    }
    if (isset($email_nuevo) && strcasecmp($email_nuevo,'0')!=0)
    {
        mysql_query("UPDATE clientes SET email_nuevo='', email='$email_nuevo', estado='A' WHERE id_cliente='$idc'", $conex);
        $ver4=1;
    }
    if (isset($celular_nuevo) && strcasecmp($celular_nuevo,'0')!=0)
    {
        mysql_query("UPDATE clientes SET celular_nuevo='', celular='$celular_nuevo', estado='A' WHERE id_cliente='$idc'", $conex);
        $ver5=1;
    }
    if (isset($direccion_nuevo) && strcasecmp($direccion_nuevo,'0')!=0)
    {
        mysql_query("UPDATE clientes SET direccion_nuevo='', direccion='$direccion_nuevo', estado='A' WHERE id_cliente='$idc'", $conex);
        $ver6=1;
    }
    if (isset($zona_nuevo) && strcasecmp($zona_nuevo,'0')!=0)
    {
        mysql_query("UPDATE clientes SET zona_nuevo='', zona='$zona_nuevo', estado='A' WHERE id_cliente='$idc'", $conex);
        $ver7=1;
    }
    if (isset($comen_nuevo) && strcasecmp($comen_nuevo,'0')!=0)
    {
        mysql_query("UPDATE clientes SET comentario_nuevo='', comentario='$comen_nuevo', estado='A' WHERE id_cliente='$idc'", $conex);
    }
    if (isset($telefonos_nuevo) && strcasecmp($telefonos_nuevo,'0')!=0)
    {
        mysql_query("UPDATE clientes SET telefonos_nuevo='', telefonos='$telefonos_nuevo', estado='A' WHERE id_cliente='$idc'", $conex);
        $ver8=1;
    }
    if (isset($categoria_nuevo) && strcasecmp($categoria_nuevo,'0')!=0)
    {
        mysql_query("UPDATE clientes SET categoria_nuevo='', categoria='$categoria_nuevo', estado='A' WHERE id_cliente='$idc'", $conex);
        $ver9=1;
    }
    if (isset($credito_nuevo) && strcasecmp($credito_nuevo,'0')!=0)
    {
        mysql_query("UPDATE clientes SET credito_nuevo='', credito='$credito_nuevo', estado='A' WHERE id_cliente='$idc'", $conex);
        $ver10=1;
    }

    mysql_query("UPDATE clientes SET persona_contacto_nuevo='', estado='A' WHERE id_cliente='$idc'", $conex);
    mysql_query("UPDATE clientes SET telefono_empresa_nuevo='', estado='A' WHERE id_cliente='$idc'", $conex);
    mysql_query("UPDATE clientes SET tel_contacto_nuevo='', estado='A' WHERE id_cliente='$idc'", $conex);
    mysql_query("UPDATE clientes SET email_nuevo='', estado='A' WHERE id_cliente='$idc'", $conex);
    mysql_query("UPDATE clientes SET celular_nuevo='', estado='A' WHERE id_cliente='$idc'", $conex);
    mysql_query("UPDATE clientes SET direccion_nuevo='', estado='A' WHERE id_cliente='$idc'", $conex);
    mysql_query("UPDATE clientes SET zona_nuevo='', estado='A' WHERE id_cliente='$idc'", $conex);
    mysql_query("UPDATE clientes SET comentario_nuevo='', estado='A' WHERE id_cliente='$idc'", $conex);
    mysql_query("UPDATE clientes SET telefonos_nuevo='', estado='A' WHERE id_cliente='$idc'", $conex);
    mysql_query("UPDATE clientes SET categoria_nuevo='', estado='A' WHERE id_cliente='$idc'", $conex);
    mysql_query("UPDATE clientes SET credito_nuevo='', estado='A' WHERE id_cliente='$idc'", $conex);

    $consulta=mysql_query("SELECT * FROM clientes WHERE id_cliente='".$idc."'");
    $row=mysql_fetch_array($consulta);

    $link='<a href="http://www.neomixltda.com/sis_pedidos/test/clientes/login.php">menu de clientes</a>';

    if($ver1==1)
    {
        $desc1="La persona de contacto cambio a ".$row['persona_contacto'];
    }
    else
    {
        $desc1="La persona de contacto no cambio";
    }
    if($ver2==1)
    {
        $desc2="El telefono de la empresa cambio a ".$row['telefono_empresa'];
    }
    else
    {
        $desc2="El telefono de la empresa no cambio";
    }
    if($ver3==1)
    {
        $desc3="El telefono de contacto cambio a ".$row['tel_contacto'];
    }
    else
    {
        $desc3="El telefono de contacto no cambio";
    }
    if($ver4==1)
    {
        $desc4="El email cambio a ".$row['email'];
    }
    else
    {
        $desc4="El email no cambio";
    }
    if($ver5==1)
    {
        $desc5="El celular cambio a ".$row['celular'];
    }
    else
    {
        $desc5="El celular no cambio";
    }
    if($ver6==1)
    {
        $desc6="La direccion cambio a ".$row['direccion'];
    }
    else
    {
        $desc6="La direccion no cambio";
    }
    if($ver7==1)
    {
        $desc7="La zona cambio a ".$row['zona'];
    }
    else
    {
        $desc7="La zona no cambio";
    }
    if($ver8==1)
    {
        $desc8="Los telefonos extra cambiaron a ".$row['telefonos'];
    }
    else
    {
        $desc8="Los telefonos extra no cambiaron";
    }
    if($ver9==1)
    {
        $desc9="La categoria cambio a ".$row['categoria'];
    }
    else
    {
        $desc9="La categoria no cambio";
    }
    if($ver10==1)
    {
        $desc10="El credito autorizado cambio a ".$row['credito'];
    }
    else
    {
        $desc10="El credito autorizado no cambio";
    }

    $subject = "Confirmacion de modificacion de datos";
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
<p>Modificacion de datos.</p>
<p>Estos son los registros de cambios de su perfil</p>
<p>".$desc1."</p>
<p>".$desc2."</p>
<p>".$desc3."</p>
<p>".$desc4."</p>
<p>".$desc5."</p>
<p>".$desc6."</p>
<p>".$desc7."</p>
<p>".$desc8."</p>
<p>".$desc9."</p>
<p>".$desc10."</p>
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
                alert("Se enviara un email indicando que los datos fueron modificados")
                self.location = "autorizar_modificaciones.php"
              </script>';
}
//else
//{
//    mysql_query("UPDATE clientes SET tel_contacto_nuevo='', estado='A' WHERE id_cliente='$idc'", $conex);
//    mysql_query("UPDATE clientes SET email_nuevo='', estado='A' WHERE id_cliente='$idc'", $conex);
//    mysql_query("UPDATE clientes SET celular_nuevo='', estado='A' WHERE id_cliente='$idc'", $conex);
//    echo '<script language = javascript>
//                alert("Se enviara un email indicando ningun dato fue autorizado para ser modificado")
//                self.location = "autorizar_modificaciones.php"
//              </script>';
//}
?>