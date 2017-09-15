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

//$fecha_dep=$_REQUEST['fecha_dep'];

$fecha_dep = date("Y-m-d", strtotime($_REQUEST['fecha_dep']));

if(isset($fecha_dep) && !empty($fecha_dep))
{
    mysql_query("DELETE FROM solicitudes_clientes WHERE fecha<='$fecha_dep'", $conex);

    echo '<script language = javascript>
                alert("Depuracion con exito")
                self.location = "depuracion_solicitudes.php"
              </script>';
}
else
{
    echo '<script language = javascript>
                alert("No selecciono ninguna fecha de depuracion")
                self.location = "depuracion_solicitudes.php"
              </script>';
}
?>