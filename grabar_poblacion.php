<?php
	if(!isset($_SESSION))
	{
		session_start();

	}
	require_once "clases/crud.php";
	$crud = new Crud();

	switch ($_REQUEST['accion']) 
	{
		case 'estructura_clap':

			$crud->sql = "SELECT id from clap_estructura where id_clap = $_SESSION[id]";
			$crud->total();
			//echo $crud->total;
			if($crud->total >= 5)
			{
				$data = ['registrado' => "Ya esta completa la estructura del clap, no puede registrar a alguien más."];	
				echo json_encode($data);	
			}
			else
			{
				$crud->sql = "SELECT cedula from clap_estructura where cedula = $_POST[cedula] and id_clap = $_SESSION[id]";
				$crud->total();
				//$crud->total;
				if($crud->total > 0)
				{
					$data = ['registrado' => "Ya esta persona ha sido registrada con algún cargo en este clap"];	
					echo json_encode($data);
				}
				else
				{
					$crud->sql = "SELECT ente from clap_estructura where id_clap = $_SESSION[id] and ente  = $_POST[ente]";
					$crud->leer();
					if(count($crud->filas) > 0)
					{
							$data = ['registrado' => "Ya este nivel de la estructura de este clap ha sido registrado"];
							echo json_encode($data);
					}
					else
					{	
						if($_POST['rol'] == 1)
						{
							$crud->sql = "SELECT rol from clap_estructura where rol = $_POST[rol] and id_clap = $_SESSION[id]";
							$crud->leer();
							if(count($crud->filas) > 0)
							{
									$data = ['registrado' => "Ya este rol de la estructura ha sido registrado y no puede ser repetido"];
									echo json_encode($data);
							}
							else
							{
									$crud->from = "clap_estructura";
									$crud->campos = "id_clap, cedula, nombre_completo, ente, rol, telefono";
									$crud->valores = "$_SESSION[id], $_POST[cedula], '".ucwords($_POST['nombre_completo'])."', $_POST[ente], $_POST[rol], $_POST[telefono]";
									$crud->crear();
									$crud = null;
							}

						}
						else
						{
									$crud->from = "clap_estructura";
									$crud->campos = "id_clap, cedula, nombre_completo, ente, rol, telefono";
									$crud->valores = "$_SESSION[id], $_POST[cedula], '".ucwords($_POST['nombre_completo'])."', $_POST[ente], $_POST[rol], $_POST[telefono]";
									$crud->crear();
									$crud = null;	
						}
					}
				}
			}
		break;

		case 'modificar_estructura_clap':

					$crud->sql = "SELECT ente from clap_estructura where id_clap = $_SESSION[id] and ente  = $_POST[ente_modi] and id <> ".$_POST['id_modi'];
					$crud->leer();
					if(count($crud->filas) > 0)
					{
							$data = ['registrado' => "Ya existe un usuario con este ente, borrelo y cree este usuario con dicho ente."];
							echo json_encode($data);
							//echo "aqui ente";
					}
					else
					{	
						if($_POST['rol_modi'] == 1)
						{
							$crud->sql = "SELECT rol from clap_estructura where rol = $_POST[rol_modi] and id_clap = $_SESSION[id] and id <> ".$_POST['id_modi'];
							$crud->leer();
							if(count($crud->filas) > 0)
							{
									$data = ['registrado' => "Ya hay un usuario con este rol, eliminelo y cree este usuario con dicho rol."];
									echo json_encode($data);
									//echo "aqui rol";
							}
							else
							{
									$id = $_POST['id_modi'];
									$crud->from = "clap_estructura";
									$crud->campos = "cedula = $_POST[cedula_modi], nombre_completo = '$_POST[nombre_completo_modi]', ente = $_POST[ente_modi], rol = $_POST[rol_modi],telefono = $_POST[telefono_modi]";
									$crud->where = "id = ".$id;
									$crud->modificar();
									$crud = null;
									$data = ['exito' => "Ya hay un usuario con este rol, eliminelo y cree este usuario con dicho rol."];
									echo json_encode($data);
							}

						}
						else
						{
									$id = $_POST['id_modi'];
									$crud->from = "clap_estructura";
									$crud->campos = "cedula = $_POST[cedula_modi], nombre_completo = '$_POST[nombre_completo_modi]', ente = $_POST[ente_modi], rol = $_POST[rol_modi],telefono = $_POST[telefono_modi]";
									$crud->where = "id = ".$id;
									$crud->modificar();
									$crud = null;
									$data = ['exito' => "Ya hay un usuario con este rol, eliminelo y cree este con dicho rol."];
									echo json_encode($data);
						}
					}
		break;

		case 'eliminar_estructura_clap':
			$crud->from = "clap_estructura";
			$crud->where = "id = ".base64_decode($_GET['id']);
			$crud->eliminar();
			header("location: clap.php");
		break;

		case 'verificar':
			$usuario = $_GET['cuenta'];
			$crud->sql= "SELECT id, clave, actualizar from usuarios  where usuario = '$usuario'";
			$crud->leer();
			$total = count($crud->filas);
			$data = [];
			if( $total > 0)
			{
				$data = ['clave' => $crud->filas[0]['clave'], 'actualizar' => $crud->filas[0]['actualizar'], 'id' => $crud->filas[0]['id']];
			}
			else
			{
				$data = ['error' => 'no se encontro resultados'];
			}
			$crud = null;
			echo json_encode($data);
		break;

		case 'cambiar_clave':
			$clave = $_POST['contra_nueva'];
			$id = $_POST['id_modificar'];
			$crud->from = "usuarios";
			$crud->campos = "clave = '$clave', actualizar = 1";
			$crud->where = 'id = '.$id;
			$crud->modificar();
			$crud = null;
		break;
	}
?>