<?php
	require_once "clases/crud.php";
	require_once 'php_excel/Classes/PHPExcel.php';
	$crud = new Crud();

		$tmpfname = "centro_votacion.xlsx";
		$excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
		$excelObj = $excelReader->load($tmpfname);
		$worksheet = $excelObj->getSheet(0);
		$lastRow = $worksheet->getHighestRow();
		$cont = 2;
		for ($row = 2; $row <= $lastRow; $row++) {

			$valores =   $worksheet->getCell('A'.$row)->getValue().","
						.$worksheet->getCell('C'.$row)->getValue().","
						.$worksheet->getCell('E'.$row)->getValue().","
						.$worksheet->getCell('G'.$row)->getValue().","
						.'"'.$worksheet->getCell('H'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('I'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('J'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('K'.$row)->getValue().'"'.","
						.$worksheet->getCell('L'.$row)->getValue().","
						.'"'.$worksheet->getCell('O'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('P'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('Q'.$row)->getValue().'"';

				$crud->from = "centro_votaciones";
				$crud->campos = 'estado,municipio,parroquia,ctro_act,ctro_prop,nombre_centro,direccion,mesa,tomo,electores,tecnologia,cir_asa';
				$crud->valores = $valores;
				$crud->crear();
				echo $row."<br>";
		}		
?>