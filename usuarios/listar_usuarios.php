<?php
require_once("clase_usuarios.php");
require_once("../admin/control_acceso.php");

$mis_usuarios=new usuarios();
$usuarios_guardados=$mis_usuarios -> listar();

if(isset($_GET['eliminar'])){
	extract($_GET);
	
	if($eliminar=="si"){
		echo("<script>var confirmar=confirm('¿Desea eliminar el usuario ".$registro."?');
			if(confirmar === true){
				document.location.href='listar_usuarios.php?eliminado=".$registro."&foto=".$foto."&cv=".$cv."'}
			else{document.location.href='listar_usuarios.php';}
		</script>");
	}
}

if(isset($_GET['eliminado'])){
	extract($_GET);
	$exito=$mis_usuarios -> eliminar($eliminado, $foto, $cv);
	
	if($exito){
		echo("<script>alert('Usuario eliminado')</script>");
	}
	else{
		echo("<script>alert('No se pudo eliminar el usuario')</script>");
	}
	echo("<script>document.location.href='listar_usuarios.php'</script>");
}

//Filtro
$busqueda = "";
if(isset($_POST['busqueda'])){
	extract($_POST);
	//print_r($mis_usuarios -> filtrar($columna, $busqueda));
	$usuarios_guardados=array($mis_usuarios -> filtrar($columna, $busqueda));
}
if(isset($_GET['todos'])){
	$usuarios_guardados=$mis_usuarios -> listar();
}

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>Lista de usuarios</title>
</head>
<body>
	<h1 class="titulo">Lista de usuarios</h1>
	<form method="post" action="listar_usuarios.php" class="filtro" id="buscador">
		<div>
			<label>Buscar por: </label>
			<select name="columna" id="columna">
				<option value="cedula">Cédula</option>
				<option value="direccion">Dirección</option>
				<option value="educacion">Educación</option>
				<option value="area_tecnica">Área tecnica</option>
			</select>
		</div>
		<div>
			<input type="search" name="busqueda" placeholder="..." id="busqueda" class="buscador" value="<?php echo($busqueda) ?>">
			<h3 class="lupa" id="lupa"><img src="../img/lupa.svg" class="icono"></h3>
			<h3 class="todos" id="todos"><a href="?todos=todos">Ver todos</a></h3>
		</div>
	</form>
	
	
	<?php
		if($usuarios_guardados[0]==""){
			echo("<h2>No se encontraron usuarios</h2>");
		}
		else{
			$mis_usuarios -> mostrar_matriz($usuarios_guardados);
		}
	?>
	<button class="atras"><a href="gestion_usuarios.php">Atrás</a></button>
	
	<script>
		let lupa = document.getElementById("lupa");
		let formulario = document.getElementById("buscador");
		lupa.addEventListener('click',()=>{
			formulario.submit()
		})
	</script>
</body>
</html>