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

$idArticulo=$_REQUEST['idArticulo'];
$descripcion=$_REQUEST['descripcion'];
$precio=$_REQUEST['precio'];
$cantidad=$_REQUEST['cantidad'];
$fecha_entrega=date("Y-m-d", strtotime($_REQUEST['fecha_entrega']));

$count= count($idArticulo);

if(isset($fecha_entrega) && !empty($fecha_entrega))
{
    $resultado_fecha=mysql_query("SELECT NOW() AS fecha",$conex);
    $row_fecha=mysql_fetch_array($resultado_fecha);
    $fecha=$row_fecha['fecha'];

    mysql_query("UPDATE clientes SET fecha_ult_pedido='$fecha' WHERE id_cliente='$id'");
    mysql_query("INSERT INTO pedidos VALUES (DEFAULT,'PLANTA','$fecha_entrega','P','$fecha','',$id,'','','','','')",$conex);
    $IdPedido=mysql_insert_id($conex);

    for ( $i = 0 ; $i < $count ; $i++ )
    {
        if($cantidad[$i] !== "0" &&  !empty($cantidad[$i]))
        {
            $monto=$cantidad[$i]*$precio[$i];
            $SQL = "INSERT INTO detalle_pedido VALUES (DEFAULT,'$IdPedido','$idArticulo[$i]','$precio[$i]','$monto','$cantidad[$i]','$fecha_entrega','PLANTA','','','','','','','','','','')";
            mysql_query($SQL,$conex);
        }
        $result = mysql_query("SELECT SUM( precio_venta * cantidad_sol ) AS total FROM detalle_pedido WHERE id_pedido = '$IdPedido'",$conex);
        $asd = mysql_fetch_array($result);
        $sum = $asd['total'];
        $sql2 = mysql_query("UPDATE pedidos SET costo_total='$sum' WHERE id_pedido = '$IdPedido'",$conex);
    }

    echo '<script language = javascript>
                alert("Tu pedido esta siendo procesado, nos comunicaremos contigo para aceptarlo")
                self.location = "index.php"
              </script>';
}
else
{
    echo '<script language = javascript>
                alert("Datos incorretos")
                self.location = "entrega_planta.php"
              </script>';
}
?>