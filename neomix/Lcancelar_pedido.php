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

$observacion=$_REQUEST['observacion'];
$id_pedido=$_REQUEST['id_pedidoobs'];

if(isset($observacion) && !empty($observacion))
{
    mysql_query("UPDATE pedidos SET estado='X', observacion='$observacion' WHERE id_pedido='$id_pedido'",$conex);

    echo '<script language = javascript>
                alert("Pedido rechazado")
                self.location = "cancelacion_pedidos.php"
              </script>';
}
else
{
    echo '<script language = javascript>
                alert("Datos incorretos")
                self.location = "cancelacion_pedidos.php"
              </script>';
}
?>