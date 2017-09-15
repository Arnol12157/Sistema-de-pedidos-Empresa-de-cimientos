<?php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="../assets/css/vendor.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/flat-admin.css">



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
                                <input name="clave" type="text" class="form-control" placeholder="Codigo de cliente" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon2">
                                    <i class="fa fa-key" aria-hidden="true"></i>
                                </span>
                                <input name="contra" type="password" class="form-control" placeholder="Contraseña" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-center">
                                <input type="submit" class="btn btn-success btn-submit" value="Ingresar">
                            </div>
                        </form>

                        <div class="form-line">
                        </div>
                        <div class="form-footer">
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
