<?php
  
  @session_start();

  require("db.php");
  require("sesiones.php");
  
  function caracteres($texto){
	
	$texto = str_replace('ª', 'a', $texto);
	$texto = str_replace('º', 'o', $texto);
	
	$texto = str_replace('á', '&aacute;', $texto);
	$texto = str_replace('é', '&eacute;', $texto);
	$texto = str_replace('í', '&iacute;', $texto);
	$texto = str_replace('ó', '&oacute;', $texto);
	$texto = str_replace('ú', '&uacute;', $texto);
	
	return $texto;
  }
  
  switch ($_REQUEST['accion']) {
      case 'cargar-sesiones':
  
      $fd = $_REQUEST['fecha_desde'];
      $fh = $_REQUEST['fecha_hasta'];
      
      $sesiones = sesiones::get_sesiones($fd, $fh);
      
      $len = count($sesiones);
      $msg = "{ events : [";
      for($i=0; $i < $len; $i += 1){
        $sesion = $sesiones[$i];
        $inicio = str_replace("-", "/", $sesion->fecha).' '.$sesion->hora_inicio;
        $fin = str_replace("-", "/", $sesion->fecha).' '.$sesion->hora_fin;
        $paciente = caracteres($sesion->paciente);
		$tratamiento = caracteres($sesion->tratamiento);
		//$consultorio = $sesion->consultorio;
		//$quesesion = $sesion->sesiones;
        
        //$linea = '{"id":'. $i .', "start": new Date("'.$inicio.'"), "end": new Date("'.$fin.'"), "title":"'. $paciente .' - '. $tratamiento .'<br>'. $consultorio . ' ' . $quesesion .'"}';
		$linea = '{"id":'. $i .', "start": new Date("'.$inicio.'"), "end": new Date("'.$fin.'"), "title":"'. $paciente .' - '. $tratamiento .'"}';
        
        
        if($i < $len -1){
          $linea .= ', ';
        }
        $msg .= $linea;
      }
      $msg .= "]}";
      break;
      
    case 'login':
  
      $usr = mysql_escape_string($_REQUEST["usuario"]);
      $pw = md5(mysql_escape_string($_REQUEST["clave"]));
      
      $db = new db();
      
      $sql = "select * from usuarios where usuario = '$usr' and clave = '$pw'";
      $consulta = $db->sqlSelect($sql);
      
      if($db->num_rows($consulta ) == 1){

        $row = $db->fetch_array($consulta );
      
        $_SESSION['usuario'] = $usr;
        $_SESSION['nombre'] = $row["nombre"];
        $_SESSION['authenticated'] = "yes";
        
        $msg = "true";
        
       }
       else{
        
          $_SESSION['authenticated'] = "no";
          $msg = "false";

       }
       break;
  }
  
  echo $msg;

?>