<?php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

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

    <div class="app-container app-login">
        <div class="flex-center">
            <div class="app-header"></div>
            <div class="app-body">
                <div class="loader-container text-center">
                    <div class="icon">
                        <div class="sk-folding-cube">
                            <div class="sk-cube1 sk-cube"></div>
                            <div class="sk-cube2 sk-cube"></div>
                            <div class="sk-cube4 sk-cube"></div>
                            <div class="sk-cube3 sk-cube"></div>
                        </div>
                    </div>
                    <div class="title">Ingresando...</div>
                </div>
                <div style="background-color: #fff; padding: 10%">
                    <div class="app-form">
                        <div class="form-header">
                            <div class="app-brand"><span class="highlight">NEO</span>MIX</div>
                        </div>
                        <form action="ingresar.php" method="POST">
                            <div class="input-group">
                              <span class="input-group-addon" id="basic-addon1">
                                <i class="fa fa-user" aria-hidden="true"></i>
                              </span>
                                <input type="text" name="codigo" class="form-control" placeholder="Codigo de cliente" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon2">
                                    <i class="fa fa-key" aria-hidden="true"></i>
                                </span>
                                <input type="password" name="clave" class="form-control" placeholder="Clave de acceso" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-center">
                                <input type="submit" class="btn btn-success btn-submit" value="Ingresar">
                            </div>
                        </form>
                        <div class="form-line">
                            <div class="title">Registrate</div>
                        </div>
                        <div class="form-footer text-center">
                            <a type="button" id="particular" href="registro_particular.php" class="btn btn-default btn-sm btn-social __facebook">
                                <div class="info">
                                    <i class="icon fa fa-male" aria-hidden="true"></i>
                                    <span class="title">Particular</span>
                                </div>
                            </a>
                            <a type="button" id="empresa" href="registro_empresa.php" class="btn btn-default btn-sm btn-social __facebook">
                                <div class="info">
                                    <i class="icon fa fa-group" aria-hidden="true"></i>
                                    <span class="title">Empresa</span>
                                </div>
                            </a>
                        </div>
                        <hr>
                        <div class="text-center">
                            <a href="olvide_mi_clave.php">Olvide mi clave!</a>
<!--                            <div class="title">Registrate</div>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-footer">
            </div>
        </div>
    </div>

</div>

<!--<script type="text/javascript" src="../assets/js/vendor.js"></script>-->
<script type="text/javascript" src="../assets/js/app.js"></script>

<script type="text/javascript">
    $('#particular').click(function(e) {
        e.preventDefault(); e.stopPropagation();
        window.location.href = $(e.currentTarget).data().href;
    });
</script>

<script type="text/javascript">
    $('#empresa').click(function(e) {
        e.preventDefault(); e.stopPropagation();
        window.location.href = $(e.currentTarget).data().href;
    });
</script>

</body>
</html>
