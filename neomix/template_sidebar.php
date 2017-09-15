<?php

$query_accesos = "SELECT * FROM accesos WHERE id_usuario='$clave' AND estado='1';";
$resultado_accesos = mysql_query($query_accesos, $conex);

?>
<aside class="app-sidebar" id="sidebar">
    <div class="sidebar-header">
        <a class="sidebar-brand" href="index.php"><span class="highlight">NEO</span>MIX</a>
        <button type="button" class="sidebar-toggle">
            <i class="fa fa-times"></i>
        </button>
    </div>
    <div class="sidebar-menu">
        <ul class="sidebar-nav">
            <li class="dropdown ">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <div class="icon">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                    <div class="title">Clientes</div>
                </a>
                <div class="dropdown-menu">
                    <ul>
                        <li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> Clientes</li>
                        <?php
                            while($dato_acceso=mysql_fetch_array($resultado_accesos))
                            {
                                if($dato_acceso['id_proceso']==1)
                                {
                                    echo '<li><a href="aceptar_solicitudes.php">Aceptar solicitudes</a></li>';
                                }
                                elseif($dato_acceso['id_proceso']==2)
                                {
                                    echo '<li><a href="modificacion_clientes.php">Modificacion de clientes</a></li>';
                                }
                                elseif($dato_acceso['id_proceso']==4)
                                {
                                    echo '<li><a href="autorizar_modificaciones.php">Autorizar modificaciones</a></li>';
                                }
                                elseif($dato_acceso['id_proceso']==5)
                                {
                                    echo '<li><a href="envio_claves.php">Envio de claves a clientes</a></li>';
                                }
                                elseif($dato_acceso['id_proceso']==6)
                                {
                                    echo '<li><a href="procesar_observaciones.php">Procesar observaciones</a></li>';
                                }
                                elseif($dato_acceso['id_proceso']==7)
                                {
                                    echo '<li><a href="depuracion_solicitudes.php">Depuracion de solicitudes</a></li>';
                                }
                                elseif($dato_acceso['id_proceso']==8)
                                {
                                    echo '<li><a href="categoria_clientes_alta.php">Categorias de clientes (Alta)</a></li>';
                                }
                                elseif($dato_acceso['id_proceso']==9)
                                {
                                    echo '<li><a href="categoria_clientes_modificacion.php">Categorias de clientes (Modificacion)</a></li>';
                                }
                            }
                        ?>
                    </ul>
                </div>
            </li>
            <li class="dropdown ">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <div class="icon">
                        <i class="fa fa-truck" aria-hidden="true"></i>
                    </div>
                    <div class="title">Pedidos</div>
                </a>
                <div class="dropdown-menu">
                    <ul>
                        <li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> Pedidos</li>
                        <?php
                        $query_accesos = "SELECT * FROM accesos WHERE id_usuario='$clave' AND estado='1';";
                        $resultado_accesos = mysql_query($query_accesos, $conex);
                            while($dato_acceso=mysql_fetch_array($resultado_accesos))
                            {
                                if($dato_acceso['id_proceso']==10)
                                {
                                    echo '<li><a href="aceptar_pedidos.php">Aceptar pedidos</a></li>';
                                }
                                /*
                                elseif($dato_acceso['id_proceso']==11)
                                {
                                    echo '<li><a href="programar_entregas.php">Programar entregas</a></li>';
                                }
                                elseif($dato_acceso['id_proceso']==12)
                                {
                                    echo '<li><a href="procesar_entregas_realizadas.php">Procesar entregas realizadas</a></li>';
                                }
                                elseif($dato_acceso['id_proceso']==13)
                                {
                                    echo '<li><a href="entregas_sin_pedido.php">Entregas realizadas sin pedido</a></li>';
                                }
                                */
                                elseif($dato_acceso['id_proceso']==14)
                                {
                                    echo '<li><a href="cancelacion_pedidos.php">Cancelacion de pedidos</a></li>';
                                }
                                elseif($dato_acceso['id_proceso']==15)
                                {
                                    echo '<li><a href="depuracion_pedidos.php">Depuracion de pedidos</a></li>';
                                }
                                elseif($dato_acceso['id_proceso']==16)
                                {
                                    echo '<li><a href="alta_distribuidores.php">Altas de distribuidores</a></li>';
                                }
                                elseif($dato_acceso['id_proceso']==17)
                                {
                                    echo '<li><a href="modificacion_distribuidores.php">Modificacion de distribuidores</a></li>';
                                }
                            }
                        ?>
                        <li class="line"></li>
                    </ul>
                </div>
            </li>
            <li class="dropdown ">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <div class="icon">
                        <i class="fa fa-file" aria-hidden="true"></i>
                    </div>
                    <div class="title">Consultas y reportes</div>
                </a>
                <div class="dropdown-menu">
                    <ul>
                        <li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> Consultas y reportes</li>
                        <?php
                        $query_accesos = "SELECT * FROM accesos WHERE id_usuario='$clave' AND estado='1';";
                        $resultado_accesos = mysql_query($query_accesos, $conex);
                        while($dato_acceso=mysql_fetch_array($resultado_accesos))
                        {
                            if($dato_acceso['id_proceso']==18)
                            {
                                echo '<li><a href="pedidos_pendientes_pri.php">Pedidos pendientes</a></li>';
                            }
                            elseif($dato_acceso['id_proceso']==19)
                            {
                                echo '<li><a href="pedidos_aceptados_pri.php">Pedidos aceptados</a></li>';
                            }
                            /*
                            elseif($dato_acceso['id_proceso']==20)
                            {
                                echo '<li><a href="pedidos_entregados.php">Pedidos entregados</a></li>';
                            }
                            */
                            elseif($dato_acceso['id_proceso']==21)
                            {
                                echo '<li><a href="pedidos_fecha_comprometida_pri.php">Pedidos por fecha comprometida</a></li>';
                            }
                            /*
                            elseif($dato_acceso['id_proceso']==22)
                            {
                                echo '<li><a href="entregas_programadas_pri.php">Entregas programadas</a></li>';
                            }
                            elseif($dato_acceso['id_proceso']==23)
                            {
                                echo '<li><a href="entregas_realizadas_pri.php">Entregas realizadas</a></li>';
                            }
                            */
                            elseif($dato_acceso['id_proceso']==24)
                            {
                                echo '<li><a href="clientes_estado.php">Clientes por estado</a></li>';
                            }
                            elseif($dato_acceso['id_proceso']==35)
                            {
                                echo '<li><a href="pedidos_por_cliente_pri.php">Pedidos por cliente</a></li>';
                            }
                        }
                        ?>
                        <li class="line"></li>
                    </ul>
                </div>
            </li>
            <li class="dropdown ">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <div class="icon">
                        <i class="fa fa-cubes" aria-hidden="true"></i>
                    </div>
                    <div class="title">Articulos</div>
                </a>
                <div class="dropdown-menu">
                    <ul>
                        <li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> Articulos</li>
                        <?php
                        $query_accesos = "SELECT * FROM accesos WHERE id_usuario='$clave' AND estado='1';";
                        $resultado_accesos = mysql_query($query_accesos, $conex);
                        while($dato_acceso=mysql_fetch_array($resultado_accesos))
                        {
                            if($dato_acceso['id_proceso']==25)
                            {
                                echo '<li><a href="articulos_alta.php">Alta de articulos</a></li>';
                            }
                            elseif($dato_acceso['id_proceso']==26)
                            {
                                echo '<li><a href="articulos_modificacion.php">Modificacion de articulos</a></li>';
                            }
                            elseif($dato_acceso['id_proceso']==27)
                            {
                                echo '<li><a href="articulos_activar.php">Activacion / Desactivacion</a></li>';
                            }
                        }
                        ?>
                        <li class="line"></li>
                    </ul>
                </div>
            </li>
            <li class="dropdown ">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <div class="icon">
                        <i class="fa fa-ticket" aria-hidden="true"></i>
                    </div>
                    <div class="title">Precios</div>
                </a>
                <div class="dropdown-menu">
                    <ul>
                        <li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> Precios</li>
                        <?php
                        $query_accesos = "SELECT * FROM accesos WHERE id_usuario='$clave' AND estado='1';";
                        $resultado_accesos = mysql_query($query_accesos, $conex);
                        while($dato_acceso=mysql_fetch_array($resultado_accesos))
                        {
                            if($dato_acceso['id_proceso']==28)
                            {
                                echo '<li><a href="alta_precios.php">Alta de precios</a></li>';
                            }
                            elseif($dato_acceso['id_proceso']==29)
                            {
                                echo '<li><a href="modificacion_precios.php">Modificacion de precios</a></li>';
                            }
                            elseif($dato_acceso['id_proceso']==30)
                            {
                                echo '<li><a href="reporte_precios_pri.php">Consulta y reporte de precios</a></li>';
                            }
                        }
                        ?>
                        <li class="line"></li>
                    </ul>
                </div>
            </li>
            <li class="dropdown ">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <div class="icon">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                    <div class="title">Usuarios</div>
                </a>
                <div class="dropdown-menu">
                    <ul>
                        <li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> Usuarios</li>
                        <?php
                        $query_accesos = "SELECT * FROM accesos WHERE id_usuario='$clave' AND estado='1';";
                        $resultado_accesos = mysql_query($query_accesos, $conex);
                        while($dato_acceso=mysql_fetch_array($resultado_accesos))
                        {
                            if($dato_acceso['id_proceso']==31)
                            {
                                echo '<li><a href="nuevo_usuario.php">Añadir usuarios</a></li>';
                            }
                            elseif($dato_acceso['id_proceso']==32)
                            {
                                echo '<li><a href="lista_usuarios.php">Lista de usuarios</a></li>';
                            }
                            elseif($dato_acceso['id_proceso']==33)
                            {
                                echo '<li><a href="permisos_acceso.php">Permisos de acceso</a></li>';
                            }
                            elseif($dato_acceso['id_proceso']==34)
                            {
                                echo '<li><a href="modificar_datos.php">Modificacion de datos</a></li>';
                            }
                        }
                        ?>
                        <li class="line"></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</aside>