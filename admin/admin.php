<?php
require_once("control_acceso.php");
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
	<link rel="icon" type="image/x-icon" href="../img/urutrabajo.svg">
    <title>Administración</title>
</head>

<body>
	<div class="menu-admin">
		<h1>Administración</h1>
		<h2>Menú</h2>
		<a href="gestion_admins.php">Gestionar administradores</a>
		<a href="../cargos/gestion_cargos.php">Gestionar cargos</a>
		<a href="../usuarios/gestion_usuarios.php">Gestionar postulantes</a>
		<a href="index.php?salir=si">Salir</a>
	</div>
</body>
</html>
