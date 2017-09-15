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

$clientes_estado=$_REQUEST['estado_clientes'];
$numero_inicial=$_REQUEST['numero_inicial'];
$numero_final=$_REQUEST['numero_final'];

if(empty($numero_final) || empty($numero_inicial))
{
    echo '<script language = javascript>
                alert("Seleccione un rango de numero de cliente para ver el reporte")
                self.location = "clientes_estado.php"
              </script>';
}

$query_clientes = "SELECT * FROM clientes WHERE estado='$clientes_estado' AND id_cliente BETWEEN '$numero_inicial' AND '$numero_final' ORDER BY num_cliente;";
$resultado_clientes = mysql_query($query_clientes, $conex);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Clientes por estado</title>

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
            <li class="navbar-title">Clientes por estado</li>
            <div class="text-right col-md-3">
                <a type="button" class="btn btn-success" href="pdf_clientes_por_estado.php?est=<?php echo $clientes_estado; ?>&ni=<?php echo $numero_inicial ?>&nf=<?php echo $numero_final ?>">REPORTE EN PDF</a>
            </div>
        </ul>
        <ul class="nav navbar-nav navbar-left">
            <div class="text-right col-md-3">
                <a type="button" class="btn btn-success" href="excel_clientes_por_estado.php?est=<?php echo $clientes_estado; ?>&ni=<?php echo $numero_inicial ?>&nf=<?php echo $numero_final ?>">REPORTE EN EXCEL</a>
            </div>
        </ul>
        <?php include_once("template_navbar1.php");?>

        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Clientes por estado
                    </div>
                    <div class="card-body no-padding">
                        <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Numero de cliente</th>
                                <th>Nombre o Razon social</th>
                                <th>Tipo de cliente</th>
                                <th>Direccion</th>
                                <th>Zona</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Categoria</th>
                                <th>Fecha de ultimo pedido</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($dato_clientes = mysql_fetch_array($resultado_clientes))
                            {
                                echo "<tr>";
                                echo "<td>" . $dato_clientes['num_cliente'] . "</td>";
                                if(strcasecmp($dato_clientes['nombres'],'')==0)
                                {
                                    echo "<td>" . $dato_clientes['razon_social'] . "</td>";
                                    echo "<td>EMPRESA</td>";
                                }
                                elseif(strcasecmp($dato_clientes['razon_social'],'')==0)
                                {
                                    echo "<td>".$dato_clientes['nombres']." ".$dato_clientes['apellidos']."</td>";
                                    echo "<td>PARTICULAR</td>";
                                }
                                echo "<td>" . $dato_clientes['direccion'] . "</td>";
                                echo "<td>" . $dato_clientes['zona'] . "</td>";
                                echo "<td>" . $dato_clientes['telefonos'] . "</td>";
                                echo "<td>" . $dato_clientes['email'] . "</td>";
                                echo "<td>" . $dato_clientes['categoria'] . "</td>";
                                echo "<td>" . $dato_clientes['fecha_ult_pedido'] . "</td>";
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