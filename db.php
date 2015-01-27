<?php

class db
{
  public $host;
  public $database;
  public $user;
  public $password;
  public $conexion;
  
  public function db() {
    
    $this->host = "youHost";
    $this->database = "youDB";
    $this->user = "youUsername";
    $this->password = "youPassword";
    
    
    if (!($this->conexion=mysql_connect($this->host,$this->user,$this->password)))
    {
      //echo "Error conectando al servidor, ".mysql_error();
      echo "Error conectando al servidor";
      exit();
    }
    
    if (!mysql_select_db($this->database,$this->conexion))
    {
      //echo "Error seleccionando base de datos, ".mysql_error();
      echo "Error seleccionando base de datos";
      exit();
    }
    
    return $this->conexion;
    
     }
    public function sqlSelect($str) {
      $resultado = mysql_query($str,$this->conexion);
    if(!$resultado){
      echo mysql_error();
      exit();
    }
    return $resultado;
    }
   
  public function sqlNoQuery($str) {
      mysql_query($str,$this->conexion);  
    }
  public function fetch_array($consulta){   
    return mysql_fetch_array($consulta);  
  }  
  public function num_rows($consulta){   
    return mysql_num_rows($consulta);  
  }  
}

?>