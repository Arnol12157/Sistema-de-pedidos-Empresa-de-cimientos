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

$id_usuario=$_REQUEST['idusu'];
$idAccesos=$_REQUEST['idacc'];
$count= count($idAccesos);

mysql_query("UPDATE accesos SET estado='0' WHERE id_usuario='$id_usuario'",$conex);

for ( $i = 0 ; $i < $count ; $i++ )
{
    mysql_query("UPDATE accesos SET estado='1' WHERE id_acceso='$idAccesos[$i]'",$conex);
}

    echo '<script language = javascript>
                alert("Accesos guardados")
                self.location = "permisos_acceso.php"
              </script>';

?>