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

$numero_cliente=$_REQUEST['numero_cliente'];
$fecha_hora_entrega=$_REQUEST['fecha_hora_entrega'];
$nombre_receptor=$_REQUEST['nombre_receptor'];
$ci_receptor=$_REQUEST['ci_receptor'];
$numero_remito=$_REQUEST['numero_remito'];
$numero_factura=$_REQUEST['numero_factura'];
$distribuidor=$_REQUEST['distribuidor'];
$categoria=$_REQUEST['categoria'];
$lugar_entrega=$_REQUEST['lugar_entrega'];
$query_articulos = "SELECT articulos.codigo, articulos.descripcion, precios.precio_planta, precios.precio_domicilio
                                      FROM articulos
                                      INNER JOIN precios
                                      ON articulos.codigo=precios.codigo_articulo
                                      WHERE precios.categoria_cliente='$categoria';";
$resultado_articulos = mysql_query($query_articulos, $conex);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Entregas realizadas sin pedido</title>

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
            <li class="navbar-title">Entregas realizadas sin pedido</li>
        </ul>
        <?php include_once("template_navbar1.php");?>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Entregas realizadas sin pedido
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="Lcompletar_sin_pedido.php">
                            <div class="section">
                                <div class="section-body">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" name="numero_cliente" value="<?php echo $numero_cliente ?>" />
                                        <input type="hidden" class="form-control" name="fecha_hora_entrega" value="<?php echo $fecha_hora_entrega ?>" />
                                        <input type="hidden" class="form-control" name="nombre_receptor" value="<?php echo $nombre_receptor ?>" />
                                        <input type="hidden" class="form-control" name="ci_receptor" value="<?php echo $ci_receptor ?>" />
                                        <input type="hidden" class="form-control" name="numero_remito" value="<?php echo $numero_remito ?>" />
                                        <input type="hidden" class="form-control" name="numero_factura" value="<?php echo $numero_factura ?>" />
                                        <input type="hidden" class="form-control" name="distribuidor" value="<?php echo $distribuidor ?>" />
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
                                            while ($dato_articulo = mysql_fetch_array($resultado_articulos))
                                            {
                                                $id_art=$dato_articulo['codigo'];
                                                if(strcasecmp($lugar_entrega,'PLANTA')==0)
                                                {
                                                    $precio=$dato_articulo['precio_planta'];
                                                }
                                                elseif(strcasecmp($lugar_entrega,'DOMICILIO')==0)
                                                {
                                                    $precio=$dato_articulo['precio_domicilio'];
                                                }
                                                echo "<input type='hidden' name='idArticulo[]' value='".$dato_articulo['codigo']."'  />";
                                                echo "<tr>";
                                                echo "<td><input type='text' name='descripcion[]' class='' readonly value='".$dato_articulo['descripcion']."' /></td>";
                                                echo "<td><input type='number' name='precio[]' class='price' readonly value='".$precio."' min='0' /></td>";
                                                echo "<td><input type='number' name='cantidad[]' class='quant' value='0' min='0' /></td>";
                                                echo "<td class='sub'><span>0</span></td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>Total:</td>
                                                <td id="grand"><span>0</span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
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