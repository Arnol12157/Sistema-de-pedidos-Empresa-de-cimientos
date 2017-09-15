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

$numero_entrega=$_REQUEST['numero_entrega'];
$fecha_hora_entrega=$_REQUEST['fecha_hora_entrega'];
$nombre_receptor=$_REQUEST['nombre_receptor'];
$ci_receptor=$_REQUEST['ci_receptor'];
$numero_remito=$_REQUEST['numero_remito'];
$numero_factura=$_REQUEST['numero_factura'];
$distribuidor=$_REQUEST['distribuidor'];
//$hora_entrega=time()
$id_pedido=$_REQUEST['id_pedido'];

$idDetalle=$_REQUEST['idDetalle'];
$idArticulo=$_REQUEST['idArticulo'];
$cantidad=$_REQUEST['cantidadent'];
$fecha_ent=$_REQUEST['fechaent'];
//$fecha_com=date("Y-m-d", strtotime($_REQUEST['fechacom']));
$count= count($idDetalle);

if(isset($numero_entrega) && !empty($numero_entrega) && isset($fecha_hora_entrega) && !empty($fecha_hora_entrega) && isset($nombre_receptor) && !empty($nombre_receptor) && isset($ci_receptor) && !empty($ci_receptor) && isset($numero_remito) && !empty($numero_remito))
{
    $resultado_fecha=mysql_query("SELECT NOW() AS fecha",$conex);
    $row_fecha=mysql_fetch_array($resultado_fecha);
    $fecha=$row_fecha['fecha'];

    mysql_query("UPDATE entregas SET fecha_hora_entrega='$fecha_hora_entrega', nombre_receptor='$nombre_receptor', numero_remito='$numero_remito', numero_factura='$numero_factura', codigo_distribuidor_final='$distribuidor', ci_receptor='$ci_receptor' WHERE id_entrega='$numero_entrega'",$conex);

    $ver=0;
    for ( $i = 0 ; $i < $count ; $i++ )
    {
        if($cantidad[$i] !== "0" &&  !empty($cantidad[$i]))
        {
            $resultado_ped=mysql_query("SELECT * FROM detalle_pedido WHERE id_detalle='$idDetalle[$i]'");
            $row_ped=mysql_fetch_array($resultado_ped);
            $lugar_ent=$row_ped['lugar_pro'];
            $pendiente=$row_ped['pendiente'];
            $final_pendiente=$pendiente-$cantidad[$i];
            if($final_pendiente>0)
            {
                $ver=1;
            }

            mysql_query("UPDATE detalle_pedido SET pendiente=$final_pendiente, cantidad_ent='$cantidad[$i]', fecha_ent='$fecha_ent[$i]', lugar_ent='$lugar_ent' WHERE id_detalle='$idDetalle[$i]'",$conex);
            mysql_query("UPDATE detalle_entrega SET cantidad_entregada='$cantidad[$i]' WHERE id_entrega='$numero_entrega' AND articulo='$idArticulo[$i]'",$conex);

            mysql_query("UPDATE detalle_pedido SET cantidad_pro='0' WHERE id_detalle='$idDetalle[$i]'",$conex);
        }

        $resultado_ver=mysql_query("SELECT * FROM detalle_pedido WHERE id_pedido='$id_pedido' AND pendiente!='0'");
        $row_ver=mysql_num_rows($resultado_ver);

        if($row_ver>0)
        {
            mysql_query("UPDATE pedidos SET estado='M' WHERE id_pedido='$id_pedido'",$conex);
        }
        elseif($row_ver==0)
        {
            mysql_query("UPDATE pedidos SET estado='C' WHERE id_pedido='$id_pedido'",$conex);
        }
        mysql_query("UPDATE entregas SET estado='E' WHERE id_entrega='$numero_entrega'",$conex);
    }

    echo '<script language = javascript>
                alert("Entrega procesada correctamente")
                self.location = "procesar_entregas_realizadas.php"
              </script>';
}
else
{
    echo '<script language = javascript>
                alert("Datos incorretos")
                self.location = "procesar_entregas_realizadas.php"
              </script>';
}
?>