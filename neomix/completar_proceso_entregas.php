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
$iden=$_GET['ien'];
$query_detalle = "SELECT * FROM detalle_pedido WHERE id_pedido='$id_pedido';";
$resultado_detalle = mysql_query($query_detalle, $conex);

$query_detalle1 = "SELECT * FROM detalle_pedido WHERE id_pedido='$id_pedido';";
$resultado_detalle1 = mysql_query($query_detalle1, $conex);

$query_entr="SELECT MAX(id_entrega) AS maximo FROM entregas WHERE id_pedido='$id_pedido';";
$res_entr=mysql_query($query_entr,$conex);
$data_entr=mysql_fetch_array($res_entr);
$id_data_entr=$data_entr['maximo'];
$query_antdis = "SELECT * FROM entregas WHERE id_pedido='$id_pedido' AND id_entrega='$id_data_entr';";
$resultado_antdis = mysql_query($query_antdis, $conex);
$data_antdis=mysql_fetch_array($resultado_antdis);

$query_distribuidores = "SELECT * FROM distribuidores WHERE estado!='I' ORDER BY id_distribuidor;";
$resultado_distribuidores = mysql_query($query_distribuidores, $conex);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Procesar entregas realizadas</title>

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
            <li class="navbar-title">Procesar entregas</li>
        </ul>
        <?php include_once("template_navbar1.php");?>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Detalle del pedido
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="Lprocesar_entrega.php">
                            <div class="section">
                                <div class="section-body">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Numero de entrega</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" value="<?php echo $iden; ?>" name="numero_entrega" readonly />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Fecha y hora de entrega</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="datetime-local" class="form-control" name="fecha_hora_entrega" min="" max="<?php echo date('Y-m-d\TH:i'); ?>" required />
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
                                            <input type="hidden" class="form-control" name="id_pedido" value="<?php echo $id_pedido ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Codigo de distribuidor</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <select class="select2" name="distribuidor">
                                                    <option value="<?php echo $data_antdis['codigo_distribuidor_asignado']; ?>"><?php echo $data_antdis['codigo_distribuidor_asignado']; ?> (Actual)</option>
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
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="mytable">
                                            <thead>
                                            <tr>
                                                <th>Descripcion</th>
                                                <th>Cantidad solicitada</th>
                                                <th>Fecha solicitada</th>
                                                <th>Cantidad comprometida</th>
                                                <th>Fecha comprometida</th>
                                                <th>Cantidad pendiente</th>
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
                                                echo "<td>".$dato_detalle1['pendiente']."</td>";
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
                                                <th>Cantidad programada</th>
                                                <th>Fecha de entrega programada</th>
                                                <th>Cantidad entregada</th>
                                                <th>Fecha de entrega final</th>
                                                <th>Repetir fecha de entrega programada</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            while ($dato_detalle = mysql_fetch_array($resultado_detalle))
                                            {
                                                echo "<input type='hidden' name='idArticulo[]' value='".$dato_detalle['articulo']."'  />";
                                                echo "<input type='hidden' name='idDetalle[]' value='".$dato_detalle['id_detalle']."'  />";
                                                echo "<tr>";
                                                echo "<td>".$dato_detalle['articulo']."</td>";
                                                echo "<td>".$dato_detalle['precio_venta']."</td>";
                                                echo "<td>".$dato_detalle['cantidad_pro']."</td>";
                                                echo "<td>".$dato_detalle['fecha_pro']."</td>";
                                                echo "<td><input type='number' name='cantidadent[]' min='0' max='".$dato_detalle['cantidad_pro']."' value='0' /></td>";
                                                $id_detalle=$dato_detalle['id_detalle'];
                                                echo "<td><input type='date' name='fechaent[]' id='$id_detalle' value='".date('Y-m-d')."' min='".$dato_detalle['fecha_pro']."' max='".date('Y-m-d')."' /></td>";
                                                //echo "<td><input type='date' name='fechaent[]' value='".$dato_detalle['fecha_pro']."' max='".date('Y-m-d')."' /></td>";
                                                $fecha_progra=$dato_detalle['fecha_pro'];
                                                //$fecha_progra= strtotime($fecha_progra);
                                                //$interval=date_diff($fecha_progra,date('Y-m-d'));
                                                $id_detallemas=$id_detalle."3000";
                                                echo "<td><input type='hidden' id='".$id_detallemas."' value='".$fecha_progra."' /><input type='button' class='btn btn-primary' onclick='repetirFecha($id_detallemas,$id_detalle)' value='Repetir'/></td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary">Procesar entrega</button>
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
<script>
    function repetirFecha(iddetallemas,iddetalle)
    {
        document.getElementById(iddetalle).value=document.getElementById(iddetallemas).value;
    }
</script>
</body>
</html>