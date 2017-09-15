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

$nombre_n=strtoupper($_REQUEST['nombre_n']);
$email_n=$_REQUEST['email_n'];
$contra_n=$_REQUEST['contra_n'];

if(empty($nombre_n) && empty($email_n) && empty($contra_n))
{
    echo '<script language = javascript>
                alert("No realizaste ningun cambio a los datos")
                self.location = "modificar_datos.php"
              </script>';
}
else
{
    if(isset($nombre_n) && !empty($nombre_n))
    {
        mysql_query("UPDATE usuarios SET nombre='$nombre_n' WHERE clave='$clave'",$conex);
    }
    if(isset($email_n) && !empty($email_n))
    {
        mysql_query("UPDATE usuarios SET email='$email_n' WHERE clave='$clave'",$conex);
    }
    if(isset($contra_n) && !empty($contra_n))
    {
        mysql_query("UPDATE usuarios SET contra='$contra_n' WHERE clave='$clave'",$conex);
    }
    echo '<script language = javascript>
                alert("Modificacion exitosa, vuelve a iniciar sesion porfavor")
                self.location = "cerrarsesion.php"
              </script>';
}
?>