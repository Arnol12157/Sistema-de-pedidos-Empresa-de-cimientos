<?php
session_start();

if ($_SESSION['id_cliente'])
{
    session_destroy();
    echo '<script language = javascript>
	alert("su sesion ha terminado correctamente")
	self.location = "login.php"
	</script>';}
else
{
    echo '<script language = javascript>
	alert("No ha iniciado ninguna sesión, por favor regístrese")
	self.location = "login.php"
	</script>';}
?>