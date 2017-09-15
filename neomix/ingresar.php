<?php

$clave=$_REQUEST["clave"];
$contra=$_REQUEST["contra"];

include("Conexion.php");

$contra = mysql_real_escape_string($contra);
$clave = mysql_real_escape_string($clave);

//Inicio de variables de sesi�n
if (!isset($_SESSION))
{
    session_start();
}

if(strlen($clave)<5)
{
    if(!preg_match('/[A-Z]{1}/',"$clave"))
    {
        $clave=str_pad($clave, 5, '0', STR_PAD_LEFT);
    }
}

$consulta=mysql_query("SELECT * FROM usuarios WHERE clave='".$clave."' AND contra='".$contra."'");
if($row=mysql_fetch_array($consulta))
{
    //Definimos las variables de sesi�n y redirigimos a la p�gina de usuario
    $_SESSION['id'] = $row['id_usuario'];
    $_SESSION['nombre'] = $row['nombre'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['contra'] = $row['contra'];
    $_SESSION['clave'] = $row['clave'];
    $_SESSION['fecha'] = $row['fecha_alta'];
    $_SESSION['estado'] = $row['estado'];

    header("location: index.php");
}
else
{
    echo '<script language = javascript>
    alert("Datos incorrectos, verifique los datos ingresados")
    self.location = "login.php"
    </script>';
}

?>