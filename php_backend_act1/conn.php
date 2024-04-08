<?php

$db_host = 'localhost'; //variables se inician con $
$db_username = 'Karla';
$db_password = 'h3995L02';
$db_database = 'venta_autos';

$db = new mysqli($db_host, $db_username, $db_password, $db_database);
mysqli_query($db, "SET NAMES 'utf8'"); // SET NAMES sirve para que yo pueda guardar nombre y 'utf8' es para especificar que se pueda usar acentos, ñ, etc.

if($db->connect_errno > 0){
    die('No es posible conectarse a la base de datos ['.$db->connect_error .']');
}