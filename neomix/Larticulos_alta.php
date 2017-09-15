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
$descripcion=$_REQUEST['descripcion'];
$aplicacion=$_REQUEST['aplicacion'];
$estado_art=$_REQUEST['estado_art'];

$resultado_validate=mysql_query("SELECT * FROM articulos WHERE codigo='$codigo'",$conex);
$validate=mysql_num_rows($resultado_validate);

if($validate>=1)
{
    echo '<script language = javascript>
                alert("Ya hay un articulo con el mismo codigo, porfavor cambie de codigo")
                self.location = "articulos_alta.php"
              </script>';
}
else
{
    if(isset($codigo) && !empty($codigo) && isset($descripcion) && !empty($descripcion) && isset($aplicacion) && !empty($aplicacion))
    {
        $resultado_fecha=mysql_query("SELECT NOW() AS fecha",$conex);
        $row_fecha=mysql_fetch_array($resultado_fecha);
        $fecha=$row_fecha['fecha'];

        if(strlen($codigo)<5)
        {
            if(!preg_match('/[A-Z]{1}/',"$codigo"))
            {
                $codigo=str_pad($codigo, 5, '0', STR_PAD_LEFT);
            }
        }

        mysql_query("INSERT INTO articulos VALUES ('$codigo','$descripcion','$estado_art','$fecha','$aplicacion')",$conex);

        echo '<script language = javascript>
                alert("Articulo registrado con exito")
                self.location = "articulos_alta.php"
              </script>';
    }
    else
    {
        echo '<script language = javascript>
                alert("Datos erroneos o incompletos")
                self.location = "articulos_alta.php"
              </script>';
    }
}
?>