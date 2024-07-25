<?php
session_start();
require_once("../cargos/clase_cargos.php");
require_once("../usuarios/clase_usuarios.php");

$mis_cargos=new cargos();
$mis_usuarios=new usuarios();

extract($_GET);
$postulaciones=$mis_usuarios -> obtener_postulaciones($usuario);
$cargos_guardados=$mis_cargos -> listar();

if(!isset($_SESSION['autentificado'])){
	$sesion = false;
}
else{
	$sesion = true;
}

if(isset($_GET['eliminar'])){
	extract($_GET);
	
	if($eliminar=="si"){
		echo("<script>var confirmar=confirm('¿Desea eliminar la postulación?');
			if(confirmar === true){
				document.location.href='mis_postulaciones.php?usuario=".$usuario."&eliminado=".$post."'}
			else{document.location.href='mis_postulaciones.php?usuario=".$usuario."';}
		</script>");
	}
}

if(isset($_GET['eliminado'])){
	extract($_GET);
	$exito=$mis_usuarios -> eliminar_postulacion($eliminado);
	
	if($exito){
		echo("<script>alert('Postulación eliminada')</script>");
	}
	else{
		echo("<script>alert('No se pudo eliminar la postulación')</script>");
	}
	echo("<script>document.location.href='mis_postulaciones.php?usuario=".$usuario."'</script>");
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
	<h1 class="titulo">Mis postulaciones</h1>	
	<div class="lista-cagros" id="lista-cargos">
		<?php
			foreach ($postulaciones as $value) {
				if($value['tipo']=='Postulación'){
					foreach ($cargos_guardados as $cargo) {
						if($cargo['cod_cargo']==$value['cargo']){
							echo("
				<div class='cargo'>
					<h3><span><img src='../img/work.svg' class='icono'></span>
					<span>".$cargo['cargo']."</span></h3>
					<div class='btns-cargo'>
						<a href='../cargos/cargo.php?usuario=$usuario&cargo=".$cargo['cod_cargo']."' class='btn ver-mas'>Ver más</a>
						<a href='?usuario=$usuario&eliminar=si&post=".$value['id']."' class='btn borrar'>Borrar postulación</a>
					</div>
				</div>
		");}}}}?>
	</div>
	<a href='../index.php?usuario=<?php echo($usuario) ?>' class='btn inicio'>Inicio</a>
</body>
</html>