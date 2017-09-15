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

$codigo=$_REQUEST['codigo'];
$descripcion=strtoupper($_REQUEST['descripcion']);
$aplicacion=strtoupper($_REQUEST['aplicacion']);
$estado_art=$_REQUEST['estado_art'];
$ida=$_REQUEST['ida'];

$query_articulo = "SELECT * FROM articulos WHERE codigo='$ida';";
$resultado_articulo = mysql_query($query_articulo, $conex);
$datos_articulo = mysql_fetch_array($resultado_articulo);

if((isset($descripcion) && !empty($descripcion)) || (isset($aplicacion) && !empty($aplicacion)) || strcasecmp($datos_articulo['estado'],$estado_art)!=0)
{
    if(isset($descripcion) && !empty($descripcion))
    {
        mysql_query("UPDATE articulos SET descripcion='$descripcion' WHERE codigo='$ida'",$conex);
    }
    if(isset($aplicacion) && !empty($aplicacion))
    {
        mysql_query("UPDATE articulos SET aplicacion='$aplicacion' WHERE codigo='$ida'",$conex);
    }
    if(strcasecmp($datos_articulo['estado'],$estado_art)!=0)
    {
        mysql_query("UPDATE articulos SET estado='$estado_art' WHERE codigo='$ida'",$conex);
    }

    echo '<script language = javascript>
                alert("Modificacion exitosa")
                self.location = "articulos_modificacion.php"
              </script>';
}
else
{
    echo '<script language = javascript>
                alert("Datos erroneos o incompletos")
                self.location = "articulos_modificacion.php"
              </script>';
}
?>