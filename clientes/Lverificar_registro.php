<?php
include("Conexion.php");

$id_solicitud=$_GET['sol'];

mysql_query("UPDATE solicitudes_clientes SET estado='S' WHERE id_sol_cliente='$id_solicitud'",$conex);

echo '<script language = javascript>
                alert("Espera un mail con tus credenciales para ingresar al sistema")
                self.location = "login.php"
              </script>';

?>