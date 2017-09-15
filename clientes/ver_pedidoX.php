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
                        Pedido Cancelado
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="">
                            <div class="section">
                                <div class="section-body">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Motivo de la cancelacion del pedido</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" disabled><?php echo $row_pedido['observacion'] ?></textarea>
                                        </div>
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