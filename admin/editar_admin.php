<?php
require_once("/clase_admins.php");

require_once("control_acceso.php");

$mis_admins=new admins();

if(isset($_GET['registro'])){
	extract($_GET);
	$este_admin=$mis_admins -> obtener_admin($registro);
	extract($este_admin);
}

if(isset($_POST['editar'])){
	$exito=$mis_admins -> editar($_POST);
	
	if($exito){
		echo("<script>alert('Usuario editado')</script>");
	}
	else{
		echo("<script>alert('No se pudo editar el usuario')</script>");
	}
	echo("<script>document.location.href='listar_admins.php'</script>");
}


?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
	<link rel="stylesheet" href="../formularios.css">
    <title>Editar administrador</title>
</head>
<body>
	<main>
		<form method="post" action="editar_admin.php" enctype="multipart/form-data" class="login">
			<h2>Editar administrador</h2>
			<div>
				<input type="text" name="usuario" id="usuario" placeholder="Usuario" required value="<?php echo($usuario); ?>" readonly>
			</div>
			<div>
				<input type="password" name="password" id="password" placeholder="Contraseña" required value="<?php echo($password); ?>">
			</div>
			<input type="submit" value="Editar" id="editar" name="editar">
		</form>
	</main>
	<button class="atras"><a href="listar_admins.php">Atrás</a></button>
</body>
</html>