<?php
	
	if(!isset($_SESSION))
	{
		session_start();

	}

require_once "clases/crud.php";
$crud = new Crud();

	switch ($_REQUEST['accion'])	
	{
		case 'agregar':
			$crud->sql = "SELECT id from 1x15_clap where cedula = $_POST[cedula]";
			$crud->total();
			if($crud->total > 0)
			{
				$data = ['registrado' => "Ya esta persona ha sido registrada"];
				echo json_encode($data);
				$crud = null;
			}
			else
			{
				$crud->sql = "SELECT cod_viejo from rep_nueva2 where cedula = $_POST[cedula]";
				$crud->leer();
				$centro = $crud->filas[0]['cod_viejo'];	

				

				$crud->from = "1x15_clap";
				$crud->campos = "id_usu, id_lider_1x15, id_clap, nombre, apellido, nac, cedula, telefono, centro_votacion,estado,municipio";
				$crud->valores = "$_POST[id], $_POST[id_lider], $_POST[clap], '$_POST[nombre]', '$_POST[apellido]', '$_POST[nac]', '$_POST[cedula]','$_POST[telefono]', '$centro',$_SESSION[estado], $_SESSION[municipio]";
				$crud->crear();
				$crud = null;
				$data = ['exito' => "Ha sido registrado con éxito"];
				echo json_encode($data);
			}
		break;
	}



?>