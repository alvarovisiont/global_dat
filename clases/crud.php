<?php
require_once "conexion/conexion.php";
class Crud
{
	public $from;
	public $where;
	public $campos;
	public $valores;
	public $sql;
	public $filas;
	public $total;	

	public function crear()
	{
		// Crea registros----------------

		$model = new Conexion();
		$db = $model->conectar();
		$sql = "INSERT INTO $this->from ($this->campos) VALUES ($this->valores)";
		/*echo $sql;
		exit();*/
		$res = $db->prepare($sql);
		$res->execute();
		$res->closeCursor();
		$this->from = null;
		$this->campos = null;
		$this->valores = null;
		$db = null;
		$model = null;
	}
	
	public function leer()
	{
		//Devuelve resultados de un query

		$this->filas = null;
		$model = new Conexion();
		$db = $model->conectar();
		$res = $db->prepare($this->sql);
		$res->execute();
		while($rs = $res->fetch(PDO::FETCH_ASSOC))
		{
			$this->filas[] = $rs;
		}
		$res->closeCursor();
		$this->sql = null;
		$db = null;
		$model = null;
	}

	public function total()
	{
		//Devuelve el número de filas de un array

		$filas = [];
		$this->total = null;
		$model = new Conexion();
		$db = $model->conectar();
		$res = $db->prepare($this->sql);
		$res->execute();
		$this->total = $res->rowCount();
		$res->closeCursor();
		$this->sql = null;
		$db = null;
		$model = null;
	}

	public function modificar()
	{
		$model = new Conexion();
		$db = $model->conectar();
		$sql = "UPDATE $this->from SET $this->campos where $this->where";
		/*echo $sql;
		exit();*/
		$res = $db->prepare($sql);
		$res->execute();
		$res->closeCursor();
		$this->from = null;
		$this->campos = null;
		$this->where = null;
		$db = null;
		$model = null;
	}

	public function eliminar()
	{
		$model = new Conexion();
		$db = $model->conectar();
		$sql = "DELETE from $this->from where $this->where";
		//echo $sql;
		$res = $db->prepare($sql);
		$res->execute();
		$res->closeCursor();
		$this->from = null;
		$this->where = null;
		$db = null;
		$model = null;
	}

	public function crear1()
	{
		// Crea registros----------------

		$model = new Conexion();
		$db = $model->conectar1();
		$sql = "INSERT INTO $this->from ($this->campos) VALUES ($this->valores)";
		//echo $sql;
		$res = $db->prepare($sql);
		$res->execute();
		$res->closeCursor();
		$this->from = null;
		$this->campos = null;
		$this->valores = null;
		$db = null;
		$model = null;
	}
}
?>