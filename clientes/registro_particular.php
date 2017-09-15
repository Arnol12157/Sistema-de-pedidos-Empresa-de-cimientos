<?php

    $k="";
    $parametros="1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $maxparam=strlen($parametros)-1;
    for($j=0;$j<5;$j++)
    {
        $k.=$parametros{mt_rand(0,$maxparam)};
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Registro particular</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="../assets/css/vendor.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/flat-admin.css">

    <!-- Theme -->
    <link rel="stylesheet" type="text/css" href="../assets/css/theme/blue-sky.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/theme/blue.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/theme/red.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/theme/yellow.css">

    <script src='https://www.google.com/recaptcha/api.js'></script>

    <style>

        input[type=number]::-webkit-outer-spin-button,

        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance:textfield;
        }

    </style>
</head>
<body>
<div class="app app-default">
    <div class="app-container app-login">
        <div class="flex-center">
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
                    <div class="title">Logging in...</div>
                </div>
                <div style="background-color: #fff; padding: 10%">
                    <div class="app-right-section">
                        <div class="app-brand"><span class="highlight">NEO</span>MIX</div>
                        <div class="app-info">
                            <ul class="list">
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </div>
                                    <div class="title"><b>Alta calidad</b></div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </div>
                                    <div class="title"><b>Productos confiables</b></div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </div>
                                    <div class="title"><b>Productos economicos</b></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="app-form">
                        <div class="form-suggestion">
                            Crea una cuenta es gratis
                        </div>
                        <form action="Lregistro_particular.php" method="post">
<!--                            <div class="input-group">-->
<!--                                <select class="select2" name="sucursal">-->
<!--                                    <option value="LPB">La Paz</option>-->
<!--                                    <option value="CBBA">Cochabamba</option>-->
<!--                                </select>-->
<!--                                <span class="input-group-addon">Sucursal</span>-->
<!--                            </div>-->
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </span>
                                <input name="nombres" type="text" class="form-control" placeholder="Nombres" aria-describedby="basic-addon1" required onkeyup="conMayusculas(this)"/>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon2">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </span>
                                <input name="apellidos" type="text" class="form-control" placeholder="Apellidos" aria-describedby="basic-addon2" required onkeyup="conMayusculas(this)"/>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon2">
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                </span>
                                <input name="telefono_contacto" type="number" class="form-control" placeholder="Telefono de contacto" aria-describedby="basic-addon2"/>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon2">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                </span>
                                <input name="email" type="email" class="form-control" placeholder="Ingrese un email privado" aria-describedby="basic-addon2" required/>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon2">
                                    <i class="fa fa-mobile" aria-hidden="true"></i>
                                </span>
                                <input name="celular" type="number" class="form-control" placeholder="Celular" aria-describedby="basic-addon2"/>
                            </div>
                            <div class="text-center">
                                <div class="col-md-6 text-center">
                                    <label>CAPTCHA</label>
                                </div>
                                <div class="col-md-6 text-center">
                                    <input name="captcha" id="captcha" disabled style="background-color: #009900; text-shadow: #fff" type="text" class="form-control" value="<?php echo $k ?>" aria-describedby="basic-addon2"/>
                                </div>
                            </div>
                            <div class="input-group">
                                <input name="copia" id="copia" type="text" class="form-control" onkeyup="validar(); conMayusculas(this);" placeholder="Escriba el codigo captcha" aria-describedby="basic-addon2"/>
                            </div>
<!--                            <div class="g-recaptcha" data-sitekey="6LeroxEUAAAAAElbTaTYcyMaMxOfLNesWg5arI9Q"></div>-->
                            <div class="text-center">
                                <input type="submit" id="botreg" class="btn btn-success btn-submit" style="display: none" value="Registrarse"/>
                            </div>
                        </form>
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
<script>
    function conMayusculas(field)
    {
        field.value = field.value.toUpperCase();
    }
</script>
<script>
    function validar(){
        var copia=document.getElementById("copia").value.toUpperCase();
        var captcha=document.getElementById("captcha").value.toUpperCase();
        if(copia==captcha)
        {
            document.getElementById("botreg").style.display='inherit';
        }
        else
        {
            document.getElementById("botreg").style.display='none';
        }
    }
</script>
</body>
</html>
