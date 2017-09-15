<?php

$num_cliente=$_REQUEST["codigo"];
$clave=$_REQUEST["clave"];

include("Conexion.php");

$num_cliente = mysql_real_escape_string($num_cliente);
$clave = mysql_real_escape_string($clave);

//Inicio de variables de sesi�n
if (!isset($_SESSION))
{
    session_start();
}
$new_num=str_pad($num_cliente, 5, '0', STR_PAD_LEFT);
$consulta=mysql_query("SELECT * FROM clientes WHERE num_cliente='".$new_num."' AND clave_acceso='".$clave."'");
if($row=mysql_fetch_array($consulta))
{
    //Definimos las variables de sesi�n y redirigimos a la p�gina de usuario
    $_SESSION['id_cliente'] = $row['id_cliente'];
    $_SESSION['estado'] = $row['estado'];
    $_SESSION['num_cliente'] = $row['num_cliente'];
    $_SESSION['clave_acceso'] = $row['clave_acceso'];
    $_SESSION['categoria'] = $row['categoria'];


    if(strcasecmp($row['clave_acceso_antigua'],'NULL')==0)
    {
        echo '<script language = javascript>
    alert("Porfavor cambie la clave de acceso de su cuenta para poder ingresar al sistema")
    self.location = "cambiar_clave.php"
    </script>';
    }
    else
    {
        header("location: index.php");
    }
}
else
{
    echo '<script language = javascript>
    alert("Datos incorrectos, verifique los datos ingresados")
    self.location = "login.php"
    </script>';
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
