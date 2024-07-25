<?php 

class admins{
    const SERVIDOR = "localhost";
	const USUARIO = "root";
	const PASSWORD = "root";
	const BASE = "urutrabajo";
	
	//Conexión
	private function conectar(){
		$conexion = mysqli_connect(self::SERVIDOR, self::USUARIO, self::PASSWORD, self::BASE)or die("Error al tratar de establecer la conexión");
		return $conexion;
	}
	
	//Agregar
    public function agregar($datos){
		$conexion=self::conectar();
		extract($datos);

		$sql="INSERT INTO administradores(usuario, password) 
		VALUES ('$usuario', '$password')";

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
	
	public function usuario_existe($datos, $usuario){
		foreach ($datos as $value) {
			if ($usuario == $value['usuario']) {
				echo("<script>alert('Ya existe el usuario: ".$usuario."')</script>");
			}
		}
	}
	
	//Listar
	public function listar(){
		$conexion=self::conectar();
		
		if($conexion){
			$sql="SELECT * FROM administradores";
			$resultado=mysqli_query($conexion, $sql);
			
			if($resultado){
				$admins=array();
				
				while($fila=mysqli_fetch_assoc($resultado)){
					array_push($admins, $fila);
				}
			}
			mysqli_close($conexion);
		}
		return($admins);
	}

	//Obtener admin
	public function obtener_admin($admin){
		$conexion=self::conectar();
		
		if($conexion){
			$sql="SELECT * FROM administradores WHERE usuario='$admin'";
			$resultado=mysqli_query($conexion, $sql);
			
			if($resultado){
				$admin=array();
				$admin=mysqli_fetch_assoc($resultado);
			}
			mysqli_close($conexion);
		}
		return($admin);
	}

	//Eliminar
	public function eliminar($usuario){
		$conexion=self::conectar();
		
		if($conexion){
			$sql="DELETE FROM administradores WHERE usuario='$usuario'";
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
	
	//Editar
	public function editar($datos){
		$conexion=self::conectar();
		extract($datos);

		$sql="UPDATE administradores SET password='$password' WHERE usuario='$usuario'";
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
				<td>Usuario</td>
				<td>Contraseña</td>
				<td>Editar</td>
				<td>Eliminar</td>
			</tr>");
		
		foreach ($datos as $value) {
			echo("<tr>");

			$guardar_usuario=true;
			
			foreach ($value as $clave => $item){
				echo("<td>".$item."</td>");
			
				if($guardar_usuario){
					$usuario=$item;
					$guardar_usuario=false;
				}
			}
			echo("<td><a href='editar_admin.php?editar=si&registro=".$usuario."'><img src='../img/pencil.png' class='icono'></a></td>
			
			<td><a href='?eliminar=si&registro=".$usuario."'><img src='../img/delete.png' class='icono'></a></td>");
			echo("</tr>");
        }
		echo("</table>");
	}
}
?>