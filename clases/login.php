<?php
	
	require_once "conexion/conexion.php";
	
	class Acceso
	{
		public $from; 
		public $where;
		public $usuario;
		public $contra;
		public $mensaje;

		public function login()
		{
			$modelo = new Conexion();
			$db = $modelo->conectar();
			$sql = "SELECT * from  $this->from $this->where";
			$res = $db->prepare($sql);
			$res->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
			$res->bindParam(':clave', $this->contra, PDO::PARAM_STR);
			$res->execute();
			$total = $res->rowCount();
			if($total > 0)
			{
				session_start();
				$rs = $res->fetch(PDO::FETCH_ASSOC);
				if($rs['nivel'] == 1)
				{
					$_SESSION['estado'] = $rs['id_estado'];
					$_SESSION['user'] = $rs['usuario'];
					$_SESSION['nivel'] = $rs['nivel'];
					$res->closeCursor();
					$db = null;
					header('location: redi.php');
				}
				elseif($rs['nivel'] == 2)
				{
					$_SESSION['estado'] = $rs['id_estado'];
					$_SESSION['parroquia'] = $rs['id_parroquia'];
					$_SESSION['user'] = $rs['usuario'];
					$_SESSION['nivel'] = $rs['nivel'];
					$_SESSION['municipio'] = $rs['id_municipio'];
					$res->closeCursor();
					$db = null;
					header('location: redi.php');	
				}
				elseif ($rs['nivel'] == 3) 
				{
					$_SESSION['user'] = $rs['usuario'];
					$_SESSION['nivel'] = $rs['nivel'];
					$_SESSION['estado'] = $rs['id_estado'];
					$_SESSION['parroquia'] = $rs['id_parroquia'];
					$_SESSION['municipio'] = $rs['id_municipio'];
					$_SESSION['id'] = $rs['id'];
					$_SESSION['categoria'] = $rs['categoria'];
					
					if ($rs['categoria'] == "10") 
					{
						$_SESSION['nombre'] = $rs['otros'];
					}
					elseif ($rs['categoria'] == "9") 
					{
						$_SESSION['nombre'] = $rs['juventud'];
					}
					elseif ($rs['categoria'] == "8") 
					{
						$_SESSION['nombre']	= $rs['movimiento_social'];
					}
					elseif($rs['categoria'] == "7")
					{
						$_SESSION['clap'] = $rs['id_clap'];
						$_SESSION['nombre'] = $rs['nombre_clap'];
					}
					elseif ($rs['categoria'] == "6") 
					{
						$_SESSION['nombre']	 = $rs['institucion'];
					}
					elseif ($rs['categoria'] == "5") 
					{
						$_SESSION['nombre']	 = $rs['mision'];
					}
					elseif ($rs['categoria'] == "4") 
					{
						$_SESSION['nombre']	= $rs['consejo_comunal'];
					}
					elseif ($rs['categoria'] == "3") 
					{
						$_SESSION['nombre']	= $rs['nombre_ubch'];
						$_SESSION['ubch'] = $rs['ubch'];
					}

					$res->closeCursor();
					$db = null;
					header('location: redi.php');	
				}
				else
				{
					
					$_SESSION['id'] = $rs['id'];
					$_SESSION['categoria'] = $rs['categoria'];
					$_SESSION['nivel'] = $rs['nivel'];
					$_SESSION['user'] = $rs['usuario'];

					$res->closeCursor();
					$db = null;
					header('location: redi.php');	
				}
			}
			else
			{
				$res->closeCursor();
				$db = null;
				$this->mensaje = "El usuario o la contraseña son incorrectos";
			}
		}

		
	}

?>