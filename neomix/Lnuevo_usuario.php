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

$nombre_n=$_REQUEST['nombre_n'];
$email_n=$_REQUEST['email_n'];
$codigo_n=$_REQUEST['codigo_n'];
$contra_n=$_REQUEST['contra_n'];

$resultado_validate=mysql_query("SELECT * FROM usuarios WHERE email='$email_n' OR clave='$codigo_n'",$conex);
$validate=mysql_num_rows($resultado_validate);

if($validate>=1)
{
    echo '<script language = javascript>
                alert("Ya hay un usuario con el mismo email o codigo")
                self.location = "nuevo_usuario.php"
              </script>';
}
else
{
    if(isset($nombre_n) && !empty($nombre_n) && isset($email_n) && !empty($email_n) && isset($contra_n) && !empty($contra_n) && isset($codigo_n) && !empty($codigo_n))
    {
        $resultado_fecha=mysql_query("SELECT NOW() AS fecha",$conex);
        $row_fecha=mysql_fetch_array($resultado_fecha);
        $fecha=$row_fecha['fecha'];

        if(strlen($codigo_n)<5)
        {
            if(!preg_match('/[A-Z]{1}/',"$codigo_n"))
            {
                $codigo_n=str_pad($codigo_n, 5, '0', STR_PAD_LEFT);
            }
        }

        mysql_query("INSERT INTO usuarios VALUES ('$nombre_n','$email_n','$contra_n','$codigo_n','$fecha','1','0')",$conex);
        //$last_id=mysql_insert_id();

        $query_procesos = "SELECT * FROM procesos;";
        $resultado_procesos = mysql_query($query_procesos, $conex);
        while($dato_proceso=mysql_fetch_array($resultado_procesos))
        {
            $id_proceso=$dato_proceso['id_proceso'];
            $id_acceso=$codigo_n.$id_proceso;
            mysql_query("INSERT INTO accesos VALUES ('$id_acceso','$codigo_n','$id_proceso','0')",$conex);
        }

        echo '<script language = javascript>
                alert("Registroso existoso")
                self.location = "nuevo_usuario.php"
              </script>';
    }
    else
    {
        echo '<script language = javascript>
                alert("Datos erroneos o incompletos")
                self.location = "nuevo_usuario.php"
              </script>';
    }
}
?>