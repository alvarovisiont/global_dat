<?php

class Conexion 
{
	
	public function conectar()
	{
		$conn = new PDO('mysql:host='.'localhost'.'; dbname='.'global_dat', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		return $conn;
	}

	public function conectar1()
	{
		try
		{
			$conn = new PDO('mysql:host='.'localhost'.'; dbname='.'sis_clap', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));	
			return $conn;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage(); 	
		}

	}	

}



?>