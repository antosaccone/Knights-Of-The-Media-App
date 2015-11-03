<?php

$dbhost = '127.0.0.1';
$dbuser = 'lxihgfsz_knigths';
$dbpass = 'knightsofthemedia01';
$dbname = 'lxihgfsz_knigths-media';

header('Content-Type: text/javascript; charset=UTF-8'); 
$resultados = array();
$conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

/* Extrae los valores enviados desde la aplicacion movil */
$usuarioEnviado = $_GET['usuario'];
$passwordEnviado = $_GET['password'];

/* revisar existencia del usuario con la contraseña en la bd */
$sqlCmd = "SELECT nombreUsuario, clave, idUsuario
FROM usuarios
WHERE nombreUsuario
LIKE '".mysqli_real_escape_string($conexion,$usuarioEnviado)."' 
AND clave ='".mysqli_real_escape_string($conexion,$passwordEnviado)."'
LIMIT 1";

mysqli_query($conexion,"SET NAMES 'utf8'");
$sqlQry = mysqli_query($conexion,$sqlCmd);

if(mysqli_num_rows($sqlQry)>0){

	$login=1;

	$fila = mysqli_fetch_array($sqlQry); //hago esto para poder extraer el id usuario que peciso.

	$idUsuario =  $fila["idUsuario"];
	
	// nueva consulta para listar proyectos en base al id del usuario que se registro.

	//$sqlP = "SELECT * FROM proyectos where idUsuario = '$idUsuario'";
	
	$sql = "SELECT * FROM textos_app INNER JOIN usuarios ON textos_app.idUsuario = usuarios.idUsuario WHERE textos_app.idUsuario = '$idUsuario'"; 
	
	//$sql = "SELECT * FROM textos WHERE idUsuario = '$idUsuario' INNER JOIN  usuarios ON textos.idUsuario = usuarios.idUsuario"; 
	
	mysqli_query($conexion,"SET NAMES 'utf8'");
	$sqlQry = mysqli_query($conexion,$sql);

	/*while ($r = mysqli_fetch_assoc($sqlQry)){ // tiene q ser assoc para que no me cree arrays multimedimensional, probar que muestra un echo con array y otro con assoc
		$resultados[] = $r;
	}*/

	while ($r = mysqli_fetch_array($sqlQry)){ // tiene q ser assoc para que no me cree arrays multimedimensional, probar que muestra un echo con array y otro con assoc
		$resultados[] = $r;
	}

	//echo json_encode($array);
}else{
	$login=0;
}

$resultados["validacion"] = "neutro";

if( $login==1 ){
	$resultados["validacion"] = "ok";
	//$sql2 = 'SELECT * FROM textos_app WHERE  = '.$_POST["idTexto"].'';
}else{
	$resultados["validacion"] = "error";
}

$resultadosJson = json_encode($resultados);

/*muestra el resultado en un formato que no da problemas de seguridad en browsers */
echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';

?>