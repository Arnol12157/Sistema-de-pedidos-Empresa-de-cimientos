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

$id_cli=$row_pedido['id_cliente'];
$query_cli = "SELECT * FROM clientes WHERE id_cliente='$id_cli';";
$resultado_cli = mysql_query($query_cli, $conex);
$row_cli=mysql_fetch_array($resultado_cli);

$query_detalle = "SELECT * FROM detalle_pedido WHERE id_pedido='$id_pedido';";
$resultado_detalle = mysql_query($query_detalle, $conex);

$query_distribuidores = "SELECT * FROM distribuidores WHERE estado!='I' ORDER BY id_distribuidor;";
$resultado_distribuidores = mysql_query($query_distribuidores, $conex);
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
                        <form class="form form-horizontal" action="Lcompletar_pedido.php">
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
                                            <input type="hidden" id="lusol" value="<?php echo $row_pedido['lugar_entrega_sol'] ?>" />
                                            <input type="date" class="form-control" disabled value="<?php echo $row_pedido['fecha_entrega_sol'] ?>" />
                                        </div>
                                    </div>
                                    <div id="oculto" style="display: none">
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label class="control-label">NIT</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="nit" maxlength="11"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label class="control-label">Nombre o razon social</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="razon_social" onkeyup="conMayusculas(this)" maxlength="100" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label class="control-label">Lugar de entrega convenido</label>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea class="form-control" id="luen" name="lugar_entrega" required onkeyup="conMayusculas(this)" maxlength="150"></textarea>
                                                <input type="hidden" class="form-control" name="id_pedido" value="<?php echo $id_pedido ?>"/>
                                            </div>
                                            <div class="col-md-3 text-center">
                                                <?php
                                                echo "<input type='button' class='btn btn-primary' onclick='repetirlugar()' value='Repetir' />";
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label class="control-label">Fecha de entrega comprometida</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="date" class="form-control" name="fecha_comprometida" value="<?php echo $row_pedido['fecha_entrega_sol'] ?>" />
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
                                    </div>
                                    <!--
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Hora de entrega aproximada</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" id="time" class="form-control" maxlength=20 name="hora_entrega" required/>
                                        </div>
                                    </div>
                                    -->
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="mytable">
                                            <thead>
                                            <tr>
                                                <th>Codigo</th>
                                                <th>Descripcion</th>
                                                <th>Precio</th>
                                                <th>Cantidad solicitada</th>
                                                <th>Monto</th>
                                                <!--
                                                <th>Fecha de entrega comprometida</th>
                                                -->
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $suma_cantidad=0;
                                            while ($dato_detalle = mysql_fetch_array($resultado_detalle))
                                            {
                                                $suma_cantidad+=$dato_detalle['cantidad_sol'];

                                                $id_articulo=$dato_detalle['articulo'];
                                                $query_articulo = "SELECT * FROM articulos WHERE codigo='$id_articulo';";
                                                $resultado_articulo = mysql_query($query_articulo, $conex);
                                                $row_articulo=mysql_fetch_array($resultado_articulo);
                                                echo "<input type='hidden' name='idDetalle[]' value='".$dato_detalle['id_detalle']."'  />";
                                                echo "<tr>";
                                                echo "<td>".$dato_detalle['articulo']."</td>";
                                                echo "<td>".$row_articulo['descripcion']."</td>";
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
                                                echo "<td>".$dato_detalle['cantidad_sol']."</td>";
                                                echo "<input type='hidden' name='cantidad[]' value='".$dato_detalle['cantidad_sol']."'  />";
                                                echo "<td>".$dato_detalle['monto']."</td>";
                                                //echo "<td><input type='number' name='cantidad[]' min='0' value='0' /></td>";
                                              //  echo "<td><input type='date' name='fechacom[]' min='".date('Y-m-d')."' value='".$row_pedido['fecha_entrega_sol']."' /></td>";
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
                                                <!--
                                                <td></td>
                                                -->
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3">

                                        <?php
                                            if(strcasecmp($row_cli['estado'],'A')==0)
                                            {
                                                echo "
                                                    <div id='botonmostrar' style='display: block'>
                                                        <input type='button' class='btn btn-primary' onclick='mostrar()' value='Aceptar pedido'/>
                                                    </div>
                                                    <div id='botonaceptar' style='display: none'>
                                                        <button type='submit' class='btn btn-success'>Aceptar pedido</button>
                                                    </div>
                                                    <div>
                                                        <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#myModal'>
                                                            Rechazar pedido
                                                        </button>
                                                    </div>
                                                ";
                                            }
                                            elseif(strcasecmp($row_cli['estado'],'O')==0)
                                            {
                                                echo "<td><a type='button' class='btn btn-primary'>Revise el estado del cliente</a></td>";
                                            }
                                        ?>
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
                        <h4 class="modal-title">Rechazar pedido</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form form-horizontal" action="Lrechazar_pedido.php">
                            <div class="section">
                                <div class="section-body">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Observacion</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="observacion" maxlength="150" onkeyup="conMayusculas(this)"></textarea>
                                            <input type="hidden" name="id_pedidoobs" value="<?php echo $id_pedido ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3">
                                        <button type="submit" class="btn btn-danger">Rechazar pedido</button>
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

<script type="text/javascript">
    function mostrar(){
        document.getElementById('oculto').style.display = 'block';
        document.getElementById('botonaceptar').style.display = 'block';
        document.getElementById('botonmostrar').style.display = 'none';}
</script>

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
    function repetirlugar()
    {
        var inrepo=document.getElementById("lusol").value;
        document.getElementById("luen").value=inrepo;
//        var inrep=document.getElementById("luen").value;
//        alert(inrepo);
//        document.getElementById("luen").value=field;
//        field.value = field.value.toUpperCase();
    }
</script>
</body>
</html>