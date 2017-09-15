<?php
//Proceso de conexi�n con la base de datos
$conex = mysql_connect("localhost", "root") or die("No se pudo realizar la conexion");
mysql_select_db("neomixlt", $conex) or die("ERROR con la base de datos");
