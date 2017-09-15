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

$id_pedido=$_REQUEST['id_pedido'];
$distribuidor=$_REQUEST['distribuidor'];
$idDetalle=$_REQUEST['idDetalle'];
$cantidad=$_REQUEST['cantidadpro'];
$fecha_pro=$_REQUEST['fechapro'];
//$fecha_com=date("Y-m-d", strtotime($_REQUEST['fechacom']));
$count= count($idDetalle);

//if(isset($lugar_entrega) && !empty($lugar_entrega) && isset($hora_entrega) && !empty($hora_entrega))
//{

    $cont=0;
    $resultado_pedi=mysql_query("SELECT * FROM pedidos WHERE id_pedido='$id_pedido'");
    $row_pedi=mysql_fetch_array($resultado_pedi);
    $id_clienteped=$row_pedi['id_cliente'];
    for ( $i = 0 ; $i < $count ; $i++ )
    {
        if($cantidad[$i] !== "0" &&  !empty($cantidad[$i]))
        {
            $resultado_ped=mysql_query("SELECT * FROM detalle_pedido WHERE id_detalle='$idDetalle[$i]'");
            $row_ped=mysql_fetch_array($resultado_ped);
            $lugar_pro=$row_ped['lugar_com'];
            $precio=$row_ped['precio_venta'];
            $codigo_articulo=$row_ped['articulo'];
            mysql_query("UPDATE detalle_pedido SET cantidad_pro='$cantidad[$i]', fecha_pro='$fecha_pro[$i]', lugar_pro='$lugar_pro' WHERE id_detalle='$idDetalle[$i]'",$conex);
            $cont=$cont+1;
            if($cont==1)
            {
                mysql_query("INSERT INTO entregas VALUES (DEFAULT,'1','T','','','','','$distribuidor','','','$id_pedido','$id_clienteped')",$conex);
                $numero_entrega=mysql_insert_id($conex);
            }
            $monto=$precio*$cantidad[$i];
            $SQL = "INSERT INTO detalle_entrega VALUES (DEFAULT,'$numero_entrega','$codigo_articulo','$precio','$monto','$cantidad[$i]')";
            mysql_query($SQL,$conex);
        }
    }

    if($cont>0)
    {
        mysql_query("UPDATE pedidos SET estado='T' WHERE id_pedido='$id_pedido'",$conex);
        $mensaje="Entrega programada satisfactoriamente, el numero de entrega es ".$numero_entrega;
        echo "<script language = javascript>
                alert('$mensaje')
                self.location = 'programar_entregas.php'
              </script>";
    }


/*
}
else
{
    echo '<script language = javascript>
                alert("Datos incorretos")
                self.location = "aceptar_pedidos.php"
              </script>';
}
*/
?>