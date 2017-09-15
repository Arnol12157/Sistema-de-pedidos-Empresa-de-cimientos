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

$id_cliente=$_REQUEST['idc'];
$observacion=$_REQUEST['obs'];
$cliente_estado=$_REQUEST['estado_c'];

if(isset($observacion) && !empty($observacion))
{
    include("Conexion.php");

    mysql_query("UPDATE clientes SET observacion='$observacion', estado='$cliente_estado' WHERE id_cliente='$id_cliente'", $conex);

    echo '<script language = javascript>
                alert("Se grabaron las observaciones")
                self.location = "procesar_observaciones.php"
              </script>';
}
else
{
    echo '<script language = javascript>
                alert("No se introdujo ninguna observacion")
                self.location = "procesar_observaciones.php"
              </script>';
}
?>