<?php
require_once("clase_admins.php");

require_once("control_acceso.php");

$mis_admins=new admins();
$admins_guardados=$mis_admins -> listar();

if(isset($_GET['eliminar'])){
	extract($_GET);
	
	if($eliminar=="si"){
		echo("<script>var confirmar=confirm('¿Desea eliminar el usuario ".$registro."?');
			if(confirmar === true){
				document.location.href='listar_admins.php?eliminado=".$registro."'}
			else{document.location.href='listar_admins.php';}
		</script>");
	}
}

if(isset($_GET['eliminado'])){
	extract($_GET);
	$exito=$mis_admins -> eliminar($eliminado);
	
	if($exito){
		echo("<script>alert('Usuario eliminado')</script>");
	}
	else{
		echo("<script>alert('No se pudo eliminar el usuario')</script>");
	}
	echo("<script>document.location.href='listar_admins.php'</script>");
}

if(isset($_GET['editar'])){
	extract($_GET);
	
	if($editar=="si"){
		header("Location: editar_admins.php?registro=$registro");
	}
}

if(isset($_GET['editado'])){
	extract($_GET);
	$exito=$mis_admins -> editar($registro);
	
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
    <title>Lista de administradores</title>
</head>
<body>
	<h1 class="titulo">Lista de administradores</h1>
	<?php
		$mis_admins -> mostrar_matriz($admins_guardados);
	?>
	<button class="atras"><a href="gestion_admins.php">Atrás</a></button>
</body>
</html>