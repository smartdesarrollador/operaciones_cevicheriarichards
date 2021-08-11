<?php
class AccesoBD{
	public static function ConexionBD($con){
		try{
			$cn = @mysqli_connect($con["servidor"], $con["usuario"], 
						   $con["password"], $con["basedatos"]);
			if(mysqli_connect_errno()){
				throw new Exception("No se pudo conectar al Servidor " .mysqli_connect_error($cn) );
			}
			return $cn;
		}catch(Exception $e){
			$mensaje = "Fecha: ".date("Y-m-d H:i:s")."\n".
								"Archivo: ".$e->getFile()."\n".
								"Linea: ".$e->getLine()."\n".
								"Mensaje: ".$e->getMessage()."\n\n";
			error_log($mensaje,3,"log/proyecto.log");
			throw $e;
		}
	}

	public static function Consultar($cn,$sql){
		try{
			$rs = mysqli_query($cn, $sql);
			if(mysqli_errno($cn)) throw new Exception("Error en la consulta ". mysqli_error($cn));
			$lista = array();
			while($campo = mysqli_fetch_array($rs)){
				$lista[] = $campo;
			}
			return $lista;
		}catch(Exception $e){
			$mensaje = "Fecha: ".date("Y-m-d H:i:s")."\n".
								"Archivo: ".$e->getFile()."\n".
								"Linea: ".$e->getLine()."\n".
								"Mensaje: ".$e->getMessage()."\n\n";
			error_log($mensaje,3,"log/proyecto.log");
			throw $e;
		}
	}

	public static function Insertar($cn,$sql){



            mysqli_query($cn, $sql) ;
            $affectedRows = mysqli_affected_rows($cn);
     /*       $id = mysqli_insert_id($cn);*/
            return $affectedRows;


	}
	public static function InsertAndGetLastId($cn,$sql){



            mysqli_query($cn, $sql) ;
            $id = mysqli_insert_id($cn);
            return $id;


	}

	public static function OtroSQL($cn,$sql){
			mysqli_query($cn, $sql);
			$affectedRows = mysqli_affected_rows($cn);
			return $affectedRows;
	}	
}
?>