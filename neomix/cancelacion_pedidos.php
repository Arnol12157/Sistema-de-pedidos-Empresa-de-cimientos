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

//$query_pedidos = "SELECT * FROM pedidos WHERE estado='P' OR estado='A' OR estado='T' OR estado='M';";
$query_pedidos = "SELECT * FROM pedidos WHERE estado='P' OR estado='A';";
$resultado_pedidos = mysql_query($query_pedidos, $conex);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Cancelacion de pedidos</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="../assets/css/vendor.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/flat-admin.css">

    <!-- Theme -->
    <link rel="stylesheet" type="text/css" href="../assets/css/theme/blue-sky.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/theme/blue.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/theme/red.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/theme/yellow.css">

</head>
<body>
<div class="app app-default">

    <?php include_once("template_sidebar.php");?>

    <div class="app-container">

        <?php include_once("template_navbar.php");?>
        <ul class="nav navbar-nav navbar-left">
            <li class="navbar-title">Cancelacion de pedidos</li>
        </ul>
        <?php include_once("template_navbar1.php");?>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Cancelacion de pedidos
                    </div>
                    <div class="card-body no-padding">
                        <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Numero de cliente</th>
                                <th>Nombre o razon social</th>
                                <th>Estado del pedido</th>
                                <th>Fecha de realizacion del pedido</th>
                                <th>Ver detalle</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($dato_pedido = mysql_fetch_array($resultado_pedidos))
                            {
                                $id_pedido=$dato_pedido['id_pedido'];
                                $id_cliente=$dato_pedido['id_cliente'];
                                $query_cliente = "SELECT * FROM clientes WHERE id_cliente='$id_cliente';";
                                $resultado_cliente = mysql_query($query_cliente, $conex);
                                $row_cliente=mysql_fetch_array($resultado_cliente);
                                echo "<tr>";
                                echo "<td>" . $row_cliente['num_cliente'] . "</td>";
                                if(strcasecmp($row_cliente['nombres'],'')==0)
                                {
                                    echo "<td>" . $row_cliente['razon_social'] . "</td>";
                                }
                                elseif(strcasecmp($row_cliente['nombres'],'')!=0)
                                {
                                    echo "<td>".$row_cliente['nombres']." ".$row_cliente['apellidos']."</td>";
                                }
                                if(strcasecmp($dato_pedido['estado'],'P')==0)
                                {
                                    echo "<td>PENDIENTE</td>";
                                }
                                elseif(strcasecmp($dato_pedido['estado'],'A')==0)
                                {
                                    echo "<td>ACEPTADO</td>";
                                }
                                elseif(strcasecmp($dato_pedido['estado'],'T')==0)
                                {
                                    echo "<td>EN TRANSITO</td>";
                                }
                                elseif(strcasecmp($dato_pedido['estado'],'M')==0)
                                {
                                    echo "<td>PARCIALMENTE ENTREGADO</td>";
                                }
                                echo "<td>" . $dato_pedido['fecha'] . "</td>";
                                echo "<td><a type='button' class='btn btn-primary' href='cancelar_pedido.php?idp=" . $id_pedido ."'>Ver pedido</a></td>";
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

</body>
</html>