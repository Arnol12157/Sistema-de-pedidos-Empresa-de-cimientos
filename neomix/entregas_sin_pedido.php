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

$query_distribuidores = "SELECT * FROM distribuidores ORDER BY id_distribuidor;";
$resultado_distribuidores = mysql_query($query_distribuidores, $conex);

$query_categoria = "SELECT * FROM categorias_clientes ORDER BY tipo;";
$resultado_categoria = mysql_query($query_categoria, $conex);
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

<style>

input[type=number]::-webkit-outer-spin-button,

input[type=number]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance:textfield;
}

</style>
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
                        <form class="form form-horizontal" action="completar_sin_pedido.php">
                            <div class="section">
                                <div class="section-body">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Numero de cliente</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="numero_cliente" maxlength="5" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Fecha y hora de entrega</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="datetime-local" class="form-control" name="fecha_hora_entrega" required />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">Clic en las flechas para seleccionar una fecha</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Nombre y apellido del receptor</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" maxlength="100" name="nombre_receptor" onkeyup="conMayusculas(this)" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">CI del receptor</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="ci_receptor" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Numero de remito</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="numero_remito" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Numero de factura</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="numero_factura" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Codigo de distribuidor</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <select class="select2" name="distribuidor">
                                                    <?php
                                                    while ($dato_distribuidor = mysql_fetch_array($resultado_distribuidores))
                                                    {
                                                        echo "<option value='". $dato_distribuidor['id_distribuidor'] ."'>". $dato_distribuidor['id_distribuidor'] ."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Categoria de cliente</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <select class="select2" name="categoria">
                                                    <?php
                                                    while ($dato_categoria = mysql_fetch_array($resultado_categoria))
                                                    {
                                                        echo "<option value='". $dato_categoria['tipo'] ."'>". $dato_categoria['tipo'] ."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Lugar de entrega</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <select class="select2" name="lugar_entrega">
                                                    <option value="PLANTA">PLANTA</option>
                                                    <option value="DOMICILIO">DOMICILIO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary">Siguiente</button>
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