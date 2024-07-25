<?php
session_start();
require_once("clase_cargos.php");

$mis_cargos=new cargos();

if(isset($_GET['cargo'])){
	extract($_GET);
	$cargo_guardado=$mis_cargos -> obtener_cargo($cargo);
}

if(!isset($_SESSION['autentificado'])){
	$sesion = false;
}
else{
	$sesion = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	<link rel="icon" type="image/x-icon" href="../img/urutrabajo.svg">
    <title>Urutrabajo</title>
</head>
<body>
	<main>
		<h1 class="titulo">Información del cargo</h1>
		<?php
				$mis_cargos -> mostrar_cargo($cargo_guardado, $sesion);
			?>
	</main>
</body>
</html>