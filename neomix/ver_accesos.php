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
$id_usuario=$_GET['idu'];

$query_accesos_usuario = "SELECT procesos.menu, procesos.descripcion, accesos.id_proceso, accesos.id_acceso, accesos.estado
                                      FROM procesos
                                      INNER JOIN accesos
                                      ON procesos.id_proceso=accesos.id_proceso
                                      WHERE accesos.id_usuario='$id_usuario';";
$resultado_accesos_usuario = mysql_query($query_accesos_usuario, $conex);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Accesos</title>

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
            <li class="navbar-title">Accesos</li>
        </ul>
        <?php include_once("template_navbar1.php");?>

        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Listado de procesos
                    </div>
                    <div class="card-body no-padding">
                        <form class='form form-horizontal' action='Lver_accesos.php' method="post">
                            <table class=" table table-striped primary" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Descripcion</th>
                                    <th>Confirmar</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($dato_acc_usu = mysql_fetch_array($resultado_accesos_usuario))
                                {
                                    $id_acc=$dato_acc_usu['id_acceso'];
                                    echo "<tr>";
                                    echo "<td>" . $dato_acc_usu['descripcion'] . "</td>";
                                    echo "<td class='text-center'>";
                                    if(strcasecmp($dato_acc_usu['estado'],'1')==0)
                                    {
                                        echo "<input type='checkbox' name='idacc[]' value='".$id_acc."' checked>";
                                    }
                                    elseif(strcasecmp($dato_acc_usu['estado'],'0')==0)
                                    {
                                        echo "<input type='checkbox' name='idacc[]' value='".$id_acc."'>";
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                ?>
                                <tr>
                                    <td><input type="hidden" name="idusu" value="<?php echo $id_usuario ?>"></td>
                                    <td><button type='submit' class='btn btn-primary'>Confirmar</button></td>
                                </tr>
                                </tbody>

                            </table>
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