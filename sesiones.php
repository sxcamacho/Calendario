<?php

class sesiones
{
	public $id;
	public $fecha;
	public $observaciones;
	public $sesiones;
	public $tratamiento;
	public $paciente;
	public $hora_inicio;
	public $hora_fin;
	public $id_consultorio;
	public $consultorio;
	
	public static function get_estructura($row)
	{
		$objeto = new sesiones();
		
		$objeto->id = $row["id"];
		$objeto->fecha = $row["fecha"];
		$objeto->observaciones = $row["observaciones"];
		$objeto->sesiones = $row["sesiones"];
		$objeto->tratamiento = $row["tratamiento"];
		$objeto->paciente = $row["paciente"];
		$objeto->hora_inicio = $row["hora_inicio"];
		$objeto->hora_fin = $row["hora_fin"];
		$objeto->id_consultorio = $row["id_consultorio"];
		$objeto->consultorio = $row["consultorio"];
		
		return $objeto;
	}
	
	public static function get_sesiones($fecha_desde, $fecha_hasta)
	{
			
		$str = "SELECT s.id, s.fecha, s.observaciones, ";
		$str .= "CONCAT('Sesión ', CAST(ct.sesiones_usadas AS CHAR(2)), '/', CAST(ct.sesiones AS CHAR(2))) AS sesiones, t.nombre AS tratamiento, CONCAT(p.Nombre, ' ', p.Apellido) AS paciente, ";
		$str .= "tu.hora_inicio, tu.hora_fin, tu.id_consultorio, c.nombre AS consultorio ";
		$str .= "FROM sesiones s ";
		$str .= "LEFT JOIN clientes_tratamientos ct ON s.id_cliente_tratamiento = ct.id ";
		$str .= "LEFT JOIN tratamientos t ON t.id = ct.id_tratamientos ";
		$str .= "LEFT JOIN clientes p ON p.Id = ct.id_clientes ";
		$str .= "LEFT JOIN turnos tu ON tu.id = s.id_turno ";
		$str .= "LEFT JOIN consultorios c ON c.id = tu.id_consultorio ";
		$str .= "WHERE s.eliminado = 0 AND s.fecha BETWEEN '$fecha_desde' AND '$fecha_hasta'";
		
		$db = new db();
		$consulta = $db->sqlSelect($str);
		
		if($db->num_rows($consulta)>0){
			$indice = 0;
			while($resultado = $db->fetch_array($consulta)){
				$lista[$indice] = sesiones::get_estructura($resultado);
				$indice ++;
			}
			return $lista;
		}
		else{
			return null;
		}
	}
	
}

?>