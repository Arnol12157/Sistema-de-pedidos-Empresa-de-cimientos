<?php

//$archivo=fopen("../param.txt","r") or die("Error");
//$linea=fgets($archivo);
//$datos=explode(";",$linea);
//
//$host=$datos[0];
//$user=$datos[1];
//$password=$datos[2];
//$db=$datos[3];
//
//fclose($archivo);

$host="localhost";
//
//$user="neomixlt";
$user="root";
//
//$password="arnol17lucas";
////$password="";
//
$db="neomixlt";

//$conex = mysql_connect($host,$user,$password) or die("no se pudo conectar a la base de datos");
//$select_db = mysql_select_db($db,$conex);


//Proceso de conexi�n con la base de datos
$conex = mysql_connect($host, $user) or die("No se pudo realizar la conexion");
mysql_select_db($db, $conex) or die("ERROR con la base de datos");
