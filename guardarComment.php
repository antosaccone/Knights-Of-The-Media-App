<?php

$dbhost = '127.0.0.1';
$dbuser = 'lxihgfsz_knigths';
$dbpass = 'knightsofthemedia01';
$dbname = 'lxihgfsz_knigths-media';

header('Content-Type: text/javascript; charset=UTF-8'); 
$resultados = array();
$conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

/* Extrae los valores enviados desde la aplicacion movil */
$mailEnviado = $_GET['mail'];
$comentarioEnviado = $_GET['comentario'];
$proyectoEnviado = $_GET['proyecto'];

/* Hacer consulta en la BD */
$sqlCmd = "INSERT INTO comments (email, comment, proyecto) VALUES ('$mailEnviado', '$comentarioEnviado', '$proyectoEnviado')" ;

mysqli_query($conexion,"SET NAMES 'utf8'");
$sqlQry = mysqli_query($conexion,$sqlCmd);

$resultadosJson = '{"item":'.json_encode($resultados).'}';

/*muestra el resultado en un formato que no da problemas de seguridad en browsers */
echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';

?>