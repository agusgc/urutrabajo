<?php
session_start();
require_once("cargos/clase_cargos.php");
require_once("usuarios/clase_usuarios.php");

$mis_cargos=new cargos();
$mis_usuarios=new usuarios();
$cargos_guardados=$mis_cargos -> listar();


if(!isset($_SESSION['autentificado'])){
	$texto_btn = "Iniciar sesión";
	$link_btn = "login.php";
	$sesion = false;
	$usuario = "";
}
else{
	extract($_GET);
	$texto_btn = "Mi cuenta";
	$link_btn = "perfil.php?usuario=$usuario";
	$sesion = true;
}

//Buscador
$busqueda = "";
if(isset($_POST['busqueda'])){
	$cargos_guardados=$mis_cargos -> buscar($_POST['busqueda']);
	$busqueda = $_POST['busqueda'];
}

//Postularse
if(isset($_POST['postularse'])){
	$exito=$mis_usuarios -> postular($_POST);
	
	if($exito){
		echo("<script>alert('Guardado con éxito')</script>");
	}
	else{
		echo("<script>alert('No se pudo guardar')</script>");
	}
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	<link rel="icon" type="image/x-icon" href="img/urutrabajo.svg">
    <title>URUTRABAJO</title>
</head>
<body>
	<header class="header-inicio">
		<div class="top">
			<img src="img/urutrabajo.svg" class="favicon">
			<h1>URUTRABAJO</h1>
    		<a href="<?php echo($link_btn) ?>" class="btn btn-login"><?php echo($texto_btn) ?><img src="img/user.svg" class="icono"></a>
		</div>
		<h2>Descubre las oferta laborales de todo el país</h2>
		
		<form action="index.php?usuario=<?php extract($_GET); echo($usuario); ?>#lista-cargos" method="post" class="div-buscador" id="buscador">
			<div><h3>Buscar</h3></div>
			<input type="search" name="busqueda" placeholder="Puesto..." id="busqueda" class="buscador" value="<?php echo($busqueda) ?>">
			<div><h3 class="lupa" id="lupa"><img src="img/lupa.svg" class="icono"></h3></div>
		</form>
	</header>
	<main>
		<div class="lista-cagros" id="lista-cargos">
			<?php
				$mis_cargos -> mostrar_cargos($cargos_guardados, $sesion);
			?>
		</div>
	</main>
	
	<script>
		let lupa = document.getElementById("lupa");
		let formulario = document.getElementById("buscador");
		lupa.addEventListener('click',()=>{
			formulario.submit()
		})
	</script>
</body>
</html>