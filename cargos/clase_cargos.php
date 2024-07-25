<?php 

class cargos{
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

		$sql="INSERT INTO cargos(cargo, descripcion) 
		VALUES ('$cargo', '$descripcion')";

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
	
	//Listar
	public function listar(){
		$conexion=self::conectar();
		
		if($conexion){
			$sql="SELECT * FROM cargos";
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
	
	//Obtener cargo
	public function obtener_cargo($cargo){
		$conexion=self::conectar();
		
		if($conexion){
			$sql="SELECT * FROM cargos WHERE cod_cargo='$cargo'";
			$resultado=mysqli_query($conexion, $sql);
			
			if($resultado){
				$cargo=array();
				$cargo=mysqli_fetch_assoc($resultado);
			}
			mysqli_close($conexion);
		}
		return($cargo);
	}
	
	//Editar
	public function editar($datos){
		$conexion=self::conectar();
		extract($datos);

		$sql="UPDATE cargos SET cargo='$cargo', descripcion='$descripcion' WHERE cod_cargo='$cod_cargo'";
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
	public function eliminar($cargo){
		$conexion=self::conectar();
		
		if($conexion){
			$sql="DELETE FROM cargos WHERE cod_cargo='$cargo'";
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
	
	//Mostrar lista
	public function mostrar_matriz($datos){
		echo("<table class='lista' cellspacing='0'>");
		echo("<tr class='encabezado'>
				<td>Código</td>
				<td>Cargo</td>
				<td>Postulantes</td>
				<td>Editar</td>
				<td>Eliminar</td>
			</tr>");
		
		foreach ($datos as $value) {
			$cod_cargo="";
			echo("<tr>");
			$guardar_usuario=true;
			
			foreach ($value as $clave => $item){
				if($clave=="cod_cargo"){
					echo("<td>".$item."</td>");
					$cod_cargo=$item;
				}
				if($clave=="cargo"){
					echo("<td>".$item."</td>");
				}
			
				if($guardar_usuario){
					$usuario=$item;
					$guardar_usuario=false;
				}
			}
			echo("<td><a href='../usuarios/listar_postulantes.php?cargo=".$cod_cargo."'>Ver postulantes</a></td>
			
			<td><a href='editar_cargo.php?editar=si&registro=".$usuario."'><img src='../img/pencil.png' class='icono'></a></td>
			
			<td><a href='?eliminar=si&registro=".$usuario."'><img src='../img/delete.png' class='icono'></a></td>");
			echo("</tr>");
        }
		echo("</table>");
	}

	//Mostrar cagros
	public function mostrar_cargos($datos, $sesion){
		$usuario = "";
		extract($_GET);
		foreach ($datos as $value) {
			echo("
					<div class='cargo'>
						<h3><span><img src='img/work.svg' class='icono'></span><span>".$value['cargo']."</span></h3>
						<pre>".$value['descripcion']."</pre>
						<a href='cargos/cargo.php?usuario=$usuario&cargo=".$value['cod_cargo']."' class='btn ver-mas'>Ver más</a>
				");
			if($sesion){
				echo("
					<form method='post' action='index.php?usuario=$usuario' class='div-postularse'>
					<input type='hidden' name='usuario' id='usuario' value='$usuario'>
					<input type='hidden' name='cargo' id='cargo' value='".$value['cod_cargo']."'>
					<input type='hidden' name='fecha' id='fecha' value='".date('y-m-d')."'>
					<input type='hidden' name='tipo' id='tipo' value='Postulación'>
					<input type='submit' name='postularse' id='postularse' value='Postularse' class='btn'>
					</form>
				");
			}
			
			echo("</div>");
		}
	}
	
	//Mostrar cargo
	public function mostrar_cargo($datos, $sesion){
		extract($_GET);
		echo("
			<div class='cargo un-cargo'>
				<h2><span><img src='../img/work.svg' class='icono'></span><span>".$datos['cargo']."</span></h2>
				<pre>".$datos['descripcion']."</pre>
				<a href='../index.php?usuario=$usuario' class='btn'>Volver</a>
			");
		if($sesion){
				echo("
					<form method='post' action='../index.php?usuario=$usuario' class='div-postularse'>
					<input type='hidden' name='usuario' id='usuario' value='$usuario'>
					<input type='hidden' name='cargo' id='cargo' value='".$datos['cod_cargo']."'>
					<input type='hidden' name='fecha' id='fecha' value='".date('y-m-d')."'>
					<input type='hidden' name='tipo' id='tipo' value='Postulación'>
					<input type='submit' name='postularse' id='postularse' value='Postularse' class='btn'>
					</form>
				");
			}
		else{
			echo("<a href='../registro.php' class='btn'>Registrarme</a>");
		}
		
		echo("</div>");

	}
	
	//Buscar
	public function buscar($busqueda){
		$conexion=self::conectar();
		
		if($conexion){
			$sql="SELECT * FROM cargos WHERE cargo LIKE '$busqueda%'";
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
	
	
}
?>