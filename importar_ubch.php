<?php
	require_once "clases/crud.php";
	require_once 'php_excel/Classes/PHPExcel.php';
	$crud = new Crud();

		$tmpfname = "15_excel.xlsx";
		$excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
		$excelObj = $excelReader->load($tmpfname);
		$worksheet = $excelObj->getSheet(0);
		$lastRow = $worksheet->getHighestRow();
		$cont = 2;
		for ($row = 2; $row <= $lastRow; $row++) {

			$valores = $worksheet->getCell('B'.$row)->getValue().","
						.$worksheet->getCell('D'.$row)->getValue().","
						.$worksheet->getCell('F'.$row)->getValue().","
						.$worksheet->getCell('G'.$row)->getValue().","
						.'"'.$worksheet->getCell('H'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('I'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('J'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('K'.$row)->getValue().'"'.","
						.$worksheet->getCell('L'.$row)->getValue().","
						.'"'.$worksheet->getCell('M'.$row)->getValue().'"';

			$crud->from = "ubch_sucre";
			$crud->campos = 'estado,municipio,parroquia,ubch,nombre_ubch,cedula,nombre,telefono,id_cargo,cargo';
			$crud->valores = $valores;
			$crud->crear();
			echo $row."<br>";
		}		
?>