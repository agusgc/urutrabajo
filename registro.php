<?php
require_once("usuarios/clase_usuarios.php");

$mis_usuarios=new usuarios();
$usuarios_guardados=$mis_usuarios -> listar();

if(isset($_POST['enviar'])){
    $mis_usuarios -> cedula_existe($usuarios_guardados, $_POST['cedula']);
    
	$exito=$mis_usuarios -> registrar($_POST);
	
	if($exito){
		echo("<script>alert('Registrado con éxito')</script>");
		 header("Location:index.php?usuario=".$_POST['cedula']);
	}
	else{
		echo("<script>alert('No se pudo registrar')</script>");
	}
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
    <title>Registrarse</title>
</head>
<body>
    <main>
        <form method="post" action="registro.php" enctype="multipart/form-data">
            <h2>Ingresa tus datos</h2>
			<img src="usuarios/foto-perfil/perfil.jpg" class="foto-perfil">
			<div class="div-foto">
                <input type="file" accept="image/*" name="foto" id="foto">
            </div>
            <div>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>
            </div>
            <div>
                <input type="text" name="apellido" id="apellido" placeholder="Apellido" required>
            </div>
            <div>
                <input type="number" name="cedula" id="cedula" placeholder="Cédula" required>
            </div>
            <div>
                <label for="nacimiento">Fecha de nacimiento</label>
                <input type="date" name="nacimiento" id="nacimiento" required>
            </div>
            <div>
                <input type="email" name="correo" id="correo" placeholder="Correo" required>
            </div>
            <div>
                <input type="password" name="password" id="password" placeholder="Contraseña" required>
            </div>
            <div>
                <input type="text" name="direccion" id="direccion" placeholder="Dirección">
            </div>
            <div>
                <label for="educacion">Máximo nivel educativo alcanzado</label>
                <select name="educacion" id="educacion">
                    <option value="Primaria">Primaria</option>
                    <option value="Media básica">Media básica</option>
                    <option value="Media superior">Media superior</option>
                    <option value="Universitaria">Universitaria</option>
                </select>
            </div>
			<div>
                <label for="tecnica">Área técnica</label>
                <select name="tecnica" id="tecnica">
                    <option value="Ninguna">Ninguna</option>
                    <option value="Ventas">Ventas</option>
                    <option value="Administración">Administración</option>
                    <option value="Contabilidad">Contabilidad</option>
					<option value="Informatica">Informática</option>
					<option value="Diseno">Diseño</option>
                </select>
            </div>
			<div>
                <label for="terciaria">Área terciaria</label>
                <input type="text" name="terciaria" id="terciaria">
            </div>
            <div>
                <label>Cursos extracurriculares</label>
				<textarea name="cursos" id="curso"></textarea>
            </div>
            <div>
                <label for="experiencia">Experiencia laboral</label>
				<textarea name="experiencia" id="experiencia"></textarea>
            </div>
            <div class="div-curriculum">
                <input type="file" accept=".pdf, .docx, .doc" name="curriculum" id="curriculum">
            </div>
			<input type="hidden" name="ingreso" id="ingreso" value="<?php echo(date("y-m-d")) ?>">
            <input type="submit" value="Ingresar" id="enviar" name="enviar">
        </form>
        <div class="derecha">
            <h1>URUTRABAJO</h1>
            <p>Regístrate para encontrar tu proximo empleo</p>
            <img src="img/registro.jpg">
            <p>¿Ya tienes cuenta?</p>
            <button class="login-btn"><a href="login.php">Iniciar sesión</a></button>
        </div>
    </main>

</body>
</html>