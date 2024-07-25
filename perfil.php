<?php
require_once("usuarios/clase_usuarios.php");

require_once("control_acceso.php");

$mis_usuarios=new usuarios();

if(isset($_GET['usuario'])){
	extract($_GET);
	$este_usuario=$mis_usuarios -> obtener_usuario($usuario);
	extract($este_usuario);
}

if(isset($_POST['enviar'])){
	$exito=$mis_usuarios -> editar($_POST);
	
	if($exito){
		echo("<script>alert('Información editada')</script>");
	}
	else{
		echo("<script>alert('No se pudo editar la informaciónS')</script>");
	}
	echo("<script>document.location.href='index.php?usuario=".$_POST['cedula']."'</script>");
}

if(isset($_GET['eliminar'])){
	extract($_GET);
	
	if($eliminar=="si"){
		echo("<script>var confirmar=confirm('¿Desea eliminar su cuenta?');
			if(confirmar === true){
				document.location.href='?eliminado=".$registro."&foto=".$foto."&cv=".$cv."'}
			else{document.location.href='listar_usuarios.php';}
		</script>");
	}
}

if(isset($_GET['eliminado'])){
	extract($_GET);
	$exito=$mis_usuarios -> eliminar($eliminado, $foto, $cv);
	
	if($exito){
		echo("<script>alert('Cuenta eliminada')</script>");
	}
	else{
		echo("<script>alert('No se pudo eliminar la cuenta')</script>");
	}
	echo("<script>document.location.href='login.php'</script>");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="formularios.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	<link rel="icon" type="image/x-icon" href="img/urutrabajo.svg">
    <title>Mi cuenta</title>
</head>
<body>
    <main>
        <form method="post" action="perfil.php" enctype="multipart/form-data">
			<h2>Mi cuenta</h2>
            <h2><?php echo($nombre." ".$apellido); ?></h2>
			<img src="usuarios/foto-perfil/<?php echo($foto); ?>" class="foto-perfil">
			<div class="div-foto">
                <input type="file" accept="image/*" name="foto" id="foto">
				<input type="hidden" name="misma_foto" id="misma_foto" value="<?php echo($foto); ?>">
            </div>
            <div>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" required value="<?php echo($nombre); ?>">
            </div>
            <div>
                <input type="text" name="apellido" id="apellido" placeholder="Apellido" required value="<?php echo($apellido); ?>">
            </div>
            <div>
                <input type="number" name="cedula" id="cedula" placeholder="Cédula" required readonly value="<?php echo($cedula); ?>">
            </div>
            <div>
                <label for="nacimiento">Fecha de nacimiento</label>
                <input type="date" name="nacimiento" id="nacimiento" required value="<?php echo($nacimiento); ?>">
            </div>
            <div>
                <input type="email" name="correo" id="correo" placeholder="Correo" required value="<?php echo($correo); ?>">
            </div>
            <div>
                <input type="password" name="password" id="password" placeholder="Contraseña" required value="<?php echo($password); ?>">
            </div>
            <div>
                <input type="text" name="direccion" id="direccion" placeholder="Dirección" value="<?php echo($direccion); ?>">
            </div>
            <div>
                <label for="educacion">Máximo nivel educativo alcanzado</label>
                <select name="educacion" id="educacion">
                    <option <?php if($educacion == "Primaria"){echo(" selected='selected'");}?> value="Primaria">Primaria</option>
                    <option <?php if($educacion == "Media básica"){echo(" selected='selected'");}?> value="Media básica">Media básica</option>
                    <option <?php if($educacion == "Media superior"){echo(" selected='selected'");}?> value="Media superior">Media superior</option>
                    <option <?php if($educacion == "Universitaria"){echo(" selected='selected'");}?> value="Universitaria">Universitaria</option>
                </select>
            </div>
			<div>
                <label for="tecnica">Área técnica</label>
                <select name="tecnica" id="tecnica">
                    <option <?php if($area_tecnica == "Ninguna"){echo(" selected='selected'");}?> value="Ninguna">Ninguna</option>
                    <option <?php if($area_tecnica == "Ventas"){echo(" selected='selected'");}?> value="Ventas">Ventas</option>
                    <option <?php if($area_tecnica == "Administración"){echo(" selected='selected'");}?> value="Administración">Administración</option>
                    <option <?php if($area_tecnica == "Contabilidad"){echo(" selected='selected'");}?> value="Contabilidad">Contabilidad</option>
					<option <?php if($area_tecnica == "Informática"){echo(" selected='selected'");}?> value="Informática">Informática</option>
					<option <?php if($area_tecnica == "Diseño"){echo(" selected='selected'");}?> value="Diseño">Diseño</option>
                </select>
            </div>
			<div>
                <label for="terciaria">Área terciaria</label>
                <input type="text" name="terciaria" id="terciaria" value="<?php echo($area_terciaria); ?>">
            </div>
            <div>
                <label>Cursos extracurriculares</label>
				<textarea name="cursos" id="curso"><?php echo($cursos); ?></textarea>
            </div>
            <div>
                <label for="experiencia">Experiencia laboral</label>
				<textarea name="experiencia" id="experiencia"><?php echo($experiencia); ?></textarea>
            </div>
            <div class="div-curriculum">
                <input type="file" accept=".pdf, .docx, .doc" name="curriculum" id="curriculum">
				<input type="hidden" name="mismo_archivo" id="mismo_archivo" value="<?php echo($curriculum); ?>">
            </div>
            <input type="submit" value="Guardar cambios" id="enviar" name="enviar">
        </form>
        <div class="derecha">
            <h1>URUTRABAJO</h1>
			<a href="index.php?usuario=<?php echo($cedula) ?>" class="link">Inicio</a>
			<a href="usuarios/mis_postulaciones.php?usuario=<?php echo($cedula) ?>" class="link">Mis postulaciones</a>
			<a href="login.php?salir=si" class="link cerrar-sesion">Cerrar sesión</a>
			<a href="<?php 
				echo("?eliminar=si&registro=".$usuario."&foto=".$foto."&cv=".$curriculum."");
			?>" class="link cerrar-sesion">Borrar cuenta</a>
        </div>
    </main>

</body>
</html>