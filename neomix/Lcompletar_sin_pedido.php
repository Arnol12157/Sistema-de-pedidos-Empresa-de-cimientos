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

$numero_cliente=$_REQUEST['numero_cliente'];
$fecha_hora_entrega=$_REQUEST['fecha_hora_entrega'];
$nombre_receptor=$_REQUEST['nombre_receptor'];
$ci_receptor=$_REQUEST['ci_receptor'];
$numero_remito=$_REQUEST['numero_remito'];
$numero_factura=$_REQUEST['numero_factura'];
$distribuidor=$_REQUEST['distribuidor'];

$idArticulo=$_REQUEST['idArticulo'];
$descripcion=$_REQUEST['descripcion'];
$precio=$_REQUEST['precio'];
$cantidad=$_REQUEST['cantidad'];

$count= count($idArticulo);

if(isset($numero_cliente) && !empty($numero_cliente) && isset($fecha_hora_entrega) && !empty($fecha_hora_entrega) && isset($nombre_receptor) && !empty($nombre_receptor) && isset($ci_receptor) && !empty($ci_receptor) && isset($numero_remito) && !empty($numero_remito) && isset($distribuidor) && !empty($distribuidor))
{
    $resultado_entregas=mysql_query("SELECT MAX(id_entrega) AS id FROM entregas",$conex);
    $row_entrega=mysql_fetch_array($resultado_entregas);
    $last_id=$row_entrega['id'];
    $next_id=$last_id+1;

    mysql_query("INSERT INTO entregas VALUES ('$next_id','0','E','$fecha_hora_entrega','$nombre_receptor','$numero_remito',$numero_factura,'$distribuidor','$distribuidor','$ci_receptor','','$numero_cliente')",$conex);
    $IdPedido=mysql_insert_id($conex);

    for ( $i = 0 ; $i < $count ; $i++ )
    {
        if($cantidad[$i] !== "0" &&  !empty($cantidad[$i]))
        {
            $monto=$cantidad[$i]*$precio[$i];
            $SQL = "INSERT INTO detalle_entrega VALUES (DEFAULT,'$next_id','$idArticulo[$i]','$precio[$i]','$monto','$cantidad[$i]')";
            mysql_query($SQL,$conex);
        }
    }

    echo '<script language = javascript>
                alert("Entrega sin pedido procesada con exito")
                self.location = "entregas_sin_pedido.php"
              </script>';
}
else
{
    echo '<script language = javascript>
                alert("Datos incorretos")
                self.location = "entregas_sin_pedido.php"
              </script>';
}
?>