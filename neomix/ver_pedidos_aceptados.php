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

$id_cliente=$_GET['num'];
$query_cliente = "SELECT * FROM clientes WHERE id_cliente='$id_cliente';";
$resultado_cliente = mysql_query($query_cliente, $conex);
$row_cliente=mysql_fetch_array($resultado_cliente);

$query_fecha = "SELECT * FROM detalle_pedido WHERE id_pedido='$id_pedido' AND id_detalle=(SELECT MAX(id_detalle) FROM detalle_pedido WHERE id_pedido='$id_pedido');";
$resultado_fecha = mysql_query($query_fecha, $conex);
$row_fecha=mysql_fetch_array($resultado_fecha);
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
            <div class="col-md-5">
                <a type="button" class="btn btn-success" href="" onclick="window.print();">Imprimir Detalle</a>
            </div>
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
                                            <input type="text" class="form-control" disabled value="<?php echo $row_pedido['nit'] ?>" />
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
                                            <textarea class="form-control" name="lugar_entrega" disabled><?php echo $row_pedido['lugar_convenido'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Fecha de entrega comprometida</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control" disabled value="<?php echo $row_fecha['fecha_com'] ?>"/>
                                            <input type="hidden" class="form-control" name="id_pedido" value="<?php echo $id_pedido ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Persona de contacto</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="id_pedid" disabled value="
                                            <?php
                                                if(strcasecmp($row_cliente['nombres'],'')==0)
                                                {
                                                    echo $row_cliente['persona_contacto'];
                                                }
                                                elseif(strcasecmp($row_cliente['nombres'],'')!=0)
                                                {
                                                    echo $row_cliente['nombres']." ".$row_cliente['apellidos'];
                                                }
                                            ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Telefono de contacto</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="id_pedi" disabled value="<?php echo $row_cliente['tel_contacto'] ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="mytable">
                                            <thead>
                                            <tr>
                                                <th>Articulo</th>
                                                <th>Descripcion</th>
                                                <th>Precio</th>
                                                <th>Cantidad solicitada</th>
                                                <th>Monto</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $suma_cantidad=0;
                                            $suma_monto=0;
                                            while ($dato_detalle = mysql_fetch_array($resultado_detalle))
                                            {
                                                $suma_cantidad+=$dato_detalle['cantidad_com'];
                                                $suma_monto+=($dato_detalle['precio_venta']*$dato_detalle['cantidad_com']);
                                                $codigo_articulo=$dato_detalle['articulo'];
                                                $query_artiulo = "SELECT * FROM articulos WHERE codigo='$codigo_articulo';";
                                                $resultado_articulo = mysql_query($query_artiulo, $conex);
                                                $row_articulo=mysql_fetch_array($resultado_articulo);
                                                echo "<input type='hidden' name='idDetalle[]' value='".$dato_detalle['id_detalle']."'  />";
                                                echo "<tr>";
                                                echo "<td>".$dato_detalle['articulo']."</td>";
                                                echo "<td>".$row_articulo['descripcion']."</td>";
                                                echo "<td>".$dato_detalle['precio_venta']."</td>";
                                                echo "<td>".$dato_detalle['cantidad_com']."</td>";
                                                echo "<td>".$dato_detalle['precio_venta']*$dato_detalle['cantidad_com']."</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <?php
                                                echo "<td>Total: ".$suma_cantidad."</td>";
                                                ?>
                                                <?php
                                                echo "<td>Total: ".$row_pedido['costo_total']."</td>";
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