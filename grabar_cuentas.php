<?php
	require_once "clases/crud.php";

	switch ($_REQUEST['accion']) {

		case 'estados_grabar':	
			$crud = new Crud();
			$crud->sql = "SELECT * from usuarios where id_estado = $_POST[estado] and nivel = 1";
			$crud->leer();
			$total = count($crud->filas); 
			if($total > 0)
			{
				$data = array('registrado' => '<span class="label label-danger" style="color: white; font-size: 12px;">Ya una cuenta para este estado ha sido creada</span>');
				$crud = null;
				echo json_encode($data);
			}
			else
			{
				$crud->sql = "SELECT estado from estados where id = $_POST[estado]";
				$crud->leer();
				$estado = $crud->filas[0]['estado'];
				$crud->from = "usuarios";
				$crud->campos = "usuario, clave, nivel, categoria, id_estado, actualizar";
				$crud->valores = "'".$estado."', 123456789, 1, 1, $_POST[estado],1";
				$crud->crear();

				$crud->sql = "SELECT max(id) as id from usuarios";
				$crud->leer();
				$id = $crud->filas[0]['id'];

				$crud->from = "responsables";
				$crud->campos = "id_usuario, nombre, apellido, cedula, telefono, direccion, nivel";
				$crud->valores = " $id, '$_POST[nombre]', '$_POST[apellido]', '$_POST[cedula]', '$_POST[telefono]', '$_POST[direccion]', 1";
				$crud->crear();
				$data = array('exito' => 'ha sido registrado');
				echo json_encode($data);
			}
		break;
		case 'estados_modificar':	
			$crud = new Crud();
			$crud->sql = "SELECT * from usuarios where id_estado = $_POST[estado_modi] and nivel = 1";
			$crud->leer();
			$total = count($crud->filas); 
			if($total > 0)
			{
				$data = array('registrado' => '<span class="label label-danger" style="color: white; font-size: 12px;">Ya una cuenta para este estado ha sido creada</span>');
				$crud = null;
				echo json_encode($data);
			}
			else
			{
				$crud->sql = "SELECT estado from estados where id = $_POST[estado_modi]";
				$crud->leer();
				$estado = $crud->filas[0]['estado'];
				$crud->from = "usuarios";
				$crud->campos = "usuario = '".$estado."', id_estado = $_POST[estado_modi]";
				$crud->where = "id = $_POST[id_modi]";
				$crud->modificar();

				$crud->from = "responsables";
				$crud->campos = "nombre = '$_POST[nombre_modi]', apellido = '$_POST[apellido_modi]', cedula = '$_POST[cedula_modi]', telefono = '$_POST[telefono_modi]', direccion = '$_POST[direccion_modi]'";
				$crud->where = "id_usuario = $_POST[id_modi]";
				$crud->modificar();
				$data = array('exito' => 'ha sido registrado');
				echo json_encode($data);
			}
		break;
		case 'estados_eliminar':
			$crud = new crud();
			$crud->from = "usuarios";
			$crud->where = "id = $_POST[id]";
			$crud->eliminar();

			$crud->from = "responsables";
			$crud->where = "id_usuario = ".$_POST['id'];
			$crud->eliminar();
			$crud = null;
		break;
		case 'municipales_agregar':
			$crud = new Crud();
			$crud->sql = "SELECT municipio from municipios where id_municipio = $_POST[municipio] and id_estado = $_POST[estado]";
			$crud->leer();
			$municipio = $crud->filas[0]['municipio'];
			$crud->sql = "SELECT usuario from usuarios where usuario = '$municipio'";
			$crud->leer();
			$total = count($crud->filas); 
			if($total > 0)
			{

				$data = array('registrado' => '<span class="label label-danger" style="color: white; font-size: 12px;">Ya una cuenta para este municipio ha sido creada</span>');
				$crud = null;
				echo json_encode($data);
			}
			else
			{
				$crud->from = "usuarios";
				$crud->campos = "usuario, clave, nivel, categoria, permisos, id_estado, id_municipio, actualizar";
				$crud->valores = "'$municipio', 123456789, 2, 2, '$_POST[permisos]', $_POST[estado],$_POST[municipio], 1";
				$crud->crear();

				$crud->sql = "SELECT max(id) as id from usuarios";
				$crud->leer();
				$id = $crud->filas[0]['id'];

				$crud->from = "responsables";
				$crud->campos = "id_usuario, nombre, apellido, cedula, telefono, direccion, nivel";
				$crud->valores = " $id, '$_POST[nombre]', '$_POST[apellido]', '$_POST[cedula]', '$_POST[telefono]', '$_POST[direccion]', 1";
				$crud->crear();
				$data = array('exito' => 'ha sido registrado');
				echo json_encode($data);
			}
		break;
		
		case 'municipales_modificar':
			$crud = new Crud();
			$crud->sql = "SELECT * from usuarios where id_municipio = $_POST[municipio_modi] and nivel = 2";
			$crud->leer();
			$total = count($crud->filas); 
			if($total > 0)
			{
				$data = array('registrado' => 'Ya una cuenta para este municipio ha sido creada');
				$crud = null;
				echo json_encode($data);
			}
			else
			{	
				$crud = new Crud();
				$crud->sql = "SELECT municipio from municipios where id = $_POST[municipio_modi]";
				$crud->leer();
				$municipio = utf8_encode($crud->filas[0]['municipio']);

				$crud->from = "usuarios";
				$crud->campos = "usuario = '$municipio', permisos = '$_POST[permisos_modi]', id_estado = $_POST[estado_modi],  id_municipio = $_POST[municipio_modi]";
				$crud->where = "id = '$_POST[id_modi]'";
				$crud->modificar();
				
				$crud->from = "responsables";
				$crud->campos = "nombre = '$_POST[nombre_modi]', apellido = '$_POST[apellido_modi]', cedula = '$_POST[cedula_modi]', telefono = '$_POST[telefono_modi]', direccion = '$_POST[direccion_modi]'";
				$crud->where = "id = ".$_POST['id_responsable_modi'];
				$crud->modificar();
				$crud = null;

				$data = array('exito' =>'12313');
				echo json_encode($data);
			}
		break;

		case 'locales_modificar':
			
			$crud = new Crud();
			$id = $_POST['id_modificar_cuenta'];
			$id_responsable = $_POST['id_modificar_responsable'];
			$crud->from = "usuarios";

			if(!empty($_POST['ubch_modificar']))
			{
				$crud->campos = "id_parroquia = $_POST[parroquia_modificar], permisos = $_POST[permisos_modificar], categoria = $_POST[categoria_modificar],
									ubch = $_POST[ubch_modificar]";
			}
			else if(!empty($_POST['consejo_comunal_modificar']))
			{
				$crud->campos = "id_parroquia = $_POST[parroquia_modificar], permisos = $_POST[permisos_modificar], categoria = $_POST[categoria_modificar],
									concejo_comunal = '$_POST[consejo_comunal_modificar]'";	
			}
			else if(!empty($_POST['movimiento_sociales_modificar']))
			{
				$crud->campos = "id_parroquia = $_POST[parroquia_modificar], permisos = $_POST[permisos_modificar], categoria = $_POST[categoria_modificar],
									movimiento_social = '$_POST[movimiento_sociales_modificar]'";		
			}
			else if(!empty($_POST['misiones_modificar']))
			{
				$crud->campos = "id_parroquia = $_POST[parroquia_modificar], permisos = $_POST[permisos_modificar], categoria = $_POST[categoria_modificar],
									mision = '$_POST[misiones_modificar]'";			
			}
			else if(!empty($_POST['instituciones_modificar']))
			{
				$crud->campos = "id_parroquia = $_POST[parroquia_modificar], permisos = $_POST[permisos_modificar], categoria = $_POST[categoria_modificar],
									mision = '$_POST[instituciones_modificar]'";				
			}
			else if(!empty($_POST['clap_modificar']))
			{
				$crud->campos = "id_parroquia = $_POST[parroquia_modificar], permisos = $_POST[permisos_modificar], categoria = $_POST[categoria_modificar],
									id_clap = '$_POST[clap_modificar]'";					
			}

			$crud->where = "id = ".$id;
			$crud->modificar();

			$crud->from = "responsables";
			$crud->campos = "nombre = '$_POST[nombre_modificar]', apellido = '$_POST[apellido_modificar]', cedula = $_POST[cedula_modificar], telefono = $_POST[telefono_modificar], direccion = '$_POST[direccion_modificar]'";
			$crud->where = "id = ".$id_responsable;
			$crud->modificar();
			$crud = null;
			header('location: regionales.php');
		break;

		case 'municipales_eliminar':
			$crud = new crud();
			$crud->from = "usuarios";
			$crud->where = "id = $_POST[id]";
			$crud->eliminar();

			$crud->from = "responsables";
			$crud->where = "id_usuario = ".$_POST['id'];
			$crud->eliminar();
			$crud = null;
		break;

		case 'traer_municipio':
			$crud = new crud();
			$crud->sql = "SELECT id from municipios where municipio = '$_GET[usuario]' and id_estado = 4";
			$crud->leer();
			$total = count($crud->filas);
			if($total > 0)
			{
				$data = array('id' => $crud->filas[0]['id']);
				$crud = null;
				echo json_encode($data);
			}
		break;

		case 'traer_datos':
			$crud = new crud();
			$id = $_GET['id'];
			$crud->sql = "SELECT id, parroquia, id_municipio from parroquias where id_estado = 4 and id = ".$id;
			$crud->leer();
			$lista1 = $crud->filas;

			$crud->sql = "SELECT id, municipio from municipios where id_estado = 4 and id_municipio = ".$lista1[0]['id_municipio'];
			$crud->leer();
			$lista2 = $crud->filas;
			$data[0] = array('id' => $lista2[0]['id'], 'municipio' => $lista2[0]['municipio']);

			$crud->sql = "SELECT id, parroquia from parroquias where id_estado = 4 and id_municipio = ".$lista1[0]['id_municipio'];
			$crud->leer();
			$data1 = "";
			foreach ($crud->filas as $row) 
			{
				$data1[] = array('id_parroquia' => $row['id'],
								'parroquia' => $row['parroquia']);
			}
			$data = array_merge($data, $data1);
			$crud = null;
			echo json_encode($data);
		break;

		/*case 'parroquias':
			$crud = new crud();
			$crud->sql = "SELECT id_municipio from municipios where id = $_GET[id]";
			$crud->leer();
			$id = $crud->filas[0]['id_municipio'];
			$crud->sql = "SELECT id, parroquia from parroquias where id_municipio = $id and id_estado = 4";
			$crud->leer();
			$data = "";
			foreach ($crud->filas as $row) 
			{
				$data[] = array('id' => $row['id'],
								'parroquia' => utf8_encode($row['parroquia']));
			}
			echo json_encode($data);
		break;*/
	}







?>