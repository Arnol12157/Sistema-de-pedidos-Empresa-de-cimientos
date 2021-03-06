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

$id_pedido=$_GET['idp'];
$consulta=mysql_query("SELECT * FROM clientes WHERE id_cliente='".$id."'");
$row=mysql_fetch_array($consulta);
$tel_contacto=$row['tel_contacto'];
$celular=$row['celular'];
$email=$row['email'];

$query_pedido = "SELECT * FROM pedidos WHERE id_pedido='$id_pedido' AND id_cliente='$id';";
$resultado_pedido = mysql_query($query_pedido, $conex);
$row_pedido=mysql_fetch_array($resultado_pedido);

$query_fecha = "SELECT * FROM detalle_pedido WHERE id_pedido='$id_pedido' AND id_detalle=(SELECT MAX(id_detalle) FROM detalle_pedido WHERE id_pedido='$id_pedido');";
$resultado_fecha = mysql_query($query_fecha, $conex);
$row_fecha=mysql_fetch_array($resultado_fecha);

$query_detalle = "SELECT * FROM detalle_pedido WHERE id_pedido='$id_pedido';";
$resultado_detalle = mysql_query($query_detalle, $conex);

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
                                            <input class="form-control" name="fecha_entrega" value="<?php echo $row_fecha['fecha_com'] ?>" disabled/>
                                        </div>
                                    </div>
                                    <!--
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Hora de entrega aproximada</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="fecha_entrega" disabled value="<?php // echo $row_pedido['hora_entrega'] ?>" />
                                        </div>
                                    </div>
                                    -->
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="mytable">
                                            <thead>
                                            <tr>
                                                <th>Codigo</th>
                                                <th>Descripcion</th>
                                                <th>Cantidad solicitada</th>
                                                <th>Precio</th>
                                                <th>Monto</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $suma_cantidad=0;
                                            while ($dato_detalle = mysql_fetch_array($resultado_detalle))
                                            {
                                                $arti=$dato_detalle['articulo'];
                                                $query_arti = "SELECT * FROM articulos WHERE codigo='$arti';";
                                                $resultado_arti = mysql_query($query_arti, $conex);
                                                $row_arti=mysql_fetch_array($resultado_arti);
                                                echo "<tr>";
                                                echo "<td>".$dato_detalle['articulo']."</td>";
                                                echo "<td>".$row_arti['descripcion']."</td>";
                                                echo "<td><input type='number' class='quant' disabled value='".$dato_detalle['cantidad_sol']."' min='0' /></td>";
                                                echo "<td><input type='number' class='' disabled value='".$dato_detalle['precio_venta']."' min='0' /></td>";
                                                echo "<td><input type='number' class='quant' disabled value='".$dato_detalle['monto']."' min='0' /></td>";
                                                echo "</tr>";
                                                $suma_cantidad+=$dato_detalle['cantidad_sol'];
                                            }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td>Total:</td>
                                                <?php
                                                echo "<td><input type='number' class='quant' disabled value='".$suma_cantidad."' min='0' /></td>";
                                                ?>
                                                <td>Total:</td>
                                                <?php
                                                    echo "<td><input type='number' class='quant' disabled value='".$row_pedido['costo_total']."' min='0' /></td>";
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