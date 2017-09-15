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
$cantidad=$_REQUEST['cantidad'];
$precio_contado_domicilio=$_REQUEST['precio_contado_domicilio'];
$precio_contado_planta=$_REQUEST['precio_contado_planta'];
$precio_credito_domicilio=$_REQUEST['precio_credito_domicilio'];
$precio_credito_planta=$_REQUEST['precio_credito_planta'];

$idcoca=$codigo.$cantidad;
$resultado_validate=mysql_query("SELECT * FROM precios WHERE id_precio='$idcoca'",$conex);
$validate=mysql_num_rows($resultado_validate);

if($validate>=1)
{
    echo '<script language = javascript>
                alert("Ya existe un precio para el articulo seleccionado")
                self.location = "alta_precios.php"
              </script>';
}
else
{
    if(isset($cantidad) && !empty($cantidad) && isset($precio_contado_domicilio) && !empty($precio_contado_domicilio) && isset($precio_contado_planta) && !empty($precio_contado_planta) && isset($precio_credito_domicilio) && !empty($precio_credito_domicilio) && isset($precio_credito_planta) && !empty($precio_credito_planta))
    {
//        if(strlen($cantidad)<4)
//        {
//            $cantidad=str_pad($cantidad, 4, '0', STR_PAD_LEFT);
//        }


        $resultado_fecha=mysql_query("SELECT NOW() AS fecha",$conex);
        $row_fecha=mysql_fetch_array($resultado_fecha);
        $fecha=$row_fecha['fecha'];

        $id_precio=$codigo.$cantidad;

        $precio_contado_domicilio=str_replace(",",".",$precio_contado_domicilio);
        $precio_contado_planta=str_replace(",",".",$precio_contado_planta);
        $precio_credito_domicilio=str_replace(",",".",$precio_credito_domicilio);
        $precio_credito_planta=str_replace(",",".",$precio_credito_planta);

        mysql_query("INSERT INTO precios VALUES ('$id_precio','$cantidad','$codigo','$precio_contado_domicilio','$precio_contado_planta','$precio_credito_domicilio','$precio_credito_planta')",$conex);

        echo '<script language = javascript>
                alert("Precio registrado con exito")
                self.location = "alta_precios.php"
              </script>';
    }
    else
    {
        echo '<script language = javascript>
                alert("Datos erroneos o incompletos")
                self.location = "alta_precios.php"
              </script>';
    }
}
?>