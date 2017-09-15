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

$consulta=mysql_query("SELECT * FROM clientes WHERE id_cliente='".$id_cliente."'");
$row=mysql_fetch_array($consulta);
$tel_contacto=$row['tel_contacto'];
$celular=$row['celular'];
$email=$row['email'];
$categoria=$row['categoria'];
$credito=$row['credito'];

$query_categorias = "SELECT * FROM categorias_clientes;";
$resultado_categorias = mysql_query($query_categorias, $conex);
//$query_solicitudes_empresas = "SELECT * FROM clientes WHERE nombres='';";
//$resultado_solicitudes_empresas = mysql_query($query_solicitudes_empresas, $conex);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modificacion de clientes</title>

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
            <li class="navbar-title">Modificacion de clientes</li>
        </ul>
        <?php include_once("template_navbar1.php");?>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Debido a politicas de la empresa solo puede modificar los siguientes campos
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="Lmodificar_p.php" method="post">
                            <div class="section">
                                <div class="section-body">
                                    <?php
                                        if(strcasecmp($row['persona_contacto'],'')!=0)
                                        {
                                            echo "<div class='form-group'>
                                                     <div class='col-md-3'>
                                                         <label class='control-label'>Persona de contacto</label>
                                                            <p class='control-label-help'>( Ingrese el nombre de la nueva persona de contacto )</p>
                                                     </div>
                                                     <div class='col-md-9'>
                                                        <input type='text' class='form-control' maxlength='100' name='per_con' style='text-transform: uppercase' value='".$row['persona_contacto']."' placeholder='".$row['persona_contacto']." (Actual)' />
                                                     </div>
                                                  </div>
                                                 ";
                                        }
                                        else
                                        {
                                            echo "<input type='hidden' class='form-control' name='per_con' value='' />";
                                        }
                                        if(strcasecmp($row['telefono_empresa'],'0')!=0)
                                        {
                                            echo "<div class='form-group'>
                                                         <div class='col-md-3'>
                                                             <label class='control-label'>Telefono de la empresa</label>
                                                                <p class='control-label-help'>( Ingrese el nuevo telefono de la empresa )</p>
                                                         </div>
                                                         <div class='col-md-9'>
                                                            <input type='number' class='form-control' maxlength='100' name='tel_empresa' max='99999999' min='1000000' value='".$row['telefono_empresa']."' placeholder='".$row['telefono_empresa']." (Actual)' />
                                                         </div>
                                                      </div>
                                                     ";
                                        }
                                        else
                                        {
                                            echo "<input type='hidden' class='form-control' name='tel_empresa' value='' />";
                                        }
                                    ?>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Telefono de contacto</label>
                                            <p class="control-label-help">( Ingrese el nuevo telefono de contacto )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="tel_contacto" max="99999999" min="1000000" value="<?php echo $tel_contacto ?>" placeholder="<?php echo $tel_contacto ?> (Actual)" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Celular</label>
                                            <p class="control-label-help">( Ingrese el nuevo numero de celular )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="celular" max="99999999" min="1000000" value="<?php echo $celular ?>" placeholder="<?php echo $celular ?> (Actual)" />
                                            <input type="hidden" class="form-control" name="idc" value="<?php echo $id_cliente ?>" />
                                            <input type="hidden" class="form-control" name="cat_old" value="<?php echo $categoria ?>" />
                                            <input type="hidden" class="form-control" name="cre_old" value="<?php echo $credito ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Direccion</label>
                                            <p class="control-label-help">( Ingrese la nueva direccion )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="direccion" maxlength="100" style="text-transform: uppercase" placeholder="<?php echo $row['direccion'] ?> (Actual)"><?php echo $row['direccion'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Zona</label>
                                            <p class="control-label-help">( Ingrese la nueva zona )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="zona" maxlength="100" style="text-transform: uppercase" placeholder="<?php echo $row['zona'] ?> (Actual)"><?php echo $row['zona'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Telefonos extra</label>
                                            <p class="control-label-help">( Ingrese los nuevos telefonos extra, maximo 5 )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="tel_extra" pattern="[0-9]{8,40}+[ ]{1}" value="<?php echo $row['telefonos'] ?>" placeholder="<?php echo $row['telefonos'] ?> (Actual)" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Comentario</label>
                                            <p class="control-label-help">( Ingrese el nuevo comentario )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="comentario" maxlength="200" style="text-transform: uppercase" placeholder="<?php echo $row['comentario'] ?> (Actual)"><?php echo $row['comentario'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Categoria</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <select class="select2" name="categoria">
                                                    <?php
                                                    echo "<option value='". $categoria ."'>". $categoria ." (Actual)</option>";
                                                    while ($dato_categoria = mysql_fetch_array($resultado_categorias))
                                                    {
                                                        echo "<option value='". $dato_categoria['tipo'] ."'>". $dato_categoria['tipo'] ."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Credito autorizado</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <select class="select2" name="credito">
                                                    <?php
                                                    echo "<option value='". $credito ."'>". $credito ." (Actual)</option>";
                                                    ?>
                                                    <option value="SI">SI</option>
                                                    <option value="NO">NO</option>
                                                </select>
                                            </div>
                                        </div>
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
    function conMayusculas(field)
    {
        field.value = field.value.toUpperCase();
    }
</script>
</body>
</html>