<?php
	require_once "clases/crud.php";
	$crud = new Crud();

	switch ($_REQUEST['accion']) 
	{

		case 'locales_agregar':
				$crud->sql = "SELECT parroquia from parroquias where id = $_POST[parroquia]";
				$crud->leer();

				$parroquia = $crud->filas[0]['parroquia'];
				$nombre = substr($parroquia, 0, 5);

				$crud->sql = "SELECT usuario FROM usuarios WHERE usuario LIKE '%$nombre%' and id = (SELECT max(id) from usuarios where usuario LIKE '%$nombre%')";
				$crud->leer();
				$total = count($crud->filas);
				if($total > 0)
				{
					$usuario = substr($crud->filas[0]['usuario'],-2);
					if($usuario < "09")
					{
						$usuario = "0".($usuario + 1);
					}
					else if($usuario >= "09")
					{
						$usuario = $usuario + 1;
					}

					$parroquia = "g-".$nombre."-".$usuario;
				}
				else
				{
					$parroquia = "g-".$nombre."-"."01";
				}

					$parroquia = strtoupper($parroquia);

				$crud->from = "usuarios";


				if(!empty($_POST['clap']))
				{
					//echo "Aqui Clap";
					$crud->campos = "usuario, clave, nivel, categoria, id_clap, permisos, id_municipio, id_parroquia, actualizar";	
					$crud->valores = "'$parroquia', 123456789, 3, $_POST[categoria], $_POST[clap], '$_POST[permisos]', $_POST[municipio], $_POST[parroquia], 0";
				}
				else if(!empty($_POST['ubch']))
				{
					//echo "Aqui Ubch";
					$crud->campos = "usuario, clave, nivel, categoria, ubch, permisos, id_municipio, id_parroquia, actualizar";	
					$crud->valores = "'$parroquia', 123456789, 3, $_POST[categoria], '$_POST[ubch]', '$_POST[permisos]', $_POST[municipio], $_POST[parroquia], 0";	
				}
				else if(!empty($_POST['consejo_comunal']))
				{
					//echo "Aqui concejo comunal";
					$crud->campos = "usuario, clave, nivel, categoria, consejo_comunal, permisos, id_municipio, id_parroquia, actualizar";	
					$crud->valores = "'$parroquia', 123456789, 3, $_POST[categoria], '$_POST[consejo_comunal]', '$_POST[permisos]', $_POST[municipio], $_POST[parroquia], 0";		
				}
				else if(!empty($_POST['misiones']))
				{
					
					$crud->campos = "usuario, clave, nivel, categoria, mision, permisos, id_municipio, id_parroquia, actualizar";	
					$crud->valores = "'$parroquia', 123456789, 3, $_POST[categoria], '$_POST[misiones]', '$_POST[permisos]', $_POST[municipio], $_POST[parroquia], 0";			
				}
				else if(!empty($_POST['institucion']))
				{
					//echo "Aqui institucion";
					$crud->campos = "usuario, clave, nivel, categoria, institucion, permisos, id_municipio, id_parroquia, actualizar";	
					$crud->valores = "'$parroquia', 123456789, 3, $_POST[categoria], '$_POST[institucion]', '$_POST[permisos]', $_POST[municipio], $_POST[parroquia], 0";				
				}
				else if (!empty($_POST['movimientos_sociales'])) 
				{
					//echo "Aqui Movimiento social";
					$crud->campos = "usuario, clave, nivel, categoria, movimiento_social, permisos, id_municipio, id_parroquia, actualizar";	
					$crud->valores = "'$parroquia', 123456789, 3, $_POST[categoria], '$_POST[movimientos_sociales]', '$_POST[permisos]', $_POST[municipio], $_POST[parroquia], 0";					
				}
				else if (!empty($_POST['juventud'])) 
				{
					//echo "Aqui Movimiento social";
					$crud->campos = "usuario, clave, nivel, categoria, juventud, permisos, id_municipio, id_parroquia, actualizar";	
					$crud->valores = "'$parroquia', 123456789, 3, $_POST[categoria], '$_POST[juventud]', '$_POST[permisos]', $_POST[municipio], $_POST[parroquia], 0";					
				}
				else if (!empty($_POST['otros'])) 
				{
					//echo "Aqui Movimiento social";
					$crud->campos = "usuario, clave, nivel, categoria, otros, permisos, id_municipio, id_parroquia, actualizar";	
					$crud->valores = "'$parroquia', 123456789, 3, $_POST[categoria], '$_POST[otros]', '$_POST[permisos]', $_POST[municipio], $_POST[parroquia], 0";					
				}
				$crud->crear();

				$crud->sql = "SELECT max(id) as id from usuarios";
				$crud->leer();
				$id = $crud->filas[0]['id'];

				$crud->from = "responsables";
				$crud->campos = "id_usuario, nombre, apellido, cedula, telefono, direccion, nivel";
				$crud->valores = "$id ,'$_POST[nombre]', '$_POST[apellido]', '$_POST[cedula]', '$_POST[telefono]', '$_POST[direccion]', 2";
				$crud->crear();
				$crud = null;
		break;

		case 'modificar_cuenta':
			$id = $_POST['id_modificar_cuenta'];
			$id_responsable = $_POST['id_modificar_responsable'];
			$crud->from = "usuarios";

			if(!empty($_POST['ubch_modi']))
			{
				$crud->campos = "id_parroquia = $_POST[parroquia_modi], permisos = $_POST[permisos_modi], categoria = $_POST[categoria_modi],
									ubch = $_POST[ubch_modi]";
			}
			else if(!empty($_POST['consejo_comunal_modi']))
			{
				$crud->campos = "id_parroquia = $_POST[parroquia_modi], permisos = $_POST[permisos_modi], categoria = $_POST[categoria_modi],
									consejo_comunal = '$_POST[consejo_comunal_modi]'";	
			}
			else if(!empty($_POST['movimientos_sociales_modi']))
			{
				$crud->campos = "id_parroquia = $_POST[parroquia_modi], permisos = $_POST[permisos_modi], categoria = $_POST[categoria_modi],
									movimiento_social = '$_POST[movimientos_sociales_modi]'";		
			}
			else if(!empty($_POST['misiones_modi']))
			{
				$crud->campos = "id_parroquia = $_POST[parroquia_modi], permisos = $_POST[permisos_modi], categoria = $_POST[categoria_modi],
									mision = '$_POST[misiones_modi]'";			
			}
			else if(!empty($_POST['institucion_modi']))
			{
				$crud->campos = "id_parroquia = $_POST[parroquia_modi], permisos = $_POST[permisos_modi], categoria = $_POST[categoria_modi],
									institucion = '$_POST[institucion_modi]'";				
			}
			else if(!empty($_POST['clap_modi']))
			{
				$crud->campos = "id_parroquia = $_POST[parroquia_modi], permisos = $_POST[permisos_modi], categoria = $_POST[categoria_modi],
									id_clap = '$_POST[clap_modi]'";					
			}
			else if(!empty($_POST['juventud_modi']))
			{
				$crud->campos = "id_parroquia = $_POST[parroquia_modi], permisos = $_POST[permisos_modi], categoria = $_POST[categoria_modi],
									juventud = '$_POST[juventud_modi]'";					
			}
			else if(!empty($_POST['otros_modi']))
			{
				$crud->campos = "id_parroquia = $_POST[parroquia_modi], permisos = $_POST[permisos_modi], categoria = $_POST[categoria_modi],
									otros = '$_POST[otros_modi]'";					
			}

			$crud->where = "id = ".$id;
			$crud->modificar();

			$crud->from = "responsables";
			$crud->campos = "nombre = '$_POST[nombre_modi]', apellido = '$_POST[apellido_modi]', cedula = $_POST[cedula_modi], telefono = $_POST[telefono_modi], direccion = '$_POST[direccion_modi]'";
			$crud->where = "id = ".$id_responsable;
			$crud->modificar();
			$crud = null;
			header('location: municipales.php');
		break;

		case 'eliminar':
			$id = base64_decode($_GET['id']);
			$crud->from = "usuarios";
			$crud->where = "id = ".$id;
			$crud->eliminar();

			$crud->from = "responsables";
			$crud->where = "id_usuario = ".$id;
			$crud->eliminar();
			$crud = null;
			header('location: municipales.php');
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