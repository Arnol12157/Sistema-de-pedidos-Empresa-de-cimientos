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

$precio_contado_domicilio=$_REQUEST['precio_contado_dom'];
$precio_contado_planta=$_REQUEST['precio_contado_planta'];
$precio_credito_domicilio=$_REQUEST['precio_credito_dom'];
$precio_credito_planta=$_REQUEST['precio_credito_planta'];
$idp=$_REQUEST['idp'];

if(empty($precio_contado_domicilio) && empty($precio_contado_planta) && empty($precio_credito_domicilio) && empty($precio_credito_planta))
{
    echo '<script language = javascript>
                alert("No realizaste ningun cambio a los datos")
                self.location = "modificar_precio.php?idp='.$idp.'"
              </script>';
}
else
{
    if(isset($precio_contado_domicilio) && !empty($precio_contado_domicilio))
    {
        $precio_contado_domicilio=str_replace(",",".",$precio_contado_domicilio);
        mysql_query("UPDATE precios SET precio_contado_domicilio='$precio_contado_domicilio' WHERE id_precio='$idp'",$conex);
    }
    if(isset($precio_contado_planta) && !empty($precio_contado_planta))
    {
        $precio_contado_planta=str_replace(",",".",$precio_contado_planta);
        mysql_query("UPDATE precios SET precio_contado_planta='$precio_contado_planta' WHERE id_precio='$idp'",$conex);
    }
    if(isset($precio_credito_domicilio) && !empty($precio_credito_domicilio))
    {
        $precio_credito_domicilio=str_replace(",",".",$precio_credito_domicilio);
        mysql_query("UPDATE precios SET precio_credito_domicilio='$precio_credito_domicilio' WHERE id_precio='$idp'",$conex);
    }
    if(isset($precio_credito_planta) && !empty($precio_credito_planta))
    {
        $precio_credito_planta=str_replace(",",".",$precio_credito_planta);
        mysql_query("UPDATE precios SET precio_credito_planta='$precio_credito_planta' WHERE id_precio='$idp'",$conex);
    }
    echo '<script language = javascript>
                alert("Modificacion exitosa")
                self.location = "modificacion_precios.php"
              </script>';
}
?>