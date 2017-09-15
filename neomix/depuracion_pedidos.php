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

//$query_pedidos = "SELECT * FROM pedidos WHERE estado='R' OR estado='C' OR estado='X';";
$query_pedidos = "SELECT * FROM pedidos WHERE estado='R' OR estado='X';";
$resultado_pedidos = mysql_query($query_pedidos, $conex);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Depuracion de pedidos</title>

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
            <li class="navbar-title">Depuracion de pedidos</li>
        </ul>
        <?php include_once("template_navbar1.php");?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Depuracion de pedidos
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="Ldepurar_pedidos.php" method="post">
                            <div class="section">
                                <div class="section-title">Seleccione la fecha de depuracion para los pedidos</div>
                                <div class="section-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Fecha de depuracion</label>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" name="fecha_dep" placeholder="fecha de depuracion" required />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">Clic en las flechas para seleccionar una fecha</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary">Depurar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Solicitudes particulares
                    </div>
                    <div class="card-body no-padding">
                        <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Numero de cliente</th>
                                <th>Nombre o razon social</th>
                                <th>Fecha de realizacion del pedido</th>
                                <th>Fecha de entrega</th>
                                <th>Lugar de entrega</th>
                                <th>Estado del pedido</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($dato_pedido = mysql_fetch_array($resultado_pedidos))
                            {
                                $id_pedido=$dato_pedido['id_pedido'];
                                $id_cliente=$dato_pedido['id_cliente'];
                                $query_cliente="SELECT * FROM clientes WHERE id_cliente='$id_cliente'";
                                $resultado_cliente=mysql_query($query_cliente,$conex);
                                $dato_cliente=mysql_fetch_array($resultado_cliente);
                                echo "<tr>";
                                echo "<td>" . $dato_cliente['num_cliente'] . "</td>";
                                if(strcasecmp($dato_cliente['nombres'],'')==0)
                                {
                                    echo "<td>" . $dato_cliente['razon_social'] . "</td>";
                                }
                                elseif(strcasecmp($dato_cliente['nombres'],'')!=0)
                                {
                                    echo "<td>".$dato_cliente['nombres']." ".$dato_cliente['apellidos']."</td>";
                                }
                                echo "<td>" . $dato_pedido['fecha'] . "</td>";
                                echo "<td>" . $dato_pedido['fecha_entrega_sol'] . "</td>";
                                echo "<td>" . $dato_pedido['lugar_entrega_sol'] . "</td>";
                                if(strcasecmp($dato_pedido['estado'],'R')==0)
                                {
                                    echo "<td>RECHAZADO</td>";
                                }
                                elseif(strcasecmp($dato_pedido['estado'],'C')==0)
                                {
                                    echo "<td>CUMPLIDO</td>";
                                }
                                elseif(strcasecmp($dato_pedido['estado'],'X')==0)
                                {
                                    echo "<td>CANCELADO</td>";
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

</body>
</html>