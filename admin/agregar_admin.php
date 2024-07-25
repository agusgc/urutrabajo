<?php
require_once("/clase_admins.php");

require_once("control_acceso.php");

$mis_admins=new admins();
$admins_guardados=$mis_admins -> listar();

if(isset($_POST['enviar'])){
    $mis_admins -> usuario_existe($admins_guardados, $_POST['usuario']);
    
	$exito=$mis_admins -> agregar($_POST);
	
	if($exito){
		echo("<script>alert('Agregado con éxito')</script>");
		//header("Location:index.php");
	}
	else{
		echo("<script>alert('No se pudo agregar')</script>");
	}
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
	<link rel="stylesheet" href="../formularios.css">
    <title>Agregar administrador</title>
</head>
<body>
	<main>
		<form method="post" action="agregar_admin.php" enctype="multipart/form-data" class="login">
			<h2>Agregar administrador</h2>
			<div>
				<input type="text" name="usuario" id="usuario" placeholder="Usuario" required>
			</div>
			<div>
				<input type="password" name="password" id="password" placeholder="Contraseña" required>
			</div>
			<input type="submit" value="Ingresar" id="enviar" name="enviar">
		</form>
	</main>
	<button class="atras"><a href="gestion_admins.php">Atrás</a></button>
</body>
</html>