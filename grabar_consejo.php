<?php
	if(!isset($_SESSION))
	{
		session_start();

	}
	require_once "clases/crud.php";
	$crud = new Crud();

	switch ($_REQUEST['accion']) 
	{
		case 'grabar_estructura':

			$crud->sql = "SELECT * from estructuras where cedula = $_POST[cedula] and id_consejo = $_POST[id_consejo]";
			$crud->total();
			if($crud->total > 0)
			{
				$data = ['registrado' => 'Ya este usuario ha sido registrado'];
				echo json_encode($data);
			}
			else
			{
				$fecha = date('Y-m-d', strtotime($_POST['fecha_nac']));
				$crud->from = "estructuras";
				$crud->campos = "id_consejo, nac, cedula, nombre, apellido, telefono, direccion, email, fecha_nacimiento, centro_votacion, sexo";
				$crud->valores = "$_POST[id_consejo], '$_POST[nac]','$_POST[cedula]','$_POST[nombre]','$_POST[apellido]','$_POST[telefono]','$_POST[direccion]','$_POST[email]', '$fecha', '$_POST[centro_vot]', '$_POST[sexo]'";
				$crud->crear();
				$crud = null;
				$data = ['exito' => 'registrado'];
				echo json_encode($data);	
			}
		break;

		case 'modificar_estructura':
			$fecha = date('Y-m-d', strtotime($_POST['fecha_nac_edit']));
			$crud->from = "estructuras";
			$crud->campos = "nac = '$_POST[nac_edit]', cedula = '$_POST[cedula_edit]', nombre = '$_POST[nombre_edit]', apellido = '$_POST[apellido_edit]', telefono = '$_POST[telefono_edit]', direccion = '$_POST[direccion_edit]', fecha_nacimiento = '$fecha', email = '$_POST[email_edit]'";
			$crud->where = "id = $_POST[id_modificar]";
			$crud->modificar();
			$crud = null;
			header('location: consejo_comunal.php');
		break;

		case 'grabar_conformante':
			$crud->sql = "SELECT id from caracterizacion where cedula = $_POST[ced_resp] and id_cc_lider = $_POST[id_cc_lider]";
			$crud->total();
			if($crud->total > 0)
			{
				$data = ['registrado' => 'No se puede grabar este militante porque ya esta registrado'];
				$crud = null;
				echo json_encode($data);
			}
			else
			{


				foreach ($_POST as $campo => $valor) 
				{
					$$campo=$valor;
				}

				$publico = "";
				$privado ="";
				$independiente = "";
				$institucion = "";
				$carrera = "";
				$clp="";
				$ubcn="";
				$congreso_p= "";
				$delegado_p ="";
				$gpp = "";
				$ms = "";
				$mr = "";
				$mri = "";
				$ffm = "";
				$twitter = "";
				$viviendo_vene ="";
				$movimiento_cultu ="";
				$movimiento_campe ="";
				$sitio = "";
				$vota ="";
				$n_colectivo="";
				$militancia ="";
				$email ="";
				$n_consejo ="";
				$sector ="";
				$sectorr ="";
				$callee = "";
				$institucion = "";
				$carrera = "";
				if(empty($_POST["n_colectivo"])){$n_colectivo = NULL;}else{$n_colectivo = $_POST["n_colectivo"];}
				if(empty($_POST["militancia"])){$militancia = 0;}else{$militancia = $_POST["militancia"];}
				if(empty($_POST["publico"])){$publico = NULL;}else{$publico = $_POST["publico"];}
				if(empty($_POST["privado"])){$privado = NULL;}else{$privado = $_POST["privado"];}
				if(empty($_POST["independiente"])){$independiente = NULL;}else{$independiente = $_POST["independiente"];}
				if(empty($_POST["institucion"])){$institucion = NULL;}else{$institucion = $_POST["institucion"];}
				if(empty($_POST["clp"])){$clp = NULL;}else{$clp = $_POST["clp"];}
				if(empty($_POST["ubcn"])){$ubcn = NULL;}else{$ubcn = $_POST["ubcn"];}
				if(empty($_POST["congreso_patria"])){$congreso_p = NULL;}else{$congreso_p = $_POST["congreso_patria"];}
				if(empty($_POST["delegado_patria"])){$delegado_p = NULL;}else{$delegado_p = $_POST["delegado_patria"];}
				if(empty($_POST["gpp"])){$gpp = NULL;}else{$gpp = $_POST["gpp"];}
				if(empty($_POST["ms"])){$ms = NULL;}else{$ms = $_POST["ms"];}
				if(empty($_POST["mr"])){$mr = NULL;}else{$mr = $_POST["mr"];}
				if(empty($_POST["mri"])){$mri = NULL;}else{$mri = $_POST["mri"];}
				if(empty($_POST["ffm"])){$ffm = NULL;}else{$ffm = $_POST["ffm"];}
				if(empty($_POST["twitter"])){$twitter = NULL;}else{$twitter = $_POST["twitter"];}
				if(empty($_POST["carrera"])){$carrera = NULL;}else{$carrera = $_POST["carrera"];}
				if(empty($_POST["viviendo_venezolanos"])){$viviendo_vene = NULL;}else{$viviendo_vene = $_POST["viviendo_venezolanos"];}
				if(empty($_POST["movimiento_cultu"])){$movimiento_cultu = NULL;}else{$movimiento_cultu = $_POST["movimiento_cultu"];}
				if(empty($_POST["movimiento_campe"])){$movimiento_campe = NULL;}else{$movimiento_campe = $_POST["movimiento_campe"];}
				if(empty($_POST["email"])){$email = NULL;}else{$email = $_POST["email"];}
				if(empty($_POST["s_trabajo"])){$sitio = NULL;}else{$sitio = $_POST["s_trabajo"];}
				if(empty($_POST["vota"])){$vota = "no";}else{$vota = $_POST["vota"];}
				if(empty($_POST["otro_s"])){$sectorr = $_POST["sector"];}else{$sectorr = $_POST["otro_s"];}
				if(empty($_POST["otra_c"])){$callee = $_POST["calle"];}else{$callee = $_POST["otra_c"];}
				if(empty($_POST["otra_carrera"])){$carrera = $_POST["carrera"];}else{$carrera = $_POST["otra_carrera"];}
				if(empty($_POST["otra_institucion"])){$institucion = $_POST["institucion"];}else{$institucion = $_POST["otra_institucion"];}


				if($_POST["consejoc"] == "si"){
					if(empty($_POST["n_consejo"])){
						$n_consejo = $_POST["otro_consejo"];
					}else{
						$n_consejo = $_POST["n_consejo"];
					}
				}else{
					$n_consejo = NULL;
				}

				$carrera = ucwords($carrera);
				$institucion = ucwords($institucion);
				$profesion = ucwords($profesion);
				$callee = strtolower($callee);
				$sectorr = ucwords($sectorr);
				$ocupacion = ucwords($ocupacion);
				$fecha = date('Y-m-d', strtotime($fecha));
				$sitio = ucwords($sitio);
				$nom_resp = ucwords(strtolower($nom_resp));

				$crud->from = "caracterizacion";
				$crud->campos = "id_cc_lider, cedula ,nacionalidad ,  nombre ,  genero ,  fechanacimiento ,  telefono1  , sector, calle ,  estado ,  municipio ,  parroquia ,  email ,  twitter, vota";
				$crud->valores = "$id_cc_lider,$ced_resp,'$nac_resp' ,'$nom_resp' ,'$genero','$fecha' ,  '$tlf1' ,  '$sectorr', '$callee', $_POST[estado] ,  $_POST[municipio] ,  $parroquia ,  '$email' ,  '$twitter', '$vota'";
				$crud->crear();

				$crud->from = "caracterizacion_datos_al";
				$crud->campos = "id_cc_lider, cedula, nivel, profesion, ocupacion, estudia, institucion, carrera, trabaja, sitio, publico, privado, independiente";
				$crud->valores = "$id_cc_lider,$ced_resp,'$titulo', '$profesion', '$ocupacion', '$estudia', '$institucion', '$carrera', '$trabaja', '$sitio','$publico', '$privado', '$independiente'";
				$crud->crear();

				$crud->from = "caracterizacion_militancia";
				$crud->campos = "id_cc_lider,cedula, tiempo, tareas_partido, clp, ubch, congreso_patria, delegado_patria, gpp, ms, mr, mri, ffm, consejoc, n_consejo, movimientos, viviendo_venezolanos, movimiento_campe, movimiento_cultu, colectivo, n_colectivo";
				$crud->valores = "$id_cc_lider,$ced_resp, '$militancia', '$tareas', '$clp', '$ubcn', '$congreso_p', '$delegado_p', '$gpp', '$ms', '$mr', '$mri', '$ffm', '$consejoc', '$n_consejo','$movimiento_s','$viviendo_vene', '$movimiento_campe', '$movimiento_cultu', '$colectivo','$n_colectivo'";
				$crud->crear();
				$data = ['exitoso' => "registrado con éxito"];
				$crud = null;
				echo json_encode($data);
			}
		break;
	}

?>