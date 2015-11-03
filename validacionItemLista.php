<?php

$dbhost = '127.0.0.1';
$dbuser = 'lxihgfsz_knigths';
$dbpass = 'knightsofthemedia01';
$dbname = 'lxihgfsz_knigths-media';

header('Content-Type: text/javascript; charset=UTF-8'); 
$resultados = array();
$conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

/* Extrae los valores enviados desde la aplicacion movil */
$indexEnviado = $_GET['index'];

/* Hacer consulta en la BD */
$sqlCmd = "SELECT * FROM textos_app WHERE idTextoApp = '".$indexEnviado."'";

mysqli_query($conexion,"SET NAMES 'utf8'");
$sqlQry = mysqli_query($conexion,$sqlCmd);

$fila = mysqli_fetch_array($sqlQry); //hago esto para poder extraer el id usuario que peciso.

$resultados[] = $fila;

$resultadosJson = '{"item":'.json_encode($resultados).'}';

/*muestra el resultado en un formato que no da problemas de seguridad en browsers */
echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';

?>