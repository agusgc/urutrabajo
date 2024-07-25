<?php
require_once("clase_usuarios.php");
require_once("../admin/control_acceso.php");

$mis_usuarios=new usuarios();

if(isset($_GET['cargo'])){
	extract($_GET);
	$postulados=$mis_usuarios -> listar_postulaciones($cargo);
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>Lista de postulados</title>
</head>
<body>
	<h1 class="titulo">Lista de postulados</h1>
	<?php
		$mis_usuarios -> mostrar_postulados($postulados);
	?>
	<button class="atras"><a href="../cargos/listar_cargos.php">Atrás</a></button>
</body>
</html>