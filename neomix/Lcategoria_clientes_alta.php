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

$categoria=$_REQUEST['categoria'];
$descripcion=$_REQUEST['descripcion'];

$resultado_validate=mysql_query("SELECT * FROM categorias_clientes WHERE tipo='$categoria'",$conex);
$validate=mysql_num_rows($resultado_validate);

if($validate>=1)
{
    echo '<script language = javascript>
                alert("Ya existe la categoria ingresada, porfavor ingrese otra")
                self.location = "categoria_clientes_alta.php"
              </script>';
}
else
{
    if (isset($categoria) && !empty($categoria) && isset($descripcion) && !empty($descripcion)) {

        if(strlen($categoria)<5)
        {
            if(!preg_match('/[A-Z]{1}/',"$categoria"))
            {
                $categoria=str_pad($categoria, 5, '0', STR_PAD_LEFT);
            }
        }

        mysql_query("INSERT INTO categorias_clientes VALUES ('$categoria','$descripcion')", $conex);

        echo '<script language = javascript>
                    alert("Categoria registrada con exito")
                    self.location = "categoria_clientes_alta.php"
                  </script>';
    } else {
        echo '<script language = javascript>
                    alert("Datos erroneos o incompletos")
                    self.location = "categoria_clientes_alta.php"
                  </script>';
    }
}
?>