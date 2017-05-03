<?

	require_once "clases/crud.php";
	$crud = new Crud();

	$crud->sql = "SELECT id_municipio, municipio from municipios where id_estado = $_GET[estado]";
	$crud->leer();

	$data = [];

	foreach ($crud->filas as $row) 
	{
		$data[] = $row;
	}

	echo json_encode($data);

?>