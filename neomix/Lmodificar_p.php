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

$per_con=strtoupper($_REQUEST['per_con']);
$tel_empresa=$_REQUEST['tel_empresa'];

$telefono_contacto=$_REQUEST['tel_contacto'];
$celular=$_REQUEST['celular'];
$direccion=strtoupper($_REQUEST['direccion']);
$zona=strtoupper($_REQUEST['zona']);
$tel_extra=$_REQUEST['tel_extra'];
$comentario=strtoupper($_REQUEST['comentario']);
$idc=$_REQUEST['idc'];
$cat_old=$_REQUEST['cat_old'];
$cre_old=$_REQUEST['cre_old'];
$categoria=$_REQUEST['categoria'];
$credito=$_REQUEST['credito'];

if(empty($comentario) && empty($telefono_contacto) && empty($telefono_contacto) && empty($celular) && empty($direccion) && empty($zona) && empty($tel_extra) && empty($per_con) && empty($tel_empresa) && strcasecmp($categoria,$cat_old)==0 && strcasecmp($credito,$cre_old)==0)
{
    echo '<script language = javascript>
                alert("No realizaste ningun cambio a los datos")
                self.location = "modificar_p.php?idc='.$idc.'"
              </script>';
}
else
{
    if(isset($comentario) && !empty($comentario))
    {
        mysql_query("UPDATE clientes SET comentario_nuevo='$comentario', estado='M' WHERE id_cliente='$idc'",$conex);
    }
    if(isset($direccion) && !empty($direccion))
    {
        mysql_query("UPDATE clientes SET direccion_nuevo='$direccion', estado='M' WHERE id_cliente='$idc'",$conex);
    }
    if(isset($zona) && !empty($zona))
    {
        mysql_query("UPDATE clientes SET zona_nuevo='$zona', estado='M' WHERE id_cliente='$idc'",$conex);
    }
    if(isset($tel_extra) && !empty($tel_extra))
    {
        mysql_query("UPDATE clientes SET telefonos_nuevo='$tel_extra', estado='M' WHERE id_cliente='$idc'",$conex);
    }
    if(isset($per_con) && !empty($per_con))
    {
        mysql_query("UPDATE clientes SET persona_contacto_nuevo='$per_con', estado='M' WHERE id_cliente='$idc'",$conex);
    }
    if(isset($tel_empresa) && !empty($tel_empresa))
    {
        mysql_query("UPDATE clientes SET telefono_empresa_nuevo='$tel_empresa', estado='M' WHERE id_cliente='$idc'",$conex);
    }
    if(isset($telefono_contacto) && !empty($telefono_contacto))
    {
        mysql_query("UPDATE clientes SET tel_contacto_nuevo='$telefono_contacto', estado='M' WHERE id_cliente='$idc'",$conex);
    }
    if(isset($celular) && !empty($celular))
    {
        mysql_query("UPDATE clientes SET celular_nuevo='$celular', estado='M' WHERE id_cliente='$idc'",$conex);
    }
    if(strcasecmp($categoria,$cat_old)!=0)
    {
        mysql_query("UPDATE clientes SET categoria_nuevo='$categoria', estado='M' WHERE id_cliente='$idc'",$conex);
    }
    if(strcasecmp($credito,$cre_old)!=0)
    {
        mysql_query("UPDATE clientes SET credito_nuevo='$credito', estado='M' WHERE id_cliente='$idc'",$conex);
    }
    echo '<script language = javascript>
                alert("Se deberan aceptar datos para que los datos sean modificados")
                self.location = "index.php"
              </script>';
}
?>