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

$consulta=mysql_query("SELECT * FROM clientes WHERE id_cliente='".$id."'");
$row=mysql_fetch_array($consulta);
$tel_contacto=$row['tel_contacto'];
$celular=$row['celular'];
$email=$row['email'];

if(strcasecmp($row['estado'],'I')==0 || strcasecmp($row['estado'],'S')==0 || strcasecmp($row['estado'],'M')==0)
{
    echo '<script language = javascript>
                alert("Debido a su estado, usted no puede realizar un pedido")
                self.location = "index.php"
              </script>';
}
elseif(strcasecmp($row['estado'],'O')==0)
{
    echo '<script language = javascript>
                alert("Usted fue observado, podra realizar el pedido pero no sera aceptado hasta que cambie su estado")
              </script>';
}

$query_articulos = "SELECT articulos.codigo, articulos.descripcion, precios.precio_planta, precios.precio_domicilio
                                      FROM articulos
                                      INNER JOIN precios
                                      ON articulos.codigo=precios.codigo_articulo
                                      WHERE precios.categoria_cliente='$categoria' AND articulos.estado='A';";
$resultado_articulos = mysql_query($query_articulos, $conex);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Realizar pedido</title>

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
            <li class="navbar-title">Realizar pedido</li>
        </ul>
        <?php include_once("template_navbar1.php");?>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Entrega en planta
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="Lentrega_planta.php" enctype="multipart/form-data" method="post">
                            <div class="section">
                                <div class="section-body">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Fecha de entrega</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" name="fecha_entrega" placeholder="" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">Clic en las flechas para seleccionar una fecha</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="mytable">
                                            <thead>
                                            <tr>
                                                <th>Codigo</th>
                                                <th>Descripcion</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Monto</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            while ($dato_articulo = mysql_fetch_array($resultado_articulos))
                                            {
                                                $id_art=$dato_articulo['codigo'];
                                                echo "<input type='hidden' name='idArticulo[]' value='".$dato_articulo['codigo']."'  />";
                                                echo "<tr>";
                                                echo "<td><input type='text' readonly value='".$dato_articulo['codigo']."' /></td>";
                                                echo "<td><input type='text' name='descripcion[]' class='' readonly value='".$dato_articulo['descripcion']."' /></td>";
                                                echo "<td><input type='number' name='precio[]' class='price' readonly value='".$dato_articulo['precio_planta']."' min='0' /></td>";
                                                echo "<td><input type='number' name='cantidad[]' class='quant' value='0' min='0' /></td>";
                                                echo "<td class='sub'><span>0</span></td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                            <tr>
                                                <td></td>
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

                sub.text(($(this).val() * price.val()).toFixed(2));

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