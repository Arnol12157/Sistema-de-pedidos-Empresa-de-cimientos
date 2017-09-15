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

$id_cliente=$_GET['idc'];

$query_solicitudes_particulares = "SELECT * FROM clientes WHERE id_cliente='$id_cliente';";
$resultado_solicitudes_particulares = mysql_query($query_solicitudes_particulares, $conex);
$dato_particulares = mysql_fetch_array($resultado_solicitudes_particulares);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Autorizar modificaciones</title>

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
            <li class="navbar-title">Ver modificaciones</li>
        </ul>
        <?php include_once("template_navbar1.php");?>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Modificaciones realizadas
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="Lcompletar_modificacion_p.php" method="post" enctype="multipart/form-data">
                            <div class="section">
                                <div class="section-body">
                                    <?php
                                        if(strcasecmp($dato_particulares['persona_contacto_nuevo'],'')!=0)
                                        {
                                            echo "<div class='checkbox'>
                                                            <input type='checkbox' id='checkbox1' name='per_con_nuevo' value='". $dato_particulares['persona_contacto_nuevo'] ."'/>
                                                                <label for='checkbox1'>
                                                                    La persona de contacto '". $dato_particulares['persona_contacto'] ."' cambio a '". $dato_particulares['persona_contacto_nuevo'] ."'
                                                                </label>
                                                          </div>";
                                        }
                                        else
                                        {
                                            echo "<input type='hidden' name='per_con_nuevo' value='0'/>";
                                        }

                                        if(strcasecmp($dato_particulares['telefono_empresa_nuevo'],'0')!=0)
                                        {
                                            echo "<div class='checkbox'>
                                                                <input type='checkbox' id='checkbox2' name='tel_empre_nuevo' value='". $dato_particulares['telefono_empresa_nuevo'] ."'/>
                                                                    <label for='checkbox2'>
                                                                        El telefono de la empresa '". $dato_particulares['telefono_empresa'] ."' cambio a '". $dato_particulares['telefono_empresa_nuevo'] ."'
                                                                    </label>
                                                              </div>";
                                        }
                                        else
                                        {
                                            echo "<input type='hidden' name='tel_empre_nuevo' value='0'/>";
                                        }

                                        if(strcasecmp($dato_particulares['tel_contacto_nuevo'],'0')!=0)
                                        {
                                            echo "<div class='checkbox'>
                                                    <input type='checkbox' id='checkbox3' name='tel_contacto_nuevo' value='". $dato_particulares['tel_contacto_nuevo'] ."'/>
                                                        <label for='checkbox3'>
                                                            El telefono de contacto '". $dato_particulares['tel_contacto'] ."' cambio a '". $dato_particulares['tel_contacto_nuevo'] ."'
                                                        </label>
                                                  </div>";
                                        }
                                        else
                                        {
                                            echo "<input type='hidden' name='tel_contacto_nuevo' value='0'/>";
                                        }

                                        if(strcasecmp($dato_particulares['email_nuevo'],'')!=0)
                                        {
                                            echo "<div class='checkbox'>
                                                        <input type='checkbox' id='checkbox4' name='email_nuevo' value='". $dato_particulares['email_nuevo'] ."'/>
                                                            <label for='checkbox4'>
                                                                El email '". $dato_particulares['email'] ."' cambio a '". $dato_particulares['email_nuevo'] ."'
                                                            </label>
                                                      </div>";
                                        }
                                        else
                                        {
                                            echo "<input type='hidden' name='email_nuevo' value='0'/>";
                                        }

                                        if(strcasecmp($dato_particulares['celular_nuevo'],'0')!=0)
                                        {
                                            echo "<div class='checkbox'>
                                                        <input type='checkbox' id='checkbox5' name='celular_nuevo' value='". $dato_particulares['celular_nuevo'] ."'/>
                                                            <label for='checkbox5'>
                                                                El numero de celular '". $dato_particulares['celular'] ."' cambio a '". $dato_particulares['celular_nuevo'] ."'
                                                            </label>
                                                      </div>";
                                        }
                                        else
                                        {
                                            echo "<input type='hidden' name='celular_nuevo' value='0'/>";
                                        }

                                        if(strcasecmp($dato_particulares['direccion_nuevo'],'')!=0)
                                        {
                                            echo "<div class='checkbox'>
                                                        <input type='checkbox' id='checkbox6' name='direccion_nuevo' value='". $dato_particulares['direccion_nuevo'] ."'/>
                                                            <label for='checkbox6'>
                                                                La direccion '". $dato_particulares['direccion'] ."' cambio a '". $dato_particulares['direccion_nuevo'] ."'
                                                            </label>
                                                      </div>";
                                        }
                                        else
                                        {
                                            echo "<input type='hidden' name='direccion_nuevo' value='0'/>";
                                        }

                                        if(strcasecmp($dato_particulares['zona_nuevo'],'')!=0)
                                        {
                                            echo "<div class='checkbox'>
                                                            <input type='checkbox' id='checkbox7' name='zona_nuevo' value='". $dato_particulares['zona_nuevo'] ."'/>
                                                                <label for='checkbox7'>
                                                                    La zona '". $dato_particulares['zona'] ."' cambio a '". $dato_particulares['zona_nuevo'] ."'
                                                                </label>
                                                          </div>";
                                        }
                                        else
                                        {
                                            echo "<input type='hidden' name='zona_nuevo' value='0'/>";
                                        }

                                        if(strcasecmp($dato_particulares['telefonos_nuevo'],'')!=0)
                                        {
                                            echo "<div class='checkbox'>
                                                            <input type='checkbox' id='checkbox8' name='telefonos_nuevo' value='". $dato_particulares['telefonos_nuevo'] ."'/>
                                                                <label for='checkbox8'>
                                                                    El telefono extra '". $dato_particulares['telefonos'] ."' cambio a '". $dato_particulares['telefonos_nuevo'] ."'
                                                                </label>
                                                          </div>";
                                        }
                                        else
                                        {
                                            echo "<input type='hidden' name='telefonos_nuevo' value='0'/>";
                                        }

                                        if(strcasecmp($dato_particulares['categoria_nuevo'],'')!=0)
                                        {
                                            echo "<div class='checkbox'>
                                                            <input type='checkbox' id='checkbox9' name='categoria_nuevo' value='". $dato_particulares['categoria_nuevo'] ."'/>
                                                                <label for='checkbox9'>
                                                                    La categoria '". $dato_particulares['categoria'] ."' cambio a '". $dato_particulares['categoria_nuevo'] ."'
                                                                </label>
                                                          </div>";
                                        }
                                        else
                                        {
                                            echo "<input type='hidden' name='categoria_nuevo' value='0'/>";
                                        }

                                        if(strcasecmp($dato_particulares['credito_nuevo'],'')!=0)
                                        {
                                            echo "<div class='checkbox'>
                                                                <input type='checkbox' id='checkbox11' name='credito_nuevo' value='". $dato_particulares['credito_nuevo'] ."'/>
                                                                    <label for='checkbox11'>
                                                                        El credito autorizado '". $dato_particulares['credito'] ."' cambio a '". $dato_particulares['credito_nuevo'] ."'
                                                                    </label>
                                                              </div>";
                                        }
                                        else
                                        {
                                            echo "<input type='hidden' name='credito_nuevo' value='0'/>";
                                        }

                                        if(strcasecmp($dato_particulares['comentario_nuevo'],'')!=0)
                                        {
                                            echo "<div class='checkbox'>
                                                                    <input type='checkbox' id='checkbox10' name='comen_nuevo' value='". $dato_particulares['comentario_nuevo'] ."'/>
                                                                        <label for='checkbox10'>
                                                                            El comentario '". $dato_particulares['comentario'] ."' cambio a '". $dato_particulares['comentario_nuevo'] ."'
                                                                        </label>
                                                                  </div>";
                                        }
                                        else
                                        {
                                            echo "<input type='hidden' name='comen_nuevo' value='0'/>";
                                        }
                                    ?>
                                    <div class="checkbox">
                                        <input type="hidden" class="form-control" name="idc" value="<?php echo $id_cliente ?>" required/>
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

</body>
</html>