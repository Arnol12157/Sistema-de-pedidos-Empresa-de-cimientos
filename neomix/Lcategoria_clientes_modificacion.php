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

$categoria=$_REQUEST['categoria'];
$descripcion=strtoupper($_REQUEST['descripcion']);
$idc=$_REQUEST['idc'];

if((isset($descripcion) && !empty($descripcion)))
{
    if(isset($descripcion) && !empty($descripcion))
    {
        mysql_query("UPDATE categorias_clientes SET descripcion='$descripcion' WHERE tipo='$idc'",$conex);
    }

    echo '<script language = javascript>
                alert("Modificacion exitosa")
                self.location = "categoria_clientes_modificacion.php"
              </script>';
}
else
{
    echo '<script language = javascript>
                alert("Datos erroneos o incompletos")
                self.location = "categoria_clientes_modificacion.php"
              </script>';
}
?>