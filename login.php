<?php
session_start();

require_once("usuarios/clase_usuarios.php");
	
if(isset($_POST['ingresar'])){
	extract($_POST);
	$mis_usuarios=new usuarios();
    $este_usuario=$mis_usuarios -> obtener_usuario($cedula);
	
	$mis_usuarios -> actualizar_ingreso($cedula);

    if(is_array($este_usuario)> 0){
		if($este_usuario['password']==$password){
			$_SESSION['autentificado']='autentificado';
            header("Location:index.php?usuario=".$cedula);
        }
        else{
            echo("<script>alert('Contraseña incorrecta')</script>");
        }
    }
    else{
        echo("<script>alert('Usuario incorrecto')</script>");
    }

}

if(isset($_GET['salir'])){
	unset($_SESSION['admin']);
	session_destroy();
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
    <title>Iniciar sesión</title>
</head>
<body>
    <form method="post" action="login.php" class="login"> 
        <h2>Iniciar sesión</h2>   
        <div>
            <input type="text" name="cedula" id="cedula" placeholder="Cédula" required>
        </div>
        <div>
            <input type="password" name="password" id="password" placeholder="Contraseña" required>
        </div>
        <input type="submit" value="Ingresar" id="ingresar" name="ingresar">
        <p>¿No tienes cuenta?</p>
        <button class="registrarme"><a href="registro.php">Registrarme</a></button>
    </form>


</body>
</html>