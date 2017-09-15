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

$consulta=mysql_query("SELECT * FROM clientes WHERE id_cliente='".$id."'");
$row=mysql_fetch_array($consulta);
$tel_contacto=$row['tel_contacto'];
$celular=$row['celular'];
$email=$row['email'];

$query_pedidos = "SELECT * FROM pedidos WHERE id_cliente='$id' AND (estado='P' OR estado='A' OR estado='R' OR estado='X');";
$resultado_pedidos = mysql_query($query_pedidos, $conex);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pedidos</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="../assets/css/vendor.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/flat-admin.css">

</head>
<body>
<div class="app app-default">

    <?php include_once("template_sidebar.php");?>

    <div class="app-container">

        <?php include_once("template_navbar.php");?>
        <ul class="nav navbar-nav navbar-left">
            <li class="navbar-title">Pedidos</li>
        </ul>
        <?php include_once("template_navbar1.php");?>

        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Listado de pedidos
                    </div>
                    <div class="card-body">
                        <table class="table table-striped primary datatable" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Estado</th>
                                <th>Lugar de entrega solicitado</th>
                                <th>Fecha de entrega solicitado</th>
                                <th>Costo total</th>
                                <th>Detalle del pedido</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($dato_pedido = mysql_fetch_array($resultado_pedidos))
                            {
                                $id_ped=$dato_pedido['id_pedido'];
                                echo "<tr>";
                                if(strcasecmp($dato_pedido['estado'],'P')==0)
                                {
                                    echo "<td>PENDIENTE</td>";
                                }
                                elseif(strcasecmp($dato_pedido['estado'],'A')==0)
                                {
                                    echo "<td>ACEPTADO</td>";
                                }
                                elseif(strcasecmp($dato_pedido['estado'],'R')==0)
                                {
                                    echo "<td>RECHAZADO</td>";
                                }
                                elseif(strcasecmp($dato_pedido['estado'],'T')==0)
                                {
                                    echo "<td>EN TRANSITO</td>";
                                }
                                elseif(strcasecmp($dato_pedido['estado'],'M')==0)
                                {
                                    echo "<td>PARCIALMENTE ENTREGADO</td>";
                                }
                                elseif(strcasecmp($dato_pedido['estado'],'C')==0)
                                {
                                    echo "<td>CUMPLIDO</td>";
                                }
                                elseif(strcasecmp($dato_pedido['estado'],'X')==0)
                                {
                                    echo "<td>CANCELADO</td>";
                                }
                                echo "<td>" . $dato_pedido['lugar_entrega_sol'] . "</td>";
                                echo "<td>" . $dato_pedido['fecha_entrega_sol'] . "</td>";
                                echo "<td>" . $dato_pedido['costo_total'] . "</td>";
                                if(strcasecmp($dato_pedido['estado'],'P')==0 || strcasecmp($dato_pedido['estado'],'R')==0)
                                {
                                    echo "<td><a type='button' class='btn btn-primary' href='ver_pedidoPR.php?idp=" . $id_ped ."'>Ver detalle</a></td>";
                                }
                                elseif(strcasecmp($dato_pedido['estado'],'A')==0)
                                {
                                    echo "<td><a type='button' class='btn btn-primary' href='ver_pedidoA.php?idp=" . $id_ped ."'>Ver detalle</a></td>";
                                }
                                elseif(strcasecmp($dato_pedido['estado'],'T')==0)
                                {
                                    echo "<td><a type='button' class='btn btn-primary' href='ver_pedidoT.php?idp=" . $id_ped ."'>Ver detalle</a></td>";
                                }
                                elseif(strcasecmp($dato_pedido['estado'],'M')==0 || strcasecmp($dato_pedido['estado'],'C')==0)
                                {
                                    echo "<td><a type='button' class='btn btn-primary' href='ver_pedidoMC.php?idp=" . $id_ped ."'>Ver detalle</a></td>";
                                }
                                elseif(strcasecmp($dato_pedido['estado'],'X')==0)
                                {
                                    echo "<td><a type='button' class='btn btn-primary' href='ver_pedidoX.php?idp=" . $id_ped ."'>Ver detalle</a></td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once("template_footer.php");?>
    </div>

</div>

<script type="text/javascript" src="../assets/js/vendor.js"></script>
<script type="text/javascript" src="../assets/js/app.js"></script>

<script>
    function conMayusculas(field)
    {
        field.value = field.value.toUpperCase();
    }
</script>


</body>
</html>