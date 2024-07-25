<?php
session_start();

require_once("clase_admins.php");
	
if(isset($_POST['ingresar'])){
	extract($_POST);
	$mis_admins=new admins();
    $este_admin=$mis_admins -> obtener_admin($usuario);

    if(is_array($este_admin)> 0){
		if($este_admin['password']==$password){
			$_SESSION['admin']='admin';
            header("Location:admin.php");
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
	unset($_SESSION['autentificado']);
	session_destroy();
}

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../formularios.css">
	<link rel="icon" type="image/x-icon" href="../img/urutrabajo.svg">
    <title>Administración</title>
</head>

<body>
	<form method="post" action="index.php" class="login"> 
        <h2>Iniciar sesión</h2>   
        <div>
            <input type="text" name="usuario" id="usuario" placeholder="Usuario" required>
        </div>
        <div>
            <input type="password" name="password" id="password" placeholder="Contraseña" required>
        </div>
        <input type="submit" value="Ingresar" id="ingresar" name="ingresar">
    </form>
</body>
</html>