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

$query_solicitudes_particulares = "SELECT * FROM solicitudes_clientes WHERE razon_social='';";
$resultado_solicitudes_particulares = mysql_query($query_solicitudes_particulares, $conex);

$query_categorias = "SELECT * FROM categorias_clientes;";
$resultado_categorias = mysql_query($query_categorias, $conex);

$query_clio = "SELECT * FROM solicitudes_clientes WHERE id_sol_cliente='$id_cliente';";
$resultado_clio = mysql_query($query_clio, $conex);
$data_clio=mysql_fetch_array($resultado_clio);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Aceptar solicitudes</title>

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
            <li class="navbar-title">Completar solicitud</li>
        </ul>
        <?php include_once("template_navbar1.php");?>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Ingrese los datos para registrar al cliente
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="Lcompletar_solicitud_p.php" method="post">
                            <div class="section">
                                <div class="section-body">
                                    <?php
                                    if(strcasecmp($data_clio['nombres'],'')!=0)
                                    {
                                        echo " <div class='form-group'>
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>Nombres y apellidos</label>
                                                    </div>
                                                    <div class='col-md-9'>
                                                        <input type='text' class='form-control' placeholder='" . $data_clio['nombres'] . " " . $data_clio['apellidos'] . "' disabled/>
                                                    </div>
                                                </div>";
                                        echo " <div class='form-group'>
                                                        <div class='col-md-3'>
                                                            <label class='control-label'>Email</label>
                                                        </div>
                                                        <div class='col-md-9'>
                                                            <input type='text' class='form-control' placeholder='" . $data_clio['email'] . "' disabled/>
                                                        </div>
                                                    </div>";
                                        echo " <div class='form-group'>
                                                        <div class='col-md-3'>
                                                            <label class='control-label'>Telefono de contacto</label>
                                                        </div>
                                                        <div class='col-md-9'>
                                                            <input type='text' class='form-control' placeholder='" . $data_clio['tel_contacto'] . "' disabled/>
                                                        </div>
                                                    </div>";
                                        echo " <div class='form-group'>
                                                        <div class='col-md-3'>
                                                            <label class='control-label'>Celular</label>
                                                        </div>
                                                        <div class='col-md-9'>
                                                            <input type='text' class='form-control' placeholder='" . $data_clio['celular'] . "' disabled/>
                                                        </div>
                                                    </div>";
                                    }
                                    elseif(strcasecmp($data_clio['nombres'],'')==0)
                                    {
                                        echo " <div class='form-group'>
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>Razon social</label>
                                                    </div>
                                                    <div class='col-md-9'>
                                                        <input type='text' class='form-control' placeholder='" . $data_clio['razon_social'] . "' disabled/>
                                                    </div>
                                                </div>";
                                        echo " <div class='form-group'>
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>Persona de contacto</label>
                                                    </div>
                                                    <div class='col-md-9'>
                                                        <input type='text' class='form-control' placeholder='" . $data_clio['persona_contacto'] . "' disabled/>
                                                    </div>
                                                </div>";
                                        echo " <div class='form-group'>
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>Telefono de contacto</label>
                                                    </div>
                                                    <div class='col-md-9'>
                                                        <input type='text' class='form-control' placeholder='" . $data_clio['tel_contacto'] . "' disabled/>
                                                    </div>
                                                </div>";
                                        echo " <div class='form-group'>
                                                        <div class='col-md-3'>
                                                            <label class='control-label'>Email</label>
                                                        </div>
                                                        <div class='col-md-9'>
                                                            <input type='text' class='form-control' placeholder='" . $data_clio['email'] . "' disabled/>
                                                        </div>
                                                    </div>";
                                        echo " <div class='form-group'>
                                                        <div class='col-md-3'>
                                                            <label class='control-label'>Telefono</label>
                                                        </div>
                                                        <div class='col-md-9'>
                                                            <input type='text' class='form-control' placeholder='" . $data_clio['telefono_empresa'] . "' disabled/>
                                                        </div>
                                                    </div>";
                                        echo " <div class='form-group'>
                                                        <div class='col-md-3'>
                                                            <label class='control-label'>Celular</label>
                                                        </div>
                                                        <div class='col-md-9'>
                                                            <input type='text' class='form-control' placeholder='" . $data_clio['celular'] . "' disabled/>
                                                        </div>
                                                    </div>";
                                    }
                                    ?>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Direccion</label>
                                            <p class="control-label-help">( Ingrese la direccion actual y principal de la empresa )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="direccion" maxlength="100" required onkeyup="conMayusculas(this)"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Zona - Ciudad</label>
                                            <p class="control-label-help">( Ingrese la zona o ciudad actual de la empresa )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="zona" maxlength="100" placeholder="" required onkeyup="conMayusculas(this)" />
                                            <input type="hidden" class="form-control" name="idc" value="<?php echo $id_cliente ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Telefonos adicionales</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input class="form-control" type="text" pattern="[0-9]{8}+[ ]{1}" maxlength=40 name="telefonos" onkeyup="conMayusculas(this)" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Comentario</label>
                                            <p class="control-label-help">( Ingrese un comentario o descripcion sobre la empresa , maximo 200 letras )</p>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="comentario" maxlength="200" required onkeyup="conMayusculas(this)"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Categoria</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <select class="select2" name="categoria">
                                                    <?php
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