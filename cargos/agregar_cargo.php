<?php
require_once("/clase_cargos.php");

require_once("../admin/control_acceso.php");

$mis_cargos=new cargos();
$cargos_guardados=$mis_cargos -> listar();

if(isset($_POST['enviar'])){    
	$exito=$mis_cargos -> agregar($_POST);
	
	if($exito){
		echo("<script>alert('Agregado con éxito')</script>");
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
    <title>Agregar cargo</title>
</head>
<body>
	<main>
		<form method="post" action="agregar_cargo.php" enctype="multipart/form-data" class="login">
			<h2>Agregar cargo</h2>
			<div>
				<input type="text" name="cargo" id="cargo" placeholder="Cargo" required>
			</div>
			<div>
				<label>Descripción</label>
				<textarea id="descripcion" name="descripcion"></textarea>
			</div>
			<input type="submit" value="Ingresar" id="enviar" name="enviar">
		</form>
	</main>
	<button class="atras"><a href="gestion_cargos.php">Atrás</a></button>
</body>
</html>