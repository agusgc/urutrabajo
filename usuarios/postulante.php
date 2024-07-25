<?php
require_once("clase_usuarios.php");
require_once("../cargos/clase_cargos.php");
require_once("../admin/control_acceso.php");

$mis_usuarios=new usuarios();

if(isset($_GET['registro'])){
	extract($_GET);
	$este_usuario=$mis_usuarios -> obtener_usuario($registro);
	$postulaciones=$mis_usuarios -> obtener_postulaciones($registro);
	extract($este_usuario);
}

$mis_cargos=new cargos();
$cargos_guardados=$mis_cargos -> listar();

if(isset($_POST['seleccionar'])){
	$exito=$mis_usuarios -> postular($_POST);
	
	if($exito){
		echo("<script>alert('Guardado con éxito')</script>");
		 header("Location:listar_usuarios.php");
	}
	else{
		echo("<script>alert('No se pudo guardar')</script>");
	}
}

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>Información del usuario</title>
</head>
<body>
	<h1 class="titulo">Información del usuario</h1>
	<div class="info-usuario">
		<h3>Personal</h3>
		<p><?php echo($nombre." ".$apellido) ?></p>
		<p><?php echo("Cédula: ".$cedula) ?></p>
		<p><?php echo("Fecha de Nacimiento: ".date("d/m/Y", strtotime($nacimiento))) ?></p>
		<p><?php echo("Edad: ".(date("y")-date("y",strtotime($nacimiento)))) ?></p>
		<p><?php echo("Dirección: ".$direccion) ?></p>
		<p><?php echo("Correo: ".$correo) ?></p>
		<p><?php echo("Contraseña: ".$password) ?></p>
		<p><?php echo("Último ingreso: ".date("d/m/Y", strtotime($ingreso))) ?></p>
		<hr>
		<h3>Educación y Trabajo</h3>
		<p><?php echo("Nivel educativo: ".$educacion) ?></p>
		<p><?php echo("Área técnica: ".$area_tecnica) ?></p>
		<p><?php echo("Área terciaria: ".$area_terciaria) ?></p>
		<p><?php echo("Cursos extracurriculares: ") ?></p>
		<p><?php echo(" - ".$cursos) ?></p>
		<p><?php echo("Experiencia laboral: ") ?></p>
		<p><?php echo(" - ".$experiencia) ?></p>
		<hr>
		<h3>Cargos</h3>
		<p><?php echo("Postulaciones: ") ?></p>
		<?php
			foreach ($postulaciones as $value) {
				if($value['tipo']=='Postulación'){
					foreach ($cargos_guardados as $cargo) {
						if($cargo['cod_cargo']==$value['cargo']){
							echo("<p> - ".$cargo['cargo']."</p>");
						}
					}
				}
			}
		?>
		<p><?php echo("Pre-selecciones: ") ?></p>
		<?php
			foreach ($postulaciones as $value) {
				if($value['tipo']=='Pre-seleccion'){
					foreach ($cargos_guardados as $cargo) {
						if($cargo['cod_cargo']==$value['cargo']){
							echo("<p> - ".$cargo['cargo']."</p>");
						}
					}
				}
			}
		?>
		<p><?php echo("Selecciones: ") ?></p>
		<?php
			foreach ($postulaciones as $value) {
				if($value['tipo']=='Seleccion'){
					foreach ($cargos_guardados as $cargo) {
						if($cargo['cod_cargo']==$value['cargo']){
							echo("<p> - ".$cargo['cargo']."</p>");
						}
					}
				}
			}
		?>
		<p><?php echo("<a href='curriculum/$curriculum' download>Curriculum</a>") ?></p>
	
		<button class="btn" id="btn-preseleccionar">Pre-seleccionar</button>
		<button class="btn" id="btn-seleccionar">Seleccionar</button>
		
	<form class="elegir-cargo" method="post" action="postulante.php" id="form-preseleccion">
		<h4>Pre-selección</h4>
		<h2>Selecciona el cargo</h2>
		<div class="lista-cargos">
			<?php
				foreach ($cargos_guardados as $value) {
					echo(
						"<p>
							<input required type='radio' name='cargo' class='input-cargo' value='".$value['cod_cargo']."'>
							<label>".$value['cargo']."</label>
						</p>");}
			?>
			<input type="hidden" name="usuario" id="usuario" value="<?php echo($cedula) ?>">
			<input type="hidden" name="fecha" id="fecha" value="<?php echo(date("y-m-d")) ?>">
			<input type="hidden" name="tipo" id="tipo" value="Pre-seleccion">
		</div>
		<input type="submit" name="seleccionar" id="seleccionar" value="Seleccionar" class="btn">
	</form>
	
	<form class="elegir-cargo" method="post" action="postulante.php" id="form-seleccion">
		<h4>Selección</h4>
		<h2>Selecciona el cargo</h2>
		<div class="lista-cargos">
			<?php
				foreach ($cargos_guardados as $value) {
					echo(
						"<p>
							<input required type='radio' name='cargo' class='input-cargo' value='".$value['cod_cargo']."'>
							<label>".$value['cargo']."</label>
						</p>");}
			?>
			<input type="hidden" name="usuario" id="usuario" value="<?php echo($cedula) ?>">
			<input type="hidden" name="fecha" id="fecha" value="<?php echo(date("y-m-d")) ?>">
			<input type="hidden" name="tipo" id="tipo" value="Seleccion">
		</div>
		<input type="submit" name="seleccionar" id="seleccionar" value="Seleccionar" class="btn">
	</form>
	</div>
	<button class="atras"><a href="listar_usuarios.php">Atrás</a></button>
	
	
	<script>
		let btn_preseleccionar = document.querySelector('#btn-preseleccionar');
		let btn_seleccionar = document.querySelector('#btn-seleccionar');
		let form_preseleccion = document.querySelector('#form-preseleccion');
		let form_seleccion = document.querySelector('#form-seleccion');
		let muestra_pre = false;
		let muestra_sel = false;

		btn_preseleccionar.addEventListener('click', ()=>{
			if (!muestra_pre) {
				form_preseleccion.style.display = 'block';
				muestra_pre=true;
			}
			else{
				form_preseleccion.style.display = 'none';
				muestra_pre=false;
			}
		})
		
		btn_seleccionar.addEventListener('click', ()=>{
			if (!muestra_sel) {
				form_seleccion.style.display = 'block';
				muestra_sel=true;
			}
			else{
				form_seleccion.style.display = 'none';
				muestra_sel=false;
			}
		})
		

	</script>
</body>
</html>