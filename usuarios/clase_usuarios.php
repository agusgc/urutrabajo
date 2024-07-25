<?php 

class usuarios{
    const SERVIDOR = "localhost";
	const USUARIO = "root";
	const PASSWORD = "root";
	const BASE = "urutrabajo";
	
	//Conexión
	private function conectar(){
		$conexion = mysqli_connect(self::SERVIDOR, self::USUARIO, self::PASSWORD, self::BASE)or die("Error al tratar de establecer la conexión");
		return $conexion;
	}

    //Registrar
    public function registrar($datos){
		$conexion=self::conectar();
		extract($datos);

		//Curriculum
		$archivo = $_FILES['curriculum'];
		$nombre_archivo = $cedula."-".$archivo['name'];
		
		$imagen = $_FILES['foto'];
		//Foto de perfil
		if($imagen['name']==""){
			$nombre_foto = "perfil.jpg";
		}
		else{
			$nombre_foto = $cedula."-".$imagen['name'];
		}

		$sql="INSERT INTO usuarios(foto, nombre, apellido, cedula, nacimiento, correo, password, direccion, educacion, area_tecnica, area_terciaria, cursos, experiencia, curriculum, ingreso) 
		VALUES ('$nombre_foto', '$nombre', '$apellido', '$cedula', '$nacimiento', '$correo', '$password', '$direccion', '$educacion', '$tecnica', '$terciaria', '$cursos', '$experiencia', '$nombre_archivo', '$ingreso')";

		//Guardar archivo
		$destino = "usuarios/curriculums/" . basename($nombre_archivo);

		if (!move_uploaded_file($archivo['tmp_name'], $destino)) {
			echo "<script>alert(Error al mover el archivo)<script>";
		}
		
		$destino_foto = "usuarios/foto-perfil/" . basename($nombre_foto);

		if (!move_uploaded_file($imagen['tmp_name'], $destino_foto)) {
			echo "<script>alert(Error al mover el archivo)<script>";
		}

		//Ejecutar sentencia
		$resultado=mysqli_query($conexion, $sql);
		
		if($resultado){
				$exito=true;
			}
			else{
				$exito=false;
			}

		//Cerrar la conexión
		mysqli_close($conexion);
		return($exito);
	}

	//No puede haber dos usuarios con la misma cédula
	public function cedula_existe($datos, $cedula){
		foreach ($datos as $value) {
			if ($cedula == $value['cedula']) {
				echo("<script>alert('Ya existe un usuario con la cédula: ".$cedula."')</script>");
			}
		}
	}

	//Listar
	public function listar(){
		$conexion=self::conectar();
		
		if($conexion){
			$sql="SELECT * FROM usuarios";
			$resultado=mysqli_query($conexion, $sql);
			
			if($resultado){
				$usuarios=array();
				
				while($fila=mysqli_fetch_assoc($resultado)){
					array_push($usuarios, $fila);
				}
			}
			mysqli_close($conexion);
		}
		return($usuarios);
	}

	//Obtener usuario
	public function obtener_usuario($usuario){
		$conexion=self::conectar();
		
		if($conexion){
			$sql="SELECT * FROM usuarios WHERE cedula='$usuario'";
			$resultado=mysqli_query($conexion, $sql);
			
			if($resultado){
				$usuario=array();
				$usuario=mysqli_fetch_assoc($resultado);
			}
			mysqli_close($conexion);
		}
		return($usuario);
	}
	
	//Editar usuario
	public function editar($datos){
		$conexion=self::conectar();
		extract($datos);
		
		//Curriculum
		$archivo = $_FILES['curriculum'];
		
		if($archivo['name']==""){
			$nombre_archivo = $mismo_archivo;
		}
		else{
			$nombre_archivo = $cedula."-".$archivo['name'];
			
			$destino = "usuarios/curriculums/" . basename($nombre_archivo);

			if (!move_uploaded_file($archivo['tmp_name'], $destino)) {
				echo "<script>alert(Error al mover el archivo)<script>";
			}
			unlink("usuarios/curriculums/".$mismo_archivo);
		}
		
		//Foto de perfil
		$imagen = $_FILES['foto'];
		
		if($imagen['name']==""){
			$nombre_foto = $misma_foto;
		}
		else{
			$nombre_foto = $cedula."-".$imagen['name'];
			
			$destino_foto = "usuarios/foto-perfil/" . basename($nombre_foto);

			if (!move_uploaded_file($imagen['tmp_name'], $destino_foto)) {
				echo "<script>alert(Error al mover el archivo)<script>";
			}
			unlink("usuarios/foto-perfil/".$misma_foto);
		}

		$sql="UPDATE usuarios SET foto='$nombre_foto', nombre='$nombre', apellido='$apellido', cedula='$cedula', nacimiento='$nacimiento', correo='$correo', password='$password', direccion='$direccion', educacion='$educacion', area_tecnica='$tecnica', area_terciaria='$terciaria', cursos='$cursos', experiencia='$experiencia', curriculum='$nombre_archivo' WHERE cedula='$cedula'";
		$resultado=mysqli_query($conexion, $sql);
		
		if($resultado){
				$exito=true;
			}
			else{
				$exito=false;
			}
		mysqli_close($conexion);
		return($exito);
	}
	
