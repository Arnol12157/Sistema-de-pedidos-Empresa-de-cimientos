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
$id = $_SESSION['id_cliente'];
$estado = $_SESSION['estado'];
$num_cliente = $_SESSION['num_cliente'];
$clave = $_SESSION['clave_acceso'];
$categoria = $_SESSION['categoria'];

$telefono_contacto=$_REQUEST['tel_contacto'];
$email=$_REQUEST['email'];
$celular=$_REQUEST['celular'];

if(empty($telefono_contacto) && empty($email) && empty($celular))
{
    echo '<script language = javascript>
                alert("No realizaste ningun cambio a tus datos")
                self.location = "modificar_datos.php"
              </script>';
}
else
{
//    mysql_query("UPDATE clientes SET tel_contacto_nuevo='$telefono_contacto', email_nuevo='$email', celular_nuevo='$celular' WHERE id_cliente='$id'",$conex);
    if(isset($telefono_contacto) && !empty($telefono_contacto))
    {
        mysql_query("UPDATE clientes SET tel_contacto_nuevo='$telefono_contacto', estado='M' WHERE id_cliente='$id'",$conex);
    }
    if(isset($email) && !empty($email))
    {
        mysql_query("UPDATE clientes SET email_nuevo='$email', estado='M' WHERE id_cliente='$id'",$conex);
    }
    if(isset($celular) && !empty($celular))
    {
        mysql_query("UPDATE clientes SET celular_nuevo='$celular', estado='M' WHERE id_cliente='$id'",$conex);
    }
    echo '<script language = javascript>
                alert("Se enviara un email indicando que tus datos fueron modificados")
                self.location = "modificar_datos.php"
              </script>';
}
?>