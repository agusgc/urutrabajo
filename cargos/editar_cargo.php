<?php
require_once("/clase_cargos.php");

require_once("../admin/control_acceso.php");

$mis_cargos=new cargos();

if(isset($_GET['registro'])){
	extract($_GET);
	$este_cargo=$mis_cargos -> obtener_cargo($registro);
	extract($este_cargo);
}

if(isset($_POST['editar'])){
	$exito=$mis_cargos -> editar($_POST);
	
	if($exito){
		echo("<script>alert('Cargo editado')</script>");
	}
	else{
		echo("<script>alert('No se pudo editar el cargo')</script>");
	}
	echo("<script>document.location.href='listar_cargos.php'</script>");
}


?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
	<link rel="stylesheet" href="../formularios.css">
    <title>Editar cargo</title>
</head>
<body>
	<main>
		<form method="post" action="editar_cargo.php" enctype="multipart/form-data" class="login">
			<h2>Editar cargo</h2>
			<div>
				<input type="hidden" name="cod_cargo" id="cod_cargo" value="<?php echo($cod_cargo); ?>">
				<input type="text" name="cargo" id="cargo" placeholder="Cargo" required value="<?php echo(utf8_encode($cargo)); ?>">
			</div>
			<div>
				<label>Descripción</label>
				<textarea id="descripcion" name="descripcion"><?php echo(utf8_encode($descripcion)); ?></textarea>
			</div>
			<input type="submit" value="Editar" id="editar" name="editar">
		</form>
	</main>
	<button class="atras"><a href="listar_cargos.php">Atrás</a></button>
</body>
</html>