<?php

	if (!isset($_SESSION)) {
		session_start();
	}

	switch ($_SESSION['nivel']) {
		case '1':
			header('location: regionales.php');
		break;

		case '2':
			header('location: municipales.php');
		break;

		case '3':
			if($_SESSION['categoria'] == "7")
			{
				header('location: clap.php');
			}
			elseif ($_SESSION['categoria'] == "3") 
			{
				header('location: ubch.php');
			}
			elseif ($_SESSION['categoria'] == "5") 
			{
				header('location: misiones.php');	
			}
			elseif ($_SESSION['categoria'] == "8") 
			{
				header('location: movimientos.php');	
			}
			elseif ($_SESSION['categoria'] == "6") 
			{
				header('location: instituciones.php');	
			}
			elseif ($_SESSION['categoria'] == "4") 
			{
				header('location: consejo_comunal.php');		
			}
			elseif ($_SESSION['categoria'] == "9") 
			{
				header('location: juventud.php');		
			}
			elseif ($_SESSION['categoria'] == "10") 
			{
				header('location: otros.php');		
			}
		break;

		case '4':
			header('location: administrador.php');					
		break;
	}


?>