<?php
require_once("clase_cargos.php");
require_once("../admin/control_acceso.php");

$mis_cargos=new cargos();
$cargos_guardados=$mis_cargos -> listar();

if(isset($_GET['eliminar'])){
	extract($_GET);
	
	if($eliminar=="si"){
		echo("<script>var confirmar=confirm('¿Desea eliminar el cargo?');
			if(confirmar === true){
				document.location.href='listar_cargos.php?eliminado=".$registro."'}
			else{document.location.href='listar_cargos.php';}
		</script>");
	}
}

if(isset($_GET['eliminado'])){
	extract($_GET);
	$exito=$mis_cargos -> eliminar($eliminado);
	
	if($exito){
		echo("<script>alert('Cargo eliminado')</script>");
	}
	else{
		echo("<script>alert('No se pudo eliminar el cargo')</script>");
	}
	echo("<script>document.location.href='listar_cargos.php'</script>");
}

if(isset($_GET['editar'])){
	extract($_GET);
	
	if($editar=="si"){
		header("Location: editar_cargos.php?registro=$registro");
	}
}

if(isset($_GET['editado'])){
	extract($_GET);
	$exito=$mis_cargos -> editar($registro);
	
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
    <title>Lista de cargos</title>
</head>
<body>
	<h1 class="titulo">Lista de cargos</h1>
	<?php
		$mis_cargos -> mostrar_matriz($cargos_guardados);
	?>
	<button class="atras"><a href="gestion_cargos.php">Atrás</a></button>
</body>
</html>