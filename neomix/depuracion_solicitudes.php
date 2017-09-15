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

$query_solicitudes_particulares = "SELECT * FROM solicitudes_clientes WHERE razon_social='';";
$resultado_solicitudes_particulares = mysql_query($query_solicitudes_particulares, $conex);

$query_solicitudes_empresas = "SELECT * FROM solicitudes_clientes WHERE nombres='';";
$resultado_solicitudes_empresas = mysql_query($query_solicitudes_empresas, $conex);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Depuracion de solicitudes</title>

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
            <li class="navbar-title">Depuracion de solicitudes</li>
        </ul>
        <?php include_once("template_navbar1.php");?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Depuracion de solicitudes de clientes
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="Ldepurar_solicitudes.php" method="post">
                            <div class="section">
                                <div class="section-title">Seleccione la fecha de depuracion para las solicitudes de clientes</div>
                                <div class="section-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Fecha de depuracion</label>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" name="fecha_dep" required placeholder="fecha de depuracion">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">Clic en las flechas para seleccionar una fecha</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary">Depurar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Solicitudes particulares
                    </div>
                    <div class="card-body no-padding">
                        <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Celular</th>
                                <th>Fecha de alta</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($dato_cliente_p = mysql_fetch_array($resultado_solicitudes_particulares))
                            {
                                $id_cliente_p=$dato_cliente_p['id_sol_cliente'];

                                echo "<tr>";
                                echo "<td>" . $dato_cliente_p['nombres'] . "</td>";
                                echo "<td>" . $dato_cliente_p['apellidos'] . "</td>";
                                echo "<td>" . $dato_cliente_p['tel_contacto'] . "</td>";
                                echo "<td>" . $dato_cliente_p['email'] . "</td>";
                                echo "<td>" . $dato_cliente_p['celular'] . "</td>";
                                echo "<td>" . $dato_cliente_p['fecha'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Solicitudes de empresas
                    </div>
                    <div class="card-body no-padding">
                        <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Razon social</th>
                                <th>Contacto</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Celular</th>
                                <th>Telefono(Empresa)</th>
                                <th>Fecha de alta</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($dato_cliente_e = mysql_fetch_array($resultado_solicitudes_empresas))
                            {
                                $id_cliente_e=$dato_cliente_e['id_sol_cliente'];

                                echo "<tr>";
                                echo "<td>" . $dato_cliente_e['razon_social'] . "</td>";
                                echo "<td>" . $dato_cliente_e['persona_contacto'] . "</td>";
                                echo "<td>" . $dato_cliente_e['tel_contacto'] . "</td>";
                                echo "<td>" . $dato_cliente_e['email'] . "</td>";
                                echo "<td>" . $dato_cliente_e['celular'] . "</td>";
                                echo "<td>" . $dato_cliente_e['telefono_empresa'] . "</td>";
                                echo "<td>" . $dato_cliente_p['fecha'] . "</td>";
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