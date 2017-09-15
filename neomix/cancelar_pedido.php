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

$id_pedido=$_GET['idp'];
$query_pedido = "SELECT * FROM pedidos WHERE id_pedido='$id_pedido';";
$resultado_pedido = mysql_query($query_pedido, $conex);
$row_pedido=mysql_fetch_array($resultado_pedido);

$query_detalle = "SELECT * FROM detalle_pedido WHERE id_pedido='$id_pedido';";
$resultado_detalle = mysql_query($query_detalle, $conex);

$query_detalle1 = "SELECT * FROM detalle_pedido WHERE id_pedido='$id_pedido';";
$resultado_detalle1 = mysql_query($query_detalle1, $conex);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Ver pedido</title>

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
            <li class="navbar-title">Ver pedido</li>
        </ul>
        <?php include_once("template_navbar1.php");?>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Detalle del pedido
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="">
                            <div class="section">
                                <div class="section-body">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Lugar de entrega solicitado</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" disabled><?php echo $row_pedido['lugar_entrega_sol'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Fecha de entrega solicitado</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control" disabled value="<?php echo $row_pedido['fecha_entrega_sol'] ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">NIT</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" disabled value="<?php echo $row_pedido['nit'] ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Nombre o razon social</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" disabled value="<?php echo $row_pedido['razon_social'] ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Lugar de entrega convenido</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" disabled><?php echo $row_pedido['lugar_convenido'] ?></textarea>
                                        </div>
                                    </div>
                                    <!--
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Hora de entrega aproximada</label>
                                        </div>
                                        <div class="col-md-9">
                                            <?php
                                               // echo "<input type='text' class='form-control' disabled value='".$row_pedido['hora_entrega']."' />";
                                            ?>
                                            <input type="hidden" class="form-control" name="id_pedido" value="<?php // echo $id_pedido ?>"/>
                                        </div>
                                    </div>
                                    -->
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="mytable">
                                            <thead>
                                            <tr>
                                                <th>Descripcion</th>
                                                <th>Cantidad solicitada</th>
                                                <th>Fecha solicitada</th>
                                                <th>Cantidad comprometida</th>
                                                <th>Fecha comprometida</th>
                                                <th>Cantidad programada</th>
                                                <th>Fecha programada</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            while ($dato_detalle1 = mysql_fetch_array($resultado_detalle1))
                                            {
                                                echo "<tr>";
                                                echo "<td>".$dato_detalle1['articulo']."</td>";
                                                echo "<td>".$dato_detalle1['cantidad_sol']."</td>";
                                                echo "<td>".$dato_detalle1['fecha_sol']."</td>";
                                                echo "<td>".$dato_detalle1['cantidad_com']."</td>";
                                                echo "<td>".$dato_detalle1['fecha_com']."</td>";
                                                echo "<td>".$dato_detalle1['cantidad_pro']."</td>";
                                                echo "<td>".$dato_detalle1['fecha_pro']."</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="mytable">
                                            <thead>
                                            <tr>
                                                <th>Descripcion</th>
                                                <th>Precio</th>
                                                <th>Monto</th>
                                                <th>Cantidad pendiente</th>
                                                <th>Monto pendiente</th>
                                                <th>Cantidad entregada</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $totalmonpen=0;
                                            while ($dato_detalle = mysql_fetch_array($resultado_detalle))
                                            {
                                                echo "<input type='hidden' name='idDetalle[]' value='".$dato_detalle['id_detalle']."'  />";
                                                echo "<tr>";
                                                echo "<td>".$dato_detalle['articulo']."</td>";
                                    //            echo "<td><input type='number' name='precio[]' class='price' value='".$dato_detalle['precio_venta']."' min='0' /></td>";
                                                echo "<td>".$dato_detalle['precio_venta']."</td>";
                                                /*
                                                if(strcasecmp($dato_detalle['cantidad_ent'],'0')!=0)
                                                {
                                                    echo "<td>".$dato_detalle['cantidad_ent']."</td>";
                                                }
                                                elseif(strcasecmp($dato_detalle['cantidad_pro'],'0')!=0)
                                                {
                                                    echo "<td>".$dato_detalle['cantidad_pro']."</td>";
                                                }
                                                elseif(strcasecmp($dato_detalle['cantidad_com'],'0')!=0)
                                                {
                                                    echo "<td>".$dato_detalle['cantidad_com']."</td>";
                                                }
                                                elseif(strcasecmp($dato_detalle['cantidad_sol'],'0')!=0)
                                                {

                                                }
                                                */
                                                echo "<td>".$dato_detalle['monto']."</td>";
                                                echo "<td>".$dato_detalle['pendiente']."</td>";
//                                                echo "<td><input type='number' name='cantidad[]' class='quant' value='".$dato_detalle['pendiente']."' min='0' /></td>";
                                                $monpen=$dato_detalle['pendiente']*$dato_detalle['precio_venta'];
                                                $totalmonpen+=$monpen;
                                                echo "<td class='sub' id='sub'><span>".round($monpen,2)."</span></td>";
                                                $resto=$dato_detalle['cantidad_com']-$dato_detalle['pendiente'];
                                                echo "<td>".$resto."</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td>Total:</td>
                                                <?php
                                                echo "<td>".$row_pedido['costo_total']."</td>";
                                                ?>
                                                <td>Total:</td>
                                                <?php
                                                echo "<td>".$totalmonpen."</td>";
                                                ?>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3">
                                        <div>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">
                                                Cancelar pedido
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once("template_footer.php");?>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Cancelar pedido</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form form-horizontal" action="Lcancelar_pedido.php">
                            <div class="section">
                                <div class="section-body">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Observacion</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="observacion" maxlength="150" required onkeyup="conMayusculas(this)"></textarea>
                                            <input type="hidden" name="id_pedidoobs" value="<?php echo $id_pedido ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3">
                                        <button type="submit" class="btn btn-danger">Cancelar pedido</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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