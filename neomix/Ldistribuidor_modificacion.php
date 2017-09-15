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
$estado_dis=$_REQUEST['estado_dis'];
$idd=$_REQUEST['idd'];

$query_distri = "SELECT * FROM distribuidores WHERE id_distribuidor='$idd';";
$resultado_distri = mysql_query($query_distri, $conex);
$datos_distri = mysql_fetch_array($resultado_distri);

if((isset($codigo) && !empty($codigo)) || (isset($descripcion) && !empty($descripcion)) || strcasecmp($datos_distri['estado'],$estado_dis)!=0)
{
    if(isset($descripcion) && !empty($descripcion))
    {
        mysql_query("UPDATE distribuidores SET descripcion='$descripcion' WHERE id_distribuidor='$idd'",$conex);
    }
    if(strcasecmp($datos_distri['estado'],$estado_dis)!=0)
    {
        mysql_query("UPDATE distribuidores SET estado='$estado_dis' WHERE id_distribuidor='$idd'",$conex);
    }
    if(isset($codigo) && !empty($codigo))
    {
        mysql_query("UPDATE distribuidores SET id_distribuidor='$codigo' WHERE id_distribuidor='$idd'",$conex);
    }

    echo '<script language = javascript>
                alert("Modificacion exitosa")
                self.location = "modificacion_distribuidores.php"
              </script>';
}
else
{
    echo '<script language = javascript>
                alert("Datos erroneos o incompletos")
                self.location = "modificacion_distribuidores.php"
              </script>';
}
?>