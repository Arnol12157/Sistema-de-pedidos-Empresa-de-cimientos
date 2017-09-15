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

$credito=$_REQUEST['credito'];
$lugar=$_REQUEST['lugar'];
if(isset($_REQUEST['idArticulo']))
{
    $idArticulo=$_REQUEST['idArticulo'];
    $count= count($idArticulo);
}
else
{
    $idArticulo="";
    $count=0;
}
if(isset($_REQUEST['cantidad']))
{
    $cantidad=$_REQUEST['cantidad'];
}
else
{
    $cantidad=null;
}

if(isset($_REQUEST['lugar_entrega']))
{
    $lugar_entre=$_REQUEST['lugar_entrega'];
}
else
{
    $lugar_entre="";
}
if(isset($_REQUEST['fecha_entrega']))
{
    $fecha_entre=$_REQUEST['fecha_entrega'];
}
else
{
    $fecha_entre="";
}

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

/*$query_articulos = "SELECT articulos.codigo, articulos.descripcion, precios.precio_planta, precios.precio_domicilio
                                      FROM articulos
                                      INNER JOIN precios
                                      ON articulos.codigo=precios.codigo_articulo
                                      WHERE precios.categoria_cliente='$categoria' AND articulos.estado='A';";
*/
/*$query_articulos = "SELECT articulos.codigo, articulos.descripcion, articulos.aplicacion, precios.precio_contado_domicilio, precios.precio_contado_planta, precios.precio_credito_domicilio, precios.precio_credito_planta
                                      FROM articulos
                                      INNER JOIN precios
                                      ON articulos.codigo=precios.codigo_articulo
                                      WHERE articulos.estado='A';";
*/
$query_articulos="SELECT * FROM articulos WHERE estado='A'";
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
                        Entrega a <?php echo $lugar ?> pago a <?php if(strcasecmp($credito,'NO')==0){echo 'contado';} else{echo 'credito';} ?>
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="entregar.php" enctype="multipart/form-data" method="post">
                            <div class="section">
                                <div class="section-body">
                                    <?php
                                    echo "<input type='hidden' name='lugar_entrega' value='".$lugar_entre."'  />";
                                    echo "<input type='hidden' name='fecha_entrega' value='".$fecha_entre."'  />";

                                    if(strcasecmp($lugar,'domicilio')==0)
                                    {
                                        echo '
                                                    <div class="form-group">
                                                        <div class="col-md-3">
                                                            <label class="control-label">Lugar de entrega</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <textarea class="form-control" name="lugar_entrega" maxlength="150" onkeyup="conMayusculas(this)" required>'.$lugar_entre.'</textarea>
                                                        </div>
                                                    </div>
                                                 ';
                                    }
                                    else
                                    {
                                        echo '
                                                    <div class="form-group">
                                                        <div class="col-md-3">
                                                            <label class="control-label">Lugar de entrega</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <textarea class="form-control" name="lugar_entrega" maxlength="150" readonly onkeyup="conMayusculas(this)">PLANTA</textarea>
                                                        </div>
                                                    </div>
                                                 ';
                                    }
                                    ?>
                                    <!--
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Lugar de entrega</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="lugar_entrega" maxlength="150" onkeyup="conMayusculas(this)"></textarea>
                                        </div>
                                    </div>
                                    -->
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Fecha de entrega</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" name="fecha_entrega" placeholder="" required value="<?php echo $fecha_entre ?>" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">Clic en las flechas para seleccionar una fecha</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="mytable">
                                            <thead>
                                            <tr>
                                                <th>Aplicacion</th>
                                                <th>Codigo</th>
                                                <th>Descripcion</th>
                                                <!--
                                                <th>Precio</th>
                                                -->
                                                <th>Cantidad</th>
                                                <!--
                                                <th>Monto</th>
                                                -->
                                                <th>Precio</th>
                                                <th>Monto</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $i=0;
                                            $suma_total=0;
                                            $suma_cantidad=0;
                                            echo "<input type='hidden' name='lugar' value='".$lugar."' />";
                                            echo "<input type='hidden' name='credito' value='".$credito."' />";
                                            while ($dato_articulo = mysql_fetch_array($resultado_articulos))
                                            {
                                                $id_art=$dato_articulo['codigo'];
                                                echo "<input type='hidden' name='idArticulo[]' value='".$dato_articulo['codigo']."'  />";
                                                echo "<input type='hidden' name='idArticulof[]' value='".$dato_articulo['codigo']."'  />";
                                                echo "<tr>";
                                                echo "<td><button type='button' class='btn btn-success' data-toggle='modal' data-target='#myModal".$id_art."'>
                                                            Ver
                                                          </button>
                                                          <div class='modal fade' id='myModal".$id_art."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
                                                            <div class='modal-dialog'>
                                                                <div class='modal-content' style='background-color: #F3E2A9'>
                                                                    <div class='modal-header' style='background-color: #F3E2A9; padding: 1%'>
                                                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                                                        <h5 class='modal-title'>Aplicacion del articulo ".$id_art."</h5>
                                                                    </div>
                                                                    <div class='modal-body' style='padding: 2%'>
                                                                        <form class='form form-horizontal' action=''>
                                                                            <div class='section'>
                                                                                <div class='section-body'>
                                                                                    <div class='form-group'>
                                                                                        <div class='col-md-12'>
                                                                                            <h6><textarea class='form-control' style='height: 400px; width: 100%' readonly name='observacion'>".$dato_articulo['aplicacion']."</textarea></h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type='hidden' value='".$dato_articulo['aplicacion']."' />
                                                      </td>";
                                                echo "<td>".$dato_articulo['codigo']."</td>";
                                                echo "<td>".$dato_articulo['descripcion']."</td>";
                                                echo "<input type='hidden' name='descripcion[]' value='".$dato_articulo['descripcion']."' />";
                                                echo "<input type='hidden' name='descripcionf[]' value='".$dato_articulo['descripcion']."' />";

                                                if($cantidad!=null &&  !empty($cantidad[$i]))
                                                {
                                                    echo "<td><input type='number' name='cantidad[]' class='quanti' value='$cantidad[$i]' min='0' /></td>";
                                                    echo "<input type='hidden' name='cantidadf[]' value='".$cantidad[$i]."' />";
                                                    $suma_cantidad+=$cantidad[$i];

                                                    $cantidad_query = $cantidad[$i];
                                                    $codigo_query = $idArticulo[$i];
                                                    $query_ppa = "SELECT * FROM precios WHERE cantidad>='$cantidad_query' AND codigo_articulo='$codigo_query' AND cantidad=(SELECT MIN(cantidad) FROM precios WHERE cantidad>='$cantidad_query' AND codigo_articulo='$codigo_query' ORDER BY cantidad);";
                                                    $resultado_ppa = mysql_query($query_ppa, $conex);
                                                    $dato_ppa = mysql_fetch_array($resultado_ppa);

                                                    if (strcasecmp($lugar, 'domicilio') == 0 && strcasecmp($credito, 'NO') == 0) {
                                                        echo "<td><input type='number' name='preciof[]' class='price' readonly value='" . $dato_ppa['precio_contado_domicilio'] . "' min='0' /></td>";
                                                        $precio_obtenido = $dato_ppa['precio_contado_domicilio'];
                                                    } elseif (strcasecmp($lugar, 'domicilio') == 0 && strcasecmp($credito, 'SI') == 0) {
                                                        echo "<td><input type='number' name='preciof[]' class='price' readonly value='" . $dato_ppa['precio_credito_domicilio'] . "' min='0' /></td>";
                                                        $precio_obtenido = $dato_ppa['precio_credito_domicilio'];
                                                    } elseif (strcasecmp($lugar, 'planta') == 0 && strcasecmp($credito, 'NO') == 0) {
                                                        echo "<td><input type='number' name='preciof[]' class='price' readonly value='" . $dato_ppa['precio_contado_planta'] . "' min='0' /></td>";
                                                        $precio_obtenido = $dato_ppa['precio_contado_planta'];
                                                    } elseif (strcasecmp($lugar, 'planta') == 0 && strcasecmp($credito, 'SI') == 0) {
                                                        echo "<td><input type='number' name='preciof[]' class='price' readonly value='" . $dato_ppa['precio_credito_planta'] . "' min='0' /></td>";
                                                        $precio_obtenido = $dato_ppa['precio_credito_planta'];
                                                    }
                                                }
                                                else
                                                {
                                                    echo "<input type='hidden' name='cantidadf[]' value='0' />";
                                                    echo "<td><input type='number' name='cantidad[]' class='quanti' value='0' min='0' /></td>";
                                                    echo "<td><input type='number' name='preciof[]' class='price' readonly value='0' min='0' /></td>";
                                                    $precio_obtenido = 0;
                                                }
                                                $valor_calculado=$precio_obtenido*$cantidad[$i];
                                                $suma_total+=$valor_calculado;
                                                $i++;
                                                echo "<td class='sub' id='subu'><span>$valor_calculado</span></td>";
                                                //echo "<td class='sub' id='subu'><span>0</span></td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                            <!--
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>Total:</td>
                                                <td id="grand"><span>0</span></td>
                                            </tr>
                                            -->
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>Total:</td>
                                                <td><?php echo $suma_cantidad; ?></td>
                                                <td>Total:</td>
                                                <td><?php echo $suma_total; ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-4">
                                        <input type="submit" class="btn btn-primary" value="Valorizar" onclick="this.form.action='entregar.php'"/>
                                        <input type="submit" class="btn btn-success" value="Confirmar" onclick="this.form.action='Lentregar.php'"/>
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
//    $(window).unload(
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

            updateGrand();
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