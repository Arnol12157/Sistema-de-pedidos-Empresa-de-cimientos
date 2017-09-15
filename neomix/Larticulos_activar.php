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

$id_articulo=$_REQUEST['idart'];
$count= count($id_articulo);

mysql_query("UPDATE articulos SET estado='I' WHERE codigo!='999999'",$conex);

for ( $i = 0 ; $i < $count ; $i++ )
{
//    echo $id_articulo[$i];
    mysql_query("UPDATE articulos SET estado='A' WHERE codigo='$id_articulo[$i]'",$conex);
}

    echo '<script language = javascript>
                alert("Activacion/Desactivacion exitosa")
                self.location = "articulos_activar.php"
              </script>';

?>