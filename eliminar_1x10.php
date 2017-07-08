<?
	require_once "clases/crud.php";
	$crud = new Crud();

	if(!isset($_SESSION))
	{
		session_start();
	}

	$cedula = $_GET['cedula'];

	$crud->from = "caracterizacion";
	$crud->where = "cedula = ".$cedula;
	$crud->eliminar();

	$crud->from = "caracterizacion_datos_al";
	$crud->where = "cedula = ".$cedula;
	$crud->eliminar();

	$crud->from = "caracterizacion_militancia";
	$crud->where = "cedula = ".$cedula;
	$crud->eliminar();

	header('location: redi.php');
	
?>