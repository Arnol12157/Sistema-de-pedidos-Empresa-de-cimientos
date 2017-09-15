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

$fecha_inicial=$_REQUEST['fecha_inicial'];
$fecha_final=$_REQUEST['fecha_final'];

if(empty($fecha_final) || empty($fecha_inicial))
{
    echo '<script language = javascript>
                alert("Seleccione un rango de fechas para ver el reporte")
                self.location = "entregas_realizadas_pri.php"
              </script>';
}

$query_reporte = "SELECT * FROM entregas WHERE estado='E' AND fecha_hora_entrega BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY fecha_hora_entrega;";
$resultado_reporte = mysql_query($query_reporte, $conex);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Entregas realizadas</title>

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
            <li class="navbar-title">Entregas realizadas</li>
            <div class="text-right col-md-3">
                <a type="button" class="btn btn-success" href="pdf_entregas_realizadas.php?fi=<?php echo $fecha_inicial ?>&ff=<?php echo $fecha_final ?>">REPORTE EN PDF</a>
            </div>
        </ul>
        <ul class="nav navbar-nav navbar-left">
            <div class="text-right col-md-3">
                <a type="button" class="btn btn-success" href="excel_entregas_realizadas.php?fi=<?php echo $fecha_inicial ?>&ff=<?php echo $fecha_final ?>">REPORTE EN EXCEL</a>
            </div>
        </ul>
        <?php include_once("template_navbar1.php");?>

        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Entregas realizadas
                    </div>
                    <div class="card-body no-padding">
                        <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Fecha y hora de la entrega realizada</th>
                                <th>Distribuidor</th>
                                <th>Numero de cliente</th>
                                <th>Nombre o razon social</th>
                                <th>Nombre del receptor</th>
                                <th>CI del receptor</th>
                                <th>Detalle de la entrega</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($dato_reporte = mysql_fetch_array($resultado_reporte))
                            {
                                $id_cliente_re=$dato_reporte['id_cliente'];
                                $query_cliente_re = "SELECT * FROM clientes WHERE id_cliente=$id_cliente_re;";
                                $resultado_cliente_re = mysql_query($query_cliente_re, $conex);
                                $row_cliente_re=mysql_fetch_array($resultado_cliente_re);
                                $id_entrega=$dato_reporte['id_entrega'];
                                echo "<tr>";
                                echo "<td>" . $dato_reporte['fecha_hora_entrega'] . "</td>";
                                echo "<td>" . $dato_reporte['codigo_distribuidor_final'] . "</td>";
                                if(strcasecmp($id_cliente_re,'00000')==0 || strcasecmp($id_cliente_re,'99999')==0)
                                {
                                    echo "<td>" . $id_cliente_re . "</td>";
                                }
                                else
                                {
                                    echo "<td>" . $row_cliente_re['num_cliente'] . "</td>";
                                }
                                if(strcasecmp($row_cliente_re['nombres'],'')==0)
                                {
                                    echo "<td>" . $row_cliente_re['razon_social'] . "</td>";
                                }
                                elseif(strcasecmp($row_cliente_re['nombres'],'')!=0)
                                {
                                    echo "<td>".$row_cliente_re['nombres']." ".$row_cliente_re['apellidos']."</td>";
                                }
                                echo "<td>" . $dato_reporte['nombre_receptor'] . "</td>";
                                echo "<td>" . $dato_reporte['ci_receptor'] . "</td>";
                                echo "<td><a type='button' class='btn btn-primary' href='ver_entregas_realizadas.php?ide=".$id_entrega."'>Detalle de la entrega</a></td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
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