	//Eliminar
	public function eliminar($cedula, $foto_perfil, $curriculum_file){
		$conexion=self::conectar();
		
		if($foto_perfil!="perfil.jpg"){
			unlink("foto-perfil/".$foto_perfil);
		}
		if($curriculum_file!=$cedula."-"){
			unlink("curriculums/".$curriculum_file);
		}
		
		if($conexion){
			$sql="DELETE FROM usuarios WHERE cedula='$cedula'";
			$resultado=mysqli_query($conexion, $sql);
			
			if($resultado){
				$exito=true;
			}
			else{
				$exito=false;
			}
			mysqli_close($conexion);
		}
		return($exito);
	}
	
	//Actualizar ingreso
	public function actualizar_ingreso($cedula){
		$conexion=self::conectar();
		
		$hoy=date("y-m-d");

		$sql="UPDATE usuarios SET ingreso='$hoy' WHERE cedula='$cedula'";
		$resultado=mysqli_query($conexion, $sql);
		
		if($resultado){
				$exito=true;
			}
			else{
				$exito=false;
			}
		mysqli_close($conexion);
		return($exito);
	}
	
	//Mostrar lista
	public function mostrar_matriz($datos){
		echo("<table class='lista' cellspacing='0'>");
		echo("<tr class='encabezado'>
				<td>Cedula</td>
				<td>Correo</td>
				<td>Ver más</td>
				<td>Eliminar</td>
			</tr>");
		
		foreach ($datos as $value) {
			echo("<tr>");
			$guardar_usuario=true;
			
			foreach ($value as $clave => $item){
				if($clave=="cedula"){
					echo("<td>".$item."</td>");
				}
				if($clave=="correo"){
					echo("<td>".$item."</td>");
				}
			
				if($guardar_usuario){
					$usuario=$value['cedula'];
					$foto=$value['foto'];
					$cv=$value['curriculum'];
					$guardar_usuario=false;
				}
			}
			echo("<td><a href='postulante.php?registro=".$usuario."'>Ampliar</a></td>
			
			<td><a href='?eliminar=si&registro=".$usuario."&foto=".$foto."&cv=".$cv."'><img src='../img/delete.png' class='icono'></a></td>");
			echo("</tr>");
        }
		echo("</table>");
	}
	
	//Postulación
	public function postular($datos){
		$conexion=self::conectar();
		extract($datos);

		$sql="INSERT INTO postulaciones(usuario, cargo, fecha, tipo) 
		VALUES ('$usuario', '$cargo', '$fecha', '$tipo')";

		//Ejecutar sentencia
		$resultado=mysqli_query($conexion, $sql);
		
		if($resultado){
				$exito=true;
			}
			else{
				$exito=false;
			}

		//Cerrar la conexión
		mysqli_close($conexion);
		return($exito);
	}
	
	//Obtener mis postulaciones
	public function obtener_postulaciones($cedula){
		$conexion=self::conectar();
		
		if($conexion){
			$sql="SELECT * FROM postulaciones WHERE usuario=$cedula";
			$resultado=mysqli_query($conexion, $sql);
			
			if($resultado){
				$usuarios=array();
				
				while($fila=mysqli_fetch_assoc($resultado)){
					array_push($usuarios, $fila);
				}
			}
			mysqli_close($conexion);
		}
		return($usuarios);
	}
	
	//Obtener postulaciones
	public function listar_postulaciones($cargo){
		$conexion=self::conectar();
		
		if($conexion){
			$sql="SELECT * FROM postulaciones WHERE cargo=$cargo";
			$resultado=mysqli_query($conexion, $sql);
			
			if($resultado){
				$usuarios=array();
				
				while($fila=mysqli_fetch_assoc($resultado)){
					array_push($usuarios, $fila);
				}
			}
			mysqli_close($conexion);
		}
		return($usuarios);
	}
	
	//Mostrar lista
	public function mostrar_postulados($datos){
		echo("<table class='lista' cellspacing='0'>");
		echo("<tr class='encabezado'>
				<td>Usuario</td>
				<td>Fecha</td>
				<td></td>
			</tr>");
		
		foreach ($datos as $value) {
			echo("<tr>");
			$guardar_usuario=true;
			
			foreach ($value as $clave => $item){
				if($clave=="usuario"){
					echo("<td>".$item."</td>");
				}
				if($clave=="fecha"){
					echo("<td>".date("d/m/Y", strtotime($item))."</td>");
				}
				if($clave=="tipo"){
					echo("<td>".$item."</td>");
				}
			}
			echo("</tr>");
        }
		echo("</table>");
	}
	
	//Eliminar postulación
	public function eliminar_postulacion($post){
		$conexion=self::conectar();
		
		if($conexion){
			$sql="DELETE FROM postulaciones WHERE id='$post'";
			$resultado=mysqli_query($conexion, $sql);
			
			if($resultado){
				$exito=true;
			}
			else{
				$exito=false;
			}
			mysqli_close($conexion);
		}
		return($exito);
	}
	
	//Filtro
	public function filtrar($columna, $busqueda){
		$conexion=self::conectar();
		
		if($conexion){
			$sql="SELECT * FROM usuarios WHERE $columna LIKE '$busqueda%'";
			$resultado=mysqli_query($conexion, $sql);
			
			if($resultado){
				$usuario=array();
				$usuario=mysqli_fetch_assoc($resultado);
			}
			mysqli_close($conexion);
		}
		return($usuario);
	}
	
	
}

?>