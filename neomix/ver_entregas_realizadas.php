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

$id_entrega=$_GET['ide'];
$query_entrega = "SELECT * FROM entregas WHERE id_entrega='$id_entrega';";
$resultado_entrega = mysql_query($query_entrega, $conex);
$row_entrega=mysql_fetch_array($resultado_entrega);

$query_detalle_entrega = "SELECT * FROM detalle_entrega WHERE id_entrega='$id_entrega';";
$resultado_detalle_entrega = mysql_query($query_detalle_entrega, $conex);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Ver entrega</title>

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
            <li class="navbar-title">Ver entrega</li>
            <div class="col-md-5">
<!--                <a type="button" class="btn btn-success" href="" onclick="window.print();window.close()">Imprimir Detalle</a>-->
                <a type="button" class="btn btn-success" href="pdf_detalle_realizadas.php?ide=<?php echo $id_entrega ?>">Imprimir Detalle</a>
            </div>
        </ul>
        <?php include_once("template_navbar1.php");?>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Detalle de la entrega
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="">
                            <div class="section">
                                <div class="section-body">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Fecha y hora de la entrega</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input class="form-control" disabled value="<?php echo $row_entrega['fecha_hora_entrega'] ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Nombre del receptor</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" disabled value="<?php echo $row_entrega['nombre_receptor'] ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">CI del receptor</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" disabled value="<?php echo $row_entrega['ci_receptor'] ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Numero de remito</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" disabled value="<?php echo $row_entrega['numero_remito'] ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Numero de factura</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" disabled value="<?php echo $row_entrega['numero_factura'] ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Codigo del distribuidor</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" disabled value="<?php echo $row_entrega['codigo_distribuidor_final'] ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="mytable">
                                            <thead>
                                            <tr>
                                                <th>Descripcion</th>
                                                <th>Precio</th>
                                                <th>Cantidad entregada</th>
                                                <th>Monto</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $suma=0;
                                            while ($dato_detalle_entrega = mysql_fetch_array($resultado_detalle_entrega))
                                            {
                                                $codigo_articulo=$dato_detalle_entrega['articulo'];
                                                $query_artiulo = "SELECT * FROM articulos WHERE codigo='$codigo_articulo';";
                                                $resultado_articulo = mysql_query($query_artiulo, $conex);
                                                $row_articulo=mysql_fetch_array($resultado_articulo);
                                                echo "<tr>";
                                                echo "<td>".$row_articulo['descripcion']."</td>";
                                                echo "<td>".$dato_detalle_entrega['precio_venta']."</td>";
                                                echo "<td>".$dato_detalle_entrega['cantidad_entregada']."</td>";
                                                echo "<td>".$dato_detalle_entrega['monto']."</td>";
                                                echo "</tr>";
                                                $suma=$suma+$dato_detalle_entrega['monto'];
                                            }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>Total:</td>
                                                <?php
                                                echo "<td>".number_format((float)$suma,2,'.','')."</td>";
                                                ?>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3">

                                    </div>
                                </div>
                            </div>
                        </form>
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
    $(document).ready(function() {
        $('#mytable tr').each(function(i, elem) {
            var sub = $(elem).find('.sub span');

            // Update subtotal after the price
            $(this).find('.price').change(function() {
                var quant = $(this).parent().next().children('.quant');

                sub.text($(this).val() * quant.val());

                updateGrand();
            });

            // Update subtotal after the quantity
            $(this).find('.quant').change(function() {
                var price = $(this).parent().prev().children('.price');

                sub.text($(this).val() * price.val());

                updateGrand();
            });
        });

        // Function for updating the grand total
        function updateGrand() {
            var sum = 0;

            $('#mytable .sub span').each(function() {
                sum += parseFloat($(this).text());
            });
            sum= parseFloat((sum).toFixed(2));
            $('#grand span').text(sum);
        }
    });


</script>
<script>
    function conMayusculas(field)
    {
        field.value = field.value.toUpperCase();
    }
</script>
</body>
</html>