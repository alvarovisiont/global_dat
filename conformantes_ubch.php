<?php
	require_once "encabezado.php";
	$id = base64_decode($_GET['id']);
	$crud->sql = "SELECT id from caracterizacion where id_ubch_lider = ".$id;
	$crud->total();
	$total = $crud->total;
?>
<div class="row">
	<div class="container-fluid">
		<div class="col-md-12">
			<div class="col-md-4">
				<?php
					if($total < 10)
					{
						echo "<button class='btn btn-success btn-md btn-block' data-target='#agregar_modal' data-toggle='modal'>Agregar Integrante</button>";
					}
				?>
			</div>
			<br>
			<br>
			<br>
			<div class="col-md-12">
				<table class="table table-streped table-condensed table-hover">
					<thead>
						<th class="text-center">Nombre</th>
						<th class="text-center">Cédula</th>
						<th class="text-center">Nac</th>
						<th class="text-center">Teléfono</th>
						<th class="text-center">Dirección</th>
						<th class="text-center">Email</th>
						<th></th>
					</thead>
					<tbody class="text-center">
						<?php
							$crud->sql = "SELECT * from caracterizacion 
										INNER JOIN caracterizacion_datos_al ON caracterizacion.cedula =  caracterizacion_datos_al.cedula
										INNER JOIN caracterizacion_militancia cm ON caracterizacion.cedula = cm.cedula  
										 where estado = $_SESSION[estado] and municipio = $_SESSION[municipio] and 
										 caracterizacion.id_ubch_lider = ".$id;
							$crud->leer();
							if(count($crud->filas) > 0)
							{
								foreach ($crud->filas as $row) 
								{
										$button = "<button class='btn btn-primary btn-sm' data-toggle='modal' data-backdrop='static'
										data-target = '#modal_ver'
										data-cedula = '$row[cedula]'
										data-nac = '$row[nacionalidad]'
										data-nombre = '$row[nombre]'
										data-genero = '$row[genero]'
										data-fecha_nac = '".date('d-m-Y', strtotime($row['fechanacimiento']))."'
										data-telefono = '$row[telefono1]',
										data-sector = '$row[sector]',
										data-calle = '$row[calle]',
										data-parroquia = '$row[parroquia]',
										data-email = '$row[email]',
										data-twitter = '$row[twitter]',
										data-nivel = '$row[nivel]',
										data-profesion = '$row[profesion]',
										data-ocupacion = '$row[ocupacion]',
										data-estudia = '$row[estudia]',
										data-institucion = '$row[institucion]',
										data-carrera = '$row[carrera]',
										data-trabaja = '$row[trabaja]',
										data-sitio = '$row[sitio]',
										data-publico = '$row[publico]',
										data-privado = '$row[privado]',
										data-independiente = '$row[independiente]',
										data-tiempo = '$row[tiempo]',
										data-tareas_partido = '$row[tareas_partido]',
										data-clp = '$row[clp]',
										data-ubch = '$row[ubch]',
										data-congreso = '$row[congreso_patria]',
										data-delegado = '$row[delegado_patria]',
										data-gpp = '$row[gpp]',
										data-ms  = '$row[ms]',
										data-mr = '$row[mr]',
										data-mri = '$row[mri]',
										data-ffm = '$row[ffm]',
										data-consejo = '$row[consejoc]',
										data-n_consejo = '$row[n_consejo]',
										data-movimientos = '$row[movimientos]',
										data-viviendo = '$row[viviendo_venezolanos]',
										data-movimiento_campe = '$row[movimiento_campe]',
										data-movimiento_cultu = '$row[movimiento_cultu]',
										data-colectivo = '$row[colectivo]',
										data-n_colectivo = '$row[n_colectivo]'
										>Ver&nbsp;<span class='glyphicon glyphicon-eye-open'></span></button>";
										$eliminar = '<a href="eliminar_1x10.php?cedula='.$row['cedula'].'" class="btn btn-sm btn-danger eliminar">Eliminar&nbsp;<i class="fa fa-trash"></i></a>';
										echo "<tr>
												<td>$row[nombre]</td>
												<td>$row[cedula]</td>
												<td>$row[nacionalidad]</td>
												<td>$row[telefono1]</td>
												<td>".$row['sector']."-".$row['calle']."</td>
												<td>$row[email]</td>
												<td>".$button.$eliminar."</td>
											</tr>";	
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div>
	<div id="agregar_modal" class="modal fade" role="dialog">
			    <div class="modal-dialog" style="width: 70%">
			        <!-- Modal content-->
			        <div class="modal-content">
			            <div class="modal-header login-header">
			                <button type="button" class="close" data-dismiss="modal">×</button>
			                <h4 class="modal-title">Agregar Integrante</h4>
			            </div>
			            <form class="form-horizontal" id="form_estructura" action="grabar_ubch.php" method="POST">
			                <input type="hidden" name="accion" value="agregar_conformante">
			                <input type="hidden" name="id_ubch_lider" value="<?php echo $id; ?>">
			                <div class="modal-body">
			                    <div class="row">
			                    	<label class="col-sm-3 control-label" for="nac_resp">Cédula de Indentidad:</label>
								    <div class="col-md-9">
								  		<div class="input-group">
						                    <div class="input-group-btn">
								                 <select class="form-control input-sm" id="nac_resp" name="nac_resp" style="width:55px">
													<option value="V" selected>V</option>
													<option value="E">E</option>
												</select>
						                    </div>
						                    <input type="number" id="ced_resp" name="ced_resp" required placeholder="Cédula" class="form-control input-sm"/>
						                </div>
						            </div>
			                        <div class="form-group">
									    <label for="inputEmail3" class="col-sm-3 control-label">Nombres y Apellidos: </label>
									    <div class="col-md-9">
									      <input type="text" required name="nom_resp" id="nombres" class="form-control input-md" >
									    </div>
									</div>
									<div class="form-group">
									<label for="inputEmail3" class="col-md-3 control-label">Genero: </label>
									<div class="col-md-3">
										<label class="radio-inline"><input required type="radio" name="genero" value="masculino">Masculino</label>
									     <label class="radio-inline"><input type="radio" name="genero" value="femenino">Femenino</label>
									</div>
									<label for="inputEmail3" class="col-md-3 control-label">Fecha de nacimiento: </label>
										<div class="col-md-3">
											 <input type="text" required required name="fecha" id="fecha"  class="form-control input-md" >
										</div>
									</div>
									<div class="form-group">
										
									</div>
									<div class="form-group">
									    <label for="inputEmail3" class="col-md-3 control-label">Telefono: </label>
									    <div class="col-md-3">
									      <input type="number" required name="tlf1" id="tlf1" placeholder="telefono" maxlength="11" class="form-control input-md" >
									    </div>
									</div>
									<div class="form-group">
								    <label for="inputEmail3" class="col-md-3 control-label">Sector: </label>
									    <div class="col-md-3">
											<select name="sector" id="sector" class="form-control input-md" required>
											<option value=""></option>
											<option id="vacio" value=""></option>
											<option value=""></option>
											<?php 
													$crud->sql = "SELECT DISTINCT sector FROM bene_sucre where sector <> ''";
													$crud->leer();
													foreach($crud->filas as $rs_sector){?>
												<option><?php echo $rs_sector["sector"]; ?></option>
												<?php } ?>
											</select>
									    </div>
									<label for="inputEmail3" class="col-md-3 control-label">Calle: </label>
									    <div class="col-md-3">
											<select name="calle" id="calle" class="form-control input-md" required>
											<option value=""></option>
											<option id="vacio1"></option>
											<option value=""></option>
											<?php 
													$crud->sql = "SELECT DISTINCT calle FROM bene_sucre where sector <> ''";
													$crud->leer();
													foreach($crud->filas as $rs_calle){?>
												<option><?php echo $rs_calle["calle"]; ?></option>
												<?php } ?>
											</select>
									    </div>
									</div>
									<div class="form-group">
										<label class="checkbox-inline col-md-4 control-label"><input type="checkbox" name="otro_sector" id="otro_sector">Otra dirección</label>
										<label class="checkbox-inline col-md-4 control-label" id="check_escondido" style="display:none;"><input type="checkbox" name="otro_sector" id="check_oculto">Ocultar</label>
									</div>
									<div class="form-group" style="display:none" id="mensaje_oculto">
											<div id="msjj2" class="label label-info" style="text-shadow:0 2px 2px rgba(0,0,0, .7)"><h4>Ya existe una dirección de Vivienda</h4></div>
									</div>
									<div class="form-group" id="sector_oculto" style="display:none;">
										<label for="inputEmail3" class="col-md-3 control-label">Otro Sector: </label>
											<div class="col-md-3">
												<input type="text" name="otro_s" id="otro_s" class="form-control input-md" placeholder="">
											</div>
										<label for="inputEmail3" class="col-md-3 control-label">Otra Calle: </label>
											<div class="col-md-3">
												<input type="text" name="otra_c" id="otra_c" class="form-control input-md" placeholder="">
											</div>
									</div>
									<div class="form-group" id="geografia"> <!--style="display:none;"-->
								    <label for="inputEmail3" class="col-md-2 control-label">Estado: </label>
									    <div class="col-md-2">
									      <select name="estado" id="estado" class="form-control input-md" disabled="">
									      		<?php
										   			$crud->sql = "SELECT id, estado from estados where id = $_SESSION[estado]";
										   			$crud->leer();
										   			foreach ($crud->filas as $row) 
										   			{
										   				echo "<option value='$row[id]'>$row[estado]</option>";
										   			}
										   		?>
									      </select>
									    </div>
									<label for="inputEmail3" class="col-md-2 control-label">Municipio: </label>
										<div class="col-md-2">
										   <select name="municipio" id="municipio" class="form-control input-md" disabled="">
										   		<?php
										   			$crud->sql = "SELECT id_municipio, municipio from municipios where id_municipio = $_SESSION[municipio] and id_estado = $_SESSION[estado]";
										   			$crud->leer();
										   			foreach ($crud->filas as $row) 
										   			{
										   				echo "<option value='$row[id_municipio]'>$row[municipio]</option>";
										   			}
										   		?>
									      </select>
										</div>
									<label for="inputEmail3" class="col-md-2 control-label">Parroquia: </label>
										<div class="col-md-2">
										   <select name="parroquia" id="parroquia" class="form-control input-md">
										   		<?php
										   			$crud->sql = "SELECT parroquia, id from parroquias where id_municipio = $_SESSION[municipio] and id_estado = $_SESSION[estado]";
										   			$crud->leer();
										   			foreach ($crud->filas as $row) 
										   			{
										   				echo "<option value='$row[id]'>$row[parroquia]</option>";
										   			}
										   		?>
									      </select>
										</div>
				                    </div>    
									<div class="form-group">
									    <label for="inputEmail3" class="col-md-3 control-label">Email: </label>
									    <div class="col-md-3">
									    	<div class="input-group">
									    		<span class="input-group-addon">@</span>
									      		<input type="email" name="email" id="email" class="form-control input-md">
									    	</div>
									    </div>
									<label for="inputEmail3" class="col-md-3 control-label">Twitter: </label>
										<div class="col-md-3">
											<div class="input-group">
									    		<span class="input-group-addon">@</span>
										   	<input type="text" name="twitter" id="twitter" class="form-control input-md">
										   </div>	
									    </div>
									</div>
										<label align="center" style="color: #AE0000;"><h1>Datos academicos y laborales</h1></label>
									<div class="form-group" id="mun"> <!--style="display:none;"-->
								    <label for="inputEmail3" class="col-md-3 control-label">Nivel de instrucción: </label><br>
								    	  <label class="radio-inline"><input required type="radio" name="titulo" value="primaria">Primaria</label>
									      <label class="radio-inline"><input type="radio" name="titulo" value="bachiller">Bachiller</label>
									      <label class="radio-inline"><input type="radio" name="titulo" value="tsu">Tsu</label>
									      <label class="radio-inline"><input type="radio" name="titulo" value="licenciado">Licenciado</label>
									      <label class="radio-inline"><input type="radio" name="titulo" value="universitario">Universitario</label>
									      <label class="radio-inline"><input type="radio" name="titulo" value="postgrado">Postgrado</label>
									</div>
									<div class="form-group">
										    <label for="inputEmail3" class="col-md-3 control-label">Profesión(titulo Obtenido): </label>
										    <div class="col-md-3">
										      <input type="text" required name="profesion" id="profesion" class="form-control input-md">
										    </div>
										    <label for="inputEmail3" class="col-md-3 control-label">Ocupación: </label>
										    <div class="col-md-3">
										      <input type="text" required name="ocupacion" id="ocupacion" class="form-control input-md">
										    </div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-md-3 control-label">Estudia: </label>
										    <div class="col-md-3">
										       <label class="radio-inline"><input required type="radio" name="estudia" id="estudia" value="si">Si</label>
									      		<label class="radio-inline"><input type="radio" name="estudia" id="estudia" value="no">No</label>
										    </div>
									</div>
									<div class="form-group" id="c_estudios" style="display:none;">
											<label for="inputEmail3" class="col-md-3 control-label">Institución: </label>
												<div class="col-md-3">
												   	 <select name="institucion" id="institucion" class="form-control input-md">
												   	 	<option id="vacio2"></option>
												   	 	<option ></option>								   	 	
														<?php  
															$crud->sql = "SELECT id, universidad from carreras where universidad <> ''";
															$crud->leer();
															foreach ($crud->filas as $row) 
															{
																echo "<option value='$row[id]'>$row[universidad]</option>";
															}
														?>
												   	 </select>
												</div>
											<label for="inputEmail3" class="col-md-3 control-label">Carrera: </label>
												<div class="col-md-3">
												   	 <select name="carrera" id="carrera" class="form-control input-md">
												   	 	<option id="vacio3"></option>
												   	 	<option value=""></option>								   	 	
													<?php  
														$crud->sql= "SELECT id, carreras from carreras where carreras <> ''";
														$crud->leer();
														foreach ($crud->filas as $row) 
														{
															echo "<option value='$row[id]'>$row[carreras]</option>";
														}
													?>
												   	 </select>
												</div>
									</div>
									<div class="form-group" id="despliega" style="display:none;">
										<label class="checkbox-inline col-md-5 control-label"><input type="checkbox" name="otro_estudio" id="otro_estudio">Otros Datos de Estudio</label>
										<label class="checkbox-inline col-md-4 control-label" id="ocultar_estudio" style="display:none;"><input type="checkbox" name="ocultar_estudio1" id="ocultar_estudio1">Ocultar</label>
									</div>
									<div class="form-group" style="display:none" id="mensaje_oculto1">
											<div id="msjj3" class="label label-info" style="text-shadow:0 2px 2px rgba(0,0,0, .7)"><h4>Ya existe una Información de Estudios</h4></div>
									</div>
									<div class="form-group" id="carrera_oculto" style="display:none;">
										<label for="inputEmail3" class="col-md-3 control-label">Otra Institución: </label>
											<div class="col-md-3">
												<input type="text" name="otra_institucion" id="otra_institucion" class="form-control input-md" placeholder="Instituto">
											</div>
										<label for="inputEmail3" class="col-md-3 control-label">Otra Carrera: </label>
											<div class="col-md-3">
												<input type="text" name="otra_carrera" id="otra_carrera" class="form-control input-md" placeholder="Carrera">
											</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-md-3 control-label">Trabaja: </label>
										    <div class="col-md-3">
										       <label class="radio-inline"><input required type="radio" name="trabaja" id="trabaja" value="si">Si</label>
									      		<label class="radio-inline"><input type="radio" name="trabaja" id="trabaja" value="no">No</label>
										    </div>
									</div>
										<div class="form-group" id="c_trabajo" style="display:none;">
											<label for="inputEmail3" class="col-md-3 control-label">Sitio de trabajo: </label>
												<div class="col-md-3">
													<input type="text" name="s_trabajo" id="s_trabajo" class="form-control input-md">
												</div>
											<label for="inputEmail3" class="col-md-3 control-label">Sector laboral: </label>
												<div class="col-md-3">
												  <label class="checkbox-inline"><input type="checkbox" id="publico" name="publico" value="si">publico</label>
												  <label class="checkbox-inline"><input type="checkbox" id="privado" name="privado" value="si">privado</label>
												  <label class="checkbox-inline"><input type="checkbox" id="independiente" name="independiente" value="si">independiente</label>
												</div>
										</div>
									<label align="center" style="color: #AE0000;"><h1>Militancia en el Psuv y activación en organizaciones sociales</h1></label>

									<div class="form-group">
										<label for="inputEmail3" class="col-md-3 control-label">Tiempo de militancia en el Psuv: </label>
										    <div class="col-md-3">
										       <select name="militancia" id="militancia" class="form-control input-md">
										       <option></option>
										       <option></option>
										       		<?php $x=1;
										       		while($x <= 20){
										       			if($x == 1){?>
										       		<option><?php echo $x." "."año"; ?></option>
										       		<?php }else{?>
										       		<option><?php echo $x." "."años"; ?></option>
										       		<?php }
										       			$x++; ?>
										       		<?php } ?>
										       </select>
										    </div>
										<label for="inputEmail3" class="col-md-3 control-label">Tareas en el partido: </label>
											<div class="col-md-3">
												<label class="radio-inline"><input required type="radio" name="tareas" id="tareas" value="si">Si</label>
									      		<label class="radio-inline"><input type="radio" name="tareas" id="tareas" value="no">No</label>
											</div>
									</div>
									<div class="form-group" style="display:none;" id="tareas_permanentes">
									<label for="inputEmail3" class="col-md-3 control-label">Tareas permanentes en el Psuv: </label>
										<div class="col-md-9">
														<a href="#" data-toggle="tooltip" title="">
														<label class="checkbox-inline"><input type="checkbox" id="clp" name="clp" value="si">CLP</label></a>
													  	<a href="#" data-toggle="tooltip" title="">
													  	<label class="checkbox-inline"><input type="checkbox" id="ubcn" name="ubcn" value="si">UBCH</label></a>
													  	<a href="#" data-toggle="tooltip" title="">
													  	<label class="checkbox-inline"><input type="checkbox" id="congreso_patria" name="congreso_patria" value="si">Congreso Patría</label></a>
													  	<a href="#" data-toggle="tooltip" title="">
													  	<label class="checkbox-inline"><input type="checkbox" id="delegado_patria" name="delegado_patria" value="si">Delegado Patría</label></a>
													  	<a href="#" data-toggle="tooltip" title="Gran Polo Patriotico">
													  	<label class="checkbox-inline"><input type="checkbox" id="gpp" name="gpp" value="si">GPP</label></a>
													  	<a href="#" data-toggle="tooltip" title="Mision Sucre">
													  	<label class="checkbox-inline"><input type="checkbox" id="ms" name="ms" value="si">MS</label></a>
													  	<a href="#" data-toggle="tooltip" title="Misión Robinson">
													  	<label class="checkbox-inline"><input type="checkbox" id="mr" name="mr" value="si">MR</label></a>
													  	<a href="#" data-toggle="tooltip" title="Misión Rivas">
													  	<label class="checkbox-inline"><input type="checkbox" id="mri" name="mri" value="si">MRI</label></a>
													  	<a href="#" data-toggle="tooltip" title="Frente Francisco de Miranda">
													  	<label class="checkbox-inline"><input type="checkbox" id="ffm" name="ffm" value="si">FFM</label></a>
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-md-3 control-label">Pertenece a algun consejo comunal: </label>
											<div class="col-md-3">
												<label class="radio-inline"><input required type="radio" name="consejoc" id="consejoc" value="si">Si</label>
									      		<label class="radio-inline"><input type="radio" name="consejoc" id="consejoc" value="no">No</label>
											</div>

										<div id="c_comunal" style="display:none;">
											<label for="inputEmail3" class="col-md-3 control-label">Consejo Comunal: </label>
												<div class="col-md-3">
													<select name="n_consejo" id="n_consejo" class="form-control input-md">
														<option></option>
														<option></option>
														<option></option>	
														<?php
														$crud->sql = "SELECT id, consejocomunal FROM bene_sucre where consejocomunal <> ''" ;
														$crud->leer();
														foreach ($crud->filas as $row) 
														{
															echo "<option value='$row[id]'>$row[consejocomunal]</option>";
														} 
														?>
													</select>
												</div>
												
										</div>
									</div>
									<div class="form-group" id="c_comunal1" style="display: none">
											<label for="inputEmail3" class="col-md-9 control-label">Otro: </label>
											<div class="col-md-3">
												<input type="text" name="otro_consejo" id="otro_consejo" class="form-control input-sm" placeholder="Opcional">
											</div>
										</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-md-3 control-label">Pertenece a algun movimiento social: </label>
											<div class="col-md-3">
												<label class="radio-inline"><input required type="radio" name="movimiento_s" id="movimiento_s" value="si">Si</label>
									      		<label class="radio-inline"><input type="radio" name="movimiento_s" id="movimiento_s" value="no">No</label>

											</div>
											<div id="div_movimientos" style="display:none">	
												<label for="inputEmail3" class="col-md-3 control-label">Tareas permanentes en el movimiento social: </label>
												    <div class="col-md-3">
													    <label class="checkbox-inline"><input type="checkbox" id="viviendo_venezolanos" name="viviendo_venezolanos" value="si">Viviendo Venezolanos</label>
													  	<label class="checkbox-inline"><input type="checkbox" id="movimiento_campe" name="movimiento_campe" value="si">Movimiento Campesino</label>
													  	<label class="checkbox-inline"><input type="checkbox" id="movimiento_cultu" name="movimiento_cultu" value="si">Movimiento Cúltural</label>
												    </div>
											</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-md-3 control-label">Pertenece a algun colectivo: </label>
											<div class="col-md-3">
												<label class="radio-inline"><input type="radio" required name="colectivo" id="colectivo" value="si">Si</label>
									      		<label class="radio-inline"><input type="radio" name="colectivo" id="colectivo" value="no">No</label>
											</div>
											<div id="div_colectivo" style="display:none">	
												<label for="inputEmail3" class="col-md-3 control-label">Nombre Colectivo: </label>
												    <div class="col-md-3">
												       <input type="text" id="n_colectivo" name="n_colectivo">
												    </div>
											</div>
									</div>
									<div class="form-group text-center">
										<p id="aviso" class="label label-danger" style="font-size: 12px; font-weight: bold;"></p>
									</div>
			                    </div>
			                </div>
			                <div class="modal-footer">
			                    <button type="submit" class="add-project">Grabar</button>
			                    <button type="button" class="cancel" data-dismiss="modal">Cerrar</button>
			                </div>
			            </form>
			        </div>
			    </div>
			</div>
	<div id="modal_ver" class="modal fade" role="dialog">
			    <div class="modal-dialog" style="width: 70%">
			        <!-- Modal content-->
			        <div class="modal-content">
			            <div class="modal-header login-header">
			                <button type="button" class="close" data-dismiss="modal">×</button>
			                <h4 class="modal-title">Datos Generales</h4>
			            </div>
			            <form class="form-horizontal" id="" action="grabar_ubch.php" method="POST">
			                <input type="hidden" name="accion" value="agregar_conformante">
			                <input type="hidden" name="id_ubch_lider" value="<?php echo $id; ?>">
			                <div class="modal-body">
			                    <div class="row">
			                    	<label class="col-sm-3 control-label" for="nac_resp">Cédula de Indentidad:</label>
								    <div class="col-md-9">
								  		<div class="input-group">
						                    <div class="input-group-btn">
								                 <select class="form-control input-sm" id="nac_resp_ver" name="nac_resp_ver" style="width:55px">
													<option value="V" selected>V</option>
													<option value="E">E</option>
												</select>
						                    </div>
						                    <input type="number" id="ced_resp_ver" name="ced_resp_ver" required placeholder="Cédula" class="form-control input-sm"/>
						                </div>
						            </div>
			                        <div class="form-group">
									    <label for="inputEmail3" class="col-sm-3 control-label">Nombres y Apellidos: </label>
									    <div class="col-md-9">
									      <input type="text" required name="nom_resp_ver" id="nom_resp_ver" class="form-control input-md" >
									    </div>
									</div>
									<div class="form-group">
									<label for="inputEmail3" class="col-md-3 control-label">Genero: </label>
									<div class="col-md-3">
										<label class="radio-inline"><input required type="radio" name="genero_ver" id="genero_ver" value="masculino">Masculino</label>
									     <label class="radio-inline"><input type="radio" name="genero_ver" id="genero_ver" value="femenino">Femenino</label>
									</div>
									<label for="inputEmail3" class="col-md-3 control-label">Fecha de nacimiento: </label>
										<div class="col-md-3">
											 <input type="text" required required name="fecha_ver" id="fecha_ver"  class="form-control input-md" >
										</div>
									</div>
									<div class="form-group">
										
									</div>
									<div class="form-group">
									    <label for="inputEmail3" class="col-md-3 control-label">Telefono: </label>
									    <div class="col-md-3">
									      <input type="number" required name="tlf1_ver" id="tlf1_ver" placeholder="telefono" maxlength="11" class="form-control input-md" >
									    </div>
									</div>
									<div class="form-group">
								    <label for="inputEmail3" class="col-md-3 control-label">Sector: </label>
									    <div class="col-md-3">
											<select name="sector_ver" id="sector_ver" class="form-control input-md" required disabled="">
											<option value=""></option>
											<option id="vacio" value=""></option>
											<option value=""></option>
											<?php 
													$crud->sql = "SELECT DISTINCT sector FROM bene_sucre where sector <> ''";
													$crud->leer();
													foreach($crud->filas as $rs_sector){?>
												<option><?php echo $rs_sector["sector"]; ?></option>
												<?php } ?>
											</select>
									    </div>
									<label for="inputEmail3" class="col-md-3 control-label">Calle: </label>
									    <div class="col-md-3">
											<select name="calle_ver" id="calle_ver" class="form-control input-md" required disabled="">
											<option value=""></option>
											<option id="vacio1"></option>
											<option value=""></option>
											<?php 
													$crud->sql = "SELECT DISTINCT calle FROM bene_sucre where sector <> ''";
													$crud->leer();
													foreach($crud->filas as $rs_calle){?>
												<option><?php echo $rs_calle["calle"]; ?></option>
												<?php } ?>
											</select>
									    </div>
									</div>
									<div class="form-group" id="sector_oculto_ver">
										<label for="inputEmail3" class="col-md-3 control-label">Otro Sector: </label>
											<div class="col-md-3">
												<input type="text" name="otro_s_ver" id="otro_s_ver" class="form-control input-md" placeholder="">
											</div>
										<label for="inputEmail3" class="col-md-3 control-label">Otra Calle: </label>
											<div class="col-md-3">
												<input type="text" name="otra_c_ver" id="otra_c_ver" class="form-control input-md" placeholder="">
											</div>
									</div>
									<div class="form-group" id="geografia_ver"> <!--style="display:none;"-->
								    <label for="inputEmail3" class="col-md-2 control-label">Estado: </label>
									    <div class="col-md-2">
									      <select name="estado_ver" id="estado_ver" class="form-control input-md" disabled="">
									      		<?php
										   			$crud->sql = "SELECT id, estado from estados where id = $_SESSION[estado]";
										   			$crud->leer();
										   			foreach ($crud->filas as $row) 
										   			{
										   				echo "<option value='$row[id]'>$row[estado]</option>";
										   			}
										   		?>
									      </select>
									    </div>
									<label for="inputEmail3" class="col-md-2 control-label">Municipio: </label>
										<div class="col-md-2">
										   <select name="municipio_ver" id="municipio_ver" class="form-control input-md" disabled="">
										   		<?php
										   			$crud->sql = "SELECT id_municipio, municipio from municipios where id_municipio = $_SESSION[municipio] and id_estado = $_SESSION[estado]";
										   			$crud->leer();
										   			foreach ($crud->filas as $row) 
										   			{
										   				echo "<option value='$row[id_municipio]'>$row[municipio]</option>";
										   			}
										   		?>
									      </select>
										</div>
									<label for="inputEmail3" class="col-md-2 control-label">Parroquia: </label>
										<div class="col-md-2">
										   <select name="parroquia_ver" id="parroquia_ver" class="form-control input-md">
										   		<?php
										   			$crud->sql = "SELECT parroquia, id from parroquias where id_municipio = $_SESSION[municipio] and id_estado = $_SESSION[estado]";
										   			$crud->leer();
										   			foreach ($crud->filas as $row) 
										   			{
										   				echo "<option value='$row[id]'>$row[parroquia]</option>";
										   			}
										   		?>
									      </select>
										</div>
				                    </div>    
									<div class="form-group">
									    <label for="inputEmail3" class="col-md-3 control-label">Email: </label>
									    <div class="col-md-3">
									    	<div class="input-group">
									    		<span class="input-group-addon">@</span>
									      		<input type="email" name="email_ver" id="email_ver" class="form-control input-md">
									    	</div>
									    </div>
									<label for="inputEmail3" class="col-md-3 control-label">Twitter: </label>
										<div class="col-md-3">
											<div class="input-group">
									    		<span class="input-group-addon">@</span>
										   	<input type="text" name="twitter_ver" id="twitter_ver" class="form-control input-md">
										   </div>	
									    </div>
									</div>
										<label align="center" style="color: #AE0000;"><h1>Datos academicos y laborales</h1></label>
									<div class="form-group" id="mun"> <!--style="display:none;"-->
								    <label for="inputEmail3" class="col-md-3 control-label">Nivel de instrucción: </label><br>
								    	  <label class="radio-inline"><input required type="radio" name="titulo_ver" value="primaria">Primaria</label>
									      <label class="radio-inline"><input type="radio" name="titulo_ver" value="bachiller">Bachiller</label>
									      <label class="radio-inline"><input type="radio" name="titulo_ver" value="tsu">Tsu</label>
									      <label class="radio-inline"><input type="radio" name="titulo_ver" value="licenciado">Licenciado</label>
									      <label class="radio-inline"><input type="radio" name="titulo_ver" value="universitario">Universitario</label>
									      <label class="radio-inline"><input type="radio" name="titulo_ver" value="postgrado">Postgrado</label>
									</div>
									<div class="form-group">
										    <label for="inputEmail3" class="col-md-3 control-label">Profesión(titulo Obtenido): </label>
										    <div class="col-md-3">
										      <input type="text" required name="profesion_ver" id="profesion_ver" class="form-control input-md">
										    </div>
										    <label for="inputEmail3" class="col-md-3 control-label">Ocupación: </label>
										    <div class="col-md-3">
										      <input type="text" required name="ocupacion_ver" id="ocupacion_ver" class="form-control input-md">
										    </div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-md-3 control-label">Estudia: </label>
										    <div class="col-md-3">
										       <label class="radio-inline"><input required type="radio" name="estudia_ver" id="estudia_ver" value="si">Si</label>
									      		<label class="radio-inline"><input type="radio" name="estudia_ver" id="estudia_ver" value="no">No</label>
										    </div>
									</div>
									<div class="form-group" id="c_estudios_ver" style="display:none;">
											<label for="inputEmail3" class="col-md-3 control-label">Institución: </label>
												<div class="col-md-3">
												   	 <select name="institucion_ver" id="institucion_ver" class="form-control input-md">
												   	 	<option id="vacio2"></option>
												   	 	<option ></option>								   	 	
														<?php  
															$crud->sql = "SELECT id, universidad from carreras where universidad <> ''";
															$crud->leer();
															foreach ($crud->filas as $row) 
															{
																echo "<option value='$row[id]'>$row[universidad]</option>";
															}
														?>
												   	 </select>
												</div>
											<label for="inputEmail3" class="col-md-3 control-label">Carrera: </label>
												<div class="col-md-3">
												   	 <select name="carrera_ver" id="carrera_ver" class="form-control input-md">
												   	 	<option id="vacio3"></option>
												   	 	<option value=""></option>								   	 	
													<?php  
														$crud->sql= "SELECT id, carreras from carreras where carreras <> ''";
														$crud->leer();
														foreach ($crud->filas as $row) 
														{
															echo "<option value='$row[id]'>$row[carreras]</option>";
														}
													?>
												   	 </select>
												</div>
									</div>
									<div class="form-group" id="despliega" style="display:none;">
										<label class="checkbox-inline col-md-5 control-label"><input type="checkbox" name="otro_estudio_ver" id="otro_estudio_ver">Otros Datos de Estudio</label>
										<label class="checkbox-inline col-md-4 control-label" id="ocultar_estudio_ver" style="display:none;"><input type="checkbox" name="ocultar_estudio1" id="ocultar_estudio1_ver">Ocultar</label>
									</div>
									<div class="form-group" style="display:none" id="mensaje_oculto1">
											<div id="msjj3" class="label label-info" style="text-shadow:0 2px 2px rgba(0,0,0, .7)"><h4>Ya existe una Información de Estudios</h4></div>
									</div>
									<div class="form-group" id="carrera_oculto_ver" style="display:none;">
										<label for="inputEmail3" class="col-md-3 control-label">Otra Institución: </label>
											<div class="col-md-3">
												<input type="text" name="otra_institucion_ver" id="otra_institucion_ver" class="form-control input-md" placeholder="Instituto">
											</div>
										<label for="inputEmail3" class="col-md-3 control-label">Otra Carrera: </label>
											<div class="col-md-3">
												<input type="text" name="otra_carrera_ver" id="otra_carrera_ver" class="form-control input-md" placeholder="Carrera">
											</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-md-3 control-label">Trabaja: </label>
										    <div class="col-md-3">
										       <label class="radio-inline"><input required type="radio" name="trabaja_ver" id="trabaja_ver" value="si">Si</label>
									      		<label class="radio-inline"><input type="radio" name="trabaja_ver" id="trabaja_ver" value="no">No</label>
										    </div>
									</div>
										<div class="form-group" id="c_trabajo_ver" style="display:none;">
											<label for="inputEmail3" class="col-md-3 control-label">Sitio de trabajo: </label>
												<div class="col-md-3">
													<input type="text" name="s_trabajo_ver" id="s_trabajo_ver" class="form-control input-md">
												</div>
											<label for="inputEmail3" class="col-md-3 control-label">Sector laboral: </label>
												<div class="col-md-3">
												  <label class="checkbox-inline"><input type="checkbox" id="publico_ver" name="publico" value="si">publico</label>
												  <label class="checkbox-inline"><input type="checkbox" id="privado_ver" name="privado" value="si">privado</label>
												  <label class="checkbox-inline"><input type="checkbox" id="independiente_ver" name="independiente" value="si">independiente</label>
												</div>
										</div>
									<label align="center" style="color: #AE0000;"><h1>Militancia en el Psuv y activación en organizaciones sociales</h1></label>

									<div class="form-group">
										<label for="inputEmail3" class="col-md-3 control-label">Tiempo de militancia en el Psuv: </label>
										    <div class="col-md-3">
										       <select name="militancia_ver" id="militancia_ver" class="form-control input-md">
										       <option></option>
										       <option></option>
										       		<?php $x=1;
										       		while($x <= 20){
										       			if($x == 1){?>
										       		<option><?php echo $x." "."año"; ?></option>
										       		<?php }else{?>
										       		<option><?php echo $x." "."años"; ?></option>
										       		<?php }
										       			$x++; ?>
										       		<?php } ?>
										       </select>
										    </div>
										<label for="inputEmail3" class="col-md-3 control-label">Tareas en el partido: </label>
											<div class="col-md-3">
												<label class="radio-inline"><input required type="radio" name="tareas_ver" id="tareas_ver" value="si">Si</label>
									      		<label class="radio-inline"><input type="radio" name="tareas_ver" id="tareas_ver" value="no">No</label>
											</div>
									</div>
									<div class="form-group" style="display:none;" id="tareas_permanentes_ver">
									<label for="inputEmail3" class="col-md-3 control-label">Tareas permanentes en el Psuv: </label>
										<div class="col-md-9">
														<a href="#" data-toggle="tooltip" title="">
														<label class="checkbox-inline"><input type="checkbox" id="clp_ver" name="clp" value="si">CLP</label></a>
													  	<a href="#" data-toggle="tooltip" title="">
													  	<label class="checkbox-inline"><input type="checkbox" id="ubcn_ver" name="ubcn" value="si">UBCH</label></a>
													  	<a href="#" data-toggle="tooltip" title="">
													  	<label class="checkbox-inline"><input type="checkbox" id="congreso_patria_ver" name="congreso_patria" value="si">Congreso Patría</label></a>
													  	<a href="#" data-toggle="tooltip" title="">
													  	<label class="checkbox-inline"><input type="checkbox" id="delegado_patria_ver" name="delegado_patria" value="si">Delegado Patría</label></a>
													  	<a href="#" data-toggle="tooltip" title="Gran Polo Patriotico">
													  	<label class="checkbox-inline"><input type="checkbox" id="gpp_ver" name="gpp" value="si">GPP</label></a>
													  	<a href="#" data-toggle="tooltip" title="Mision Sucre">
													  	<label class="checkbox-inline"><input type="checkbox" id="ms_ver" name="ms" value="si">MS</label></a>
													  	<a href="#" data-toggle="tooltip" title="Misión Robinson">
													  	<label class="checkbox-inline"><input type="checkbox" id="mr_ver" name="mr" value="si">MR</label></a>
													  	<a href="#" data-toggle="tooltip" title="Misión Rivas">
													  	<label class="checkbox-inline"><input type="checkbox" id="mri_ver" name="mri" value="si">MRI</label></a>
													  	<a href="#" data-toggle="tooltip" title="Frente Francisco de Miranda">
													  	<label class="checkbox-inline"><input type="checkbox" id="ffm_ver" name="ffm" value="si">FFM</label></a>
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-md-3 control-label">Pertenece a algun consejo comunal: </label>
											<div class="col-md-3">
												<label class="radio-inline"><input required type="radio" name="consejoc_ver" id="consejoc_ver" value="si">Si</label>
									      		<label class="radio-inline"><input type="radio" name="consejoc_ver" id="consejoc_ver" value="no">No</label>
											</div>

										<div id="c_comunal_ver" style="display:none;">
											<label for="inputEmail3" class="col-md-3 control-label">Consejo Comunal: </label>
												<div class="col-md-3">
													<select name="n_consejo_ver" id="n_consejo_ver" class="form-control input-md">
														<option></option>
														<option></option>
														<option></option>	
														<?php
														$crud->sql = "SELECT id, consejocomunal FROM bene_sucre where consejocomunal <> ''" ;
														$crud->leer();
														foreach ($crud->filas as $row) 
														{
															echo "<option value='$row[id]'>$row[consejocomunal]</option>";
														} 
														?>
													</select>
												</div>
												
										</div>
									</div>
									<div class="form-group" id="c_comunal1_ver" style="display: none">
											<label for="inputEmail3" class="col-md-9 control-label">Otro: </label>
											<div class="col-md-3">
												<input type="text" name="otro_consejo_ver" id="otro_consejo_ver" class="form-control input-sm" placeholder="Opcional">
											</div>
										</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-md-3 control-label">Pertenece a algun movimiento social: </label>
											<div class="col-md-3">
												<label class="radio-inline"><input required type="radio" name="movimiento_s_ver" id="movimiento_s_ver" value="si">Si</label>
									      		<label class="radio-inline"><input type="radio" name="movimiento_s_ver" id="movimiento_s_ver" value="no">No</label>

											</div>
											<div id="div_movimientos_ver" style="display:none">	
												<label for="inputEmail3" class="col-md-3 control-label">Tareas permanentes en el movimiento social: </label>
												    <div class="col-md-3">
													    <label class="checkbox-inline"><input type="checkbox" id="viviendo_venezolanos_ver" name="viviendo_venezolanos" value="si">Viviendo Venezolanos</label>
													  	<label class="checkbox-inline"><input type="checkbox" id="movimiento_campe_ver" name="movimiento_campe" value="si">Movimiento Campesino</label>
													  	<label class="checkbox-inline"><input type="checkbox" id="movimiento_cultu_ver" name="movimiento_cultu" value="si">Movimiento Cúltural</label>
												    </div>
											</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-md-3 control-label">Pertenece a algun colectivo: </label>
											<div class="col-md-3">
												<label class="radio-inline"><input type="radio" required name="colectivo" id="colectivo_ver" value="si">Si</label>
									      		<label class="radio-inline"><input type="radio" name="colectivo" id="colectivo_ver" value="no">No</label>
											</div>
											<div id="div_colectivo_ver" style="display:none">	
												<label for="inputEmail3" class="col-md-3 control-label">Nombre Colectivo: </label>
												    <div class="col-md-3">
												       <input type="text" id="n_colectivo_ver" name="n_colectivo">
												    </div>
											</div>
									</div>
			                    </div>
			                </div>
			            </form>
			        </div>
			    </div>
			</div>
</div>

<?php
	require_once "footer.php";
?>
<script src="js/select2.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$(function(){

		$(".eliminar").click(function(){
			var agree = confirm('Desea realmente eliminar este registro?');

			if(agree)
			{
				return true;	
			}
			else
			{
				return false;
			}
		})

		$('#sector').select2();
		$('#calle').select2();
		$('#carrera').select2();
		$('#n_consejo').select2();
		$('#parroquia').select2();
		$('#centro_v').select2();
		$('#institucion').select2();

		$("#estudia[value='si']").click(function(){

    		$('#c_estudios').show('slow/2000/fast');
    		$("#despliega").show('slow/2000/fast');
    		$("#institucion").attr("required",true);
    		$("#carrera").attr("required",true);

    });

    $("#estudia[value='no']").click(function(){

    		$('#c_estudios').hide('slow/2000/fast');
    		$('#despliega').hide('slow/2000/fast');
    		$("#institucion").attr("required",false);
    		$("#carrera").attr("required",false);

    });

     $("#trabaja[value='si']").click(function(){

    		$('#c_trabajo').show('slow/2000/fast');
    		$("#s_trabajo").attr("required",true);

    });


     $("#trabaja[value='no']").click(function(){

    		$('#c_trabajo').hide('slow/2000/fast');
    		$("#s_trabajo").attr("required",false);

    });

    $("#tareas[value='si']").click(function(){

    		$('#tareas_permanentes').show('slow/2000/fast');
    		$("#tareas_p").attr("required",true);

    });


     $("#tareas[value='no']").click(function(){

    		$('#tareas_permanentes').hide('slow/2000/fast');
    		$("#tareas_p").attr("required",false);

    });


    $("#movimiento_s[value='si']").click(function(){

    		$('#div_movimientos').show('slow/2000/fast');
    		$("#tp_movimiento_s").attr("required",true);

    });


     $("#movimiento_s[value='no']").click(function(){

    		$('#div_movimientos').hide('slow/2000/fast');
    		$("#tp_movimiento_s").attr("required",false);

    });

    $("#colectivo[value='si']").click(function(){

    		$('#div_colectivo').show('slow/2000/fast');
    		$("#n_colectivo").attr("required",true);

    });

     $("#colectivo[value='no']").click(function(){

    		$('#div_colectivo').hide('slow/2000/fast');
    		$("#n_colectivo").attr("required",false);

    });

    $("#consejoc[value='si']").click(function(){

    		$('#c_comunal').show('slow/2000/fast')
    		$('#c_comunal1').show('slow/2000/fast');
    		$("#n_consejo").attr("required",true);

    });

      $("#consejoc[value='no']").click(function(){

    		$('#c_comunal').hide('slow/2000/fast');
    		$('#c_comunal1').hide('slow/2000/fast')
    		$("#n_consejo").attr("required",false);

    });
//------------despliego los campos de los sectores ocultos----//
      	$("#otro_sector").click(function(){

		    if($('#sector').val() == "" && $('#calle').val() == ""){

		      	$("#sector_oculto").show('slow/400/fast');
		      	$("#otro_s").attr("required", true);
		      	$("#otra_c").attr("required", true);
		      	$('#sector').children('option[id="vacio"]').prop('selected', 'selected').change();
		      	$('#calle').children('option[id="vacio1"]').prop('selected', 'selected').change();
		      	$('#sector').attr("disabled", true);
		        $('#calle').attr("disabled", true);
		        $('#check_escondido').show('slow/400/fast');
		        $('#sector').attr("required", false);
		        $('#calle').attr("required", false);
		        $("#otra_c").attr("disabled", false);
		        $("#otro_s").attr("disabled", false);

		    }else if($('#sector').val() == "" && $('#calle').val() != ""){

		    	$("#sector_oculto").show('slow/400/fast');
		      	$("#otro_s").attr("required", true);
		      	$("#otro_s").attr("disabled", false);
		      	$("#otra_c").attr("disabled", true);
		      	$('#sector').attr("disabled", true);
		      	$('#sector').children('option[id="vacio"]').prop('selected', 'selected').change();
		        $('#check_escondido').show('slow/400/fast');
		        $('#sector').attr("required", false);

		    } else if($('#sector').val() != "" && $('#calle').val() == ""){

		    	$("#sector_oculto").show('slow/400/fast');
		      	$("#otro_s").attr("disabled", true);
		      	$("#otra_c").attr("required", true);
		      	$("#otra_c").attr("disabled", false);
		      	$('#calle').children('option[id="vacio1"]').prop('selected', 'selected').change();
		      	$('#calle').attr("disabled", true);
		        $('#check_escondido').show('slow/400/fast');
		        $('#calle').attr("required", false);
		    }else{

		    	$("#mensaje_oculto").show('slow/400/fast');
		    	$("#mensaje_oculto").hide(3000);
		    	$("#otro_sector").attr("checked", false);
		    }
	    });

	      	$("#check_oculto").click(function(event) {
	      		$("#sector_oculto").hide('slow/400/fast');
	      		$('#sector').attr("disabled", false);
	        	$('#calle').attr("disabled", false);
	        	$("#otro_s").attr("required", false);
	      		$("#otra_c").attr("required", false);
	      		$("#otro_s").attr("disabled", true);
	      		$("#otra_c").attr("disabled", true);
	      		$("#otro_sector").attr("checked", false);
	      		$("#check_oculto").attr("checked", false);
	      		$("#check_escondido").hide('slow/400/fast');
	      	});
      

//----------------------------------------------------

//-------------------Campos de estudios Opcionales ------------

$("#otro_estudio").click(function(){
$("#ocultar_estudio1").prop("checked",false);
	if($('#institucion').val() == "" && $('#carrera').val() == ""){

		$("#carrera_oculto").show('slow/400/fast');
      	$("#otra_institucion").attr("required", true);
      	$("#otra_carrera").attr("required", true);
      	$("#otra_institucion").attr("disabled", false);
      	$("#otra_carrera").attr("disabled", false);
      	$('#institucion').attr("disabled", true);
        $('#carrera').attr("disabled", true);
        $('#ocultar_estudio').show('slow/400/fast');
        $('#institucion').attr("required", false);
        $('#carrera').attr("required", false);

		}else if($('#institucion').val() == "" && $('#carrera').val() != ""){

				$("#carrera_oculto").show('slow/400/fast');
		      	$("#otra_institucion").attr("required", true);
		      	$("#otra_carrera").attr("disabled", true);
		        $('#ocultar_estudio').show('slow/400/fast');
		        $('#institucion').attr("required", false);
		        $('#institucion').attr("disabled", true);
		        $("#otra_institucion").attr("disabled", false);

		}else if($('#institucion').val() != "" && $('#carrera').val() == ""){

				$("#carrera_oculto").show('slow/400/fast');
		      	$("#otra_institucion").attr("disabled", true);
		      	$("#otra_carrera").attr("required", true);
		        $('#ocultar_estudio').show('slow/400/fast');
		        $('#carrera').attr("required", false);
		        $('#carrera').attr("disabled", true);
		      	$("#otra_carrera").attr("disabled", false);

		}else{

				$("#mensaje_oculto1").show('slow/400/fast');
		    	$("#mensaje_oculto1").hide(3000);
		    	$("#otro_estudio").attr("checked", false);
		}

	});
//---------check para ocultar los campos-----------------
		$('#ocultar_estudio').click(function(event) {
			$("#carrera_oculto").hide('slow/400/fast');
      		$('#institucion').attr("disabled", false);
        	$('#carrera').attr("disabled", false);
      		$("#otra_institucion").attr("disabled", true);
      		$("#otra_carrera").attr("disabled", true);
      		$("#otro_estudio").attr("checked", false);
      		$("#ocultar_estudio").hide('slow/400/fast');
	
		});

//-------------------------------------------------------------
//----------------------------------------------

     $("#colectivo[value='no']").click(function(){

    		$('#div_colectivo').hide('slow/2000/fast');
    		$("#n_colectivo").attr("required",false);

    });

     $("#n_consejo").change(function(event) {
     	if($(this).val() != "" ){
     		$("#otro_consejo").attr({
     			required: false,
     			disabled: true
     		});
     		
     	}else{	
     	
     		$("#otro_consejo").attr({
     			required: true,
     			disabled: false
     		});	
     	}
     });

     $("#otro_consejo").blur(function(event) {
     	if($(this).val() != "" ){
     		$("#n_consejo").attr({
     			required: false,
     			disabled: true
     		});
     		
     	}else{	
     	
     		$("#n_consejo").attr({
     			required: true,
     			disabled: false
     		});	
     	}
     });
    
     $("#tareas_permanentes").children("div.col-md-9").children("a[data-toggle='tooltip']").children("label.checkbox-inline").mouseover(function(event) {
     	$(this).parent("a[data-toggle='tooltip']").tooltip();
     });
     
     	
    $('#fecha').datepicker({ 
    	format : "dd-mm-yyyy"
    }).on('changeDate', function(e){
    $(this).datepicker('hide');
	});

	$("#agregar_modal").on('hidden.bs.modal', function(){
		$("#form_estructura")[0].reset();
	});	

	//----------------------------modal ver---------------------------------------


	$("#modal_ver").on('show.bs.modal', function(e){
		var x = $(e.relatedTarget).data().cedula;
				$(e.currentTarget).find("#ced_resp_ver").val(x);
		var x = $(e.relatedTarget).data().nac;
				$(e.currentTarget).find("#nac_resp_ver").val(x).prop('selected', true);
		var x = $(e.relatedTarget).data().nombre;
				$(e.currentTarget).find("#nom_resp_ver").val(x);
		var x = $(e.relatedTarget).data().genero;
				$(e.currentTarget).find("#genero_ver[value='"+x+"']").prop('checked', true);
		var x = $(e.relatedTarget).data().fecha_nac;
				$(e.currentTarget).find("#fecha_ver").val(x);
		var x = $(e.relatedTarget).data().telefono;
				$(e.currentTarget).find("#tlf1_ver").val(x);
		var x = $(e.relatedTarget).data().sector;
				$(e.currentTarget).find("#otro_s_ver").val(x);
		var x = $(e.relatedTarget).data().calle;
				$(e.currentTarget).find("#otra_c_ver").val(x);
		var x = $(e.relatedTarget).data().parroquia;
				$(e.currentTarget).find("#parroquia_ver").val(x).prop('selected', true);
		var x = $(e.relatedTarget).data().email;
				$(e.currentTarget).find("#email_ver").val(x);
		var x = $(e.relatedTarget).data().twitter;
				$(e.currentTarget).find("#twitter_ver").val(x);
		var x = $(e.relatedTarget).data().nivel;
				$(e.currentTarget).find("input[name='titulo_ver'][value='"+x+"']").prop('checked', true);
		var x = $(e.relatedTarget).data().profesion;
				$(e.currentTarget).find("#profesion_ver").val(x);
		var x = $(e.relatedTarget).data().ocupacion;
				$(e.currentTarget).find("#ocupacion_ver").val(x);
		var x = $(e.relatedTarget).data().estudia;
			if(x == "si")
			{
				$(e.currentTarget).find("#estudia_ver[value='"+x+"']").prop('checked', true);
				$("#c_estudios").show('slow/400/fast');
				var x = $(e.relatedTarget).data().institucion;
					if(isNaN(x))
					{		
						$("#carrera_oculto_ver").show('slow/400/fast');
						$("#otra_institucion_ver").val(x);	
					}
					else
					{
						$("#c_estudios_ver").show('slow/400/fast');
						$(e.currentTarget).find("#institucion_ver").val(x).prop('selected', true).prop('readonly', true);
					}
				var x = $(e.relatedTarget).data().carrera;
					if(isNaN(x))
					{		
						
						$("#carrera_oculto_ver").show('slow/400/fast');
						$("#otra_carrera_ver").val(x);
					}
					else
					{
						$("#c_estudios_ver").show('slow/400/fast');
						$(e.currentTarget).find("#carrera_ver").val(x).prop('selected', true).prop('readonly', true);
					}
			}
			else
			{
				$(e.currentTarget).find("#estudia_ver[value='"+x+"']").prop('checked', true);	
			}
			var x = $(e.relatedTarget).data().trabaja;
				if(x == "si")
				{
					$(e.currentTarget).find("#trabaja_ver[value='"+x+"']").prop('checked', true);
					$("#c_trabajo_ver").show('show/400/fast');
					var x = $(e.relatedTarget).data().sitio;
							$(e.currentTarget).find("#s_trabajo_ver").val(x);
					var x = $(e.relatedTarget).data().publico;
							$(e.currentTarget).find("#publico_ver[value='"+x+"']").prop('checked', true);
					var x = $(e.relatedTarget).data().privado;
							$(e.currentTarget).find("#privado_ver[value='"+x+"']").prop('checked', true);
					var x = $(e.relatedTarget).data().independiente;
							$(e.currentTarget).find("#independiente_ver[value='"+x+"']").prop('checked', true);
				}
				else
				{
					$(e.currentTarget).find("#trabaja_ver[value='"+x+"']").prop('checked', true);
				}
			var x = $(e.relatedTarget).data().tiempo;
					$(e.currentTarget).find("#militancia_ver").val(x).prop('selected', true);
			var x = $(e.relatedTarget).data().tareas_partido;
				if(x == "si")
				{
					$(e.currentTarget).find("#tareas_ver").val(x).prop('checked', true);
					$("#tareas_permanentes_ver").show('slow/400/fast');
					var x = $(e.relatedTarget).data().clp;
							$(e.currentTarget).find("#clp_ver[value='"+x+"']").prop('checked', true);
					var x = $(e.relatedTarget).data().ubch;
							$(e.currentTarget).find("#ubcn_ver[value='"+x+"']").prop('checked', true);
					var x = $(e.relatedTarget).data().congreso;
							$(e.currentTarget).find("#congreso_patria_ver[value='"+x+"']").prop('checked', true);
					var x = $(e.relatedTarget).data().delegado;
							$(e.currentTarget).find("#delegado_patria_ver[value='"+x+"']").prop('checked', true);
					var x = $(e.relatedTarget).data().gpp;
							$(e.currentTarget).find("#gpp_ver[value='"+x+"']").prop('checked', true);
					var x = $(e.relatedTarget).data().ms;
							$(e.currentTarget).find("#ms_ver[value='"+x+"']").prop('checked', true);
					var x = $(e.relatedTarget).data().mr;
							$(e.currentTarget).find("#mr_ver[value='"+x+"']").prop('checked', true);
					var x = $(e.relatedTarget).data().mri;
							$(e.currentTarget).find("#mri_ver[value='"+x+"']").prop('checked', true);
					var x = $(e.relatedTarget).data().ffm;
							$(e.currentTarget).find("#ffm_ver[value='"+x+"']").prop('checked', true);
				}
				else
				{
					$(e.currentTarget).find("#tareas_ver").val(x).prop('checked', true);
				}
			var x = $(e.relatedTarget).data().consejo;
				if(x == "si")
				{
					$(e.currentTarget).find("#consejoc_ver[value='"+x+"']").prop('checked', true);
					$("#c_comunal_ver").show('show/400/fast');
					var x = $(e.relatedTarget).data().n_consejo;
						if(isNaN(x))
						{
							$("#c_comunal1_ver").show('slow/400/fast');
							$("#otro_consejo_ver").val(x);
						}
						else
						{
							$("#n_consejo_ver").val(x).prop('selected', true);
						}
				}
				else
				{
					$(e.currentTarget).find("#consejoc_ver[value='"+x+"']").prop('checked', true);
				}
			var x = $(e.relatedTarget).data().movimientos;
				if(x == "si")
				{
					$(e.currentTarget).find("#movimiento_s_ver[value='"+x+"']").prop('checked', true);	
					$("#div_movimientos_ver").show('show/400/fast');
					var x = $(e.relatedTarget).data().viviendo;
							$(e.currentTarget).find("#viviendo_venezolanos_ver[value='"+x+"']").prop('checked', true);
					var x = $(e.relatedTarget).data().movimiento_campe;
							$(e.currentTarget).find("#movimiento_campe_ver[value='"+x+"']").prop('checked', true);
					var x = $(e.relatedTarget).data().movimiento_cultu;
							$(e.currentTarget).find("#movimiento_cultu_ver[value='"+x+"']").prop('checked', true);
				}
				else
				{
					$(e.currentTarget).find("#movimiento_s_ver[value='"+x+"']").prop('checked', true);
				}
			var x = $(e.relatedTarget).data().colectivo;
				if(x == "si")
				{
					$(e.currentTarget).find("#colectivo_ver[value='"+x+"']").prop('checked', true);	
					$("#div_colectivo_ver").show('slow/400/fast');
					var x = $(e.relatedTarget).data().n_colectivo;
							$(e.currentTarget).find("#n_colectivo_ver").val(x);

				}
				else
				{
					$(e.currentTarget).find("#colectivo_ver[value='"+x+"']").prop('checked', true);	
				}

			

	});
	//--------------------------------------------------------------------------------------


		
		$("#form_estructura").submit(function(){

			//validaciones antes de hacer submit-------------------------

			$("#estado").attr("disabled",false);
			$("#municipio").attr("disabled",false);
			var ced = $('#ced_resp').val();
			var pas = $('#pass').val();
			$("#nac_resp").attr("disabled", false);


			if($("#fecha").val()=="")
			{
				alert("Debe indicar la fecha de nacimiento");
				$("#fecha").focus();

				return false;
			}

			if($("#sector").attr("disabled")){}
			else
			{
				if($("#sector").val()=="")
				{
				alert("Debe indicar un sector de ubicación");
				$("#sector").focus();

				return false;
				}
			}

			if($("#calle").attr("disabled")){}
			else
			{
				if($("#calle").val()=="")
				{
				alert("Debe indicar un calle de ubicación");
				$("#calle").focus();

				return false;
				}
			}

			if($("#estudia[value='si']").prop('checked')){

				if($("#institucion").prop("disabled") != true)
				{
					if($("#institucion").val()=="")
					{
					alert("Debe indicar un institucion de estudio");
					$("#institucion").focus();

					return false;
					}
				}


				if($("#carrera").prop("disabled") != true)
				{
					if($("#carrera").val() == "")
					{
						alert("debe indicar una carrera de estudio");
						$("#carrera").focus();
						return false;
					}
					
				}
			}
			//----------fin de las validaciones-----------------------------------
			$.ajax({
					url: $(this).attr('action'),
					type: "POST",
					data: $(this).serialize(),
					dataType: "JSON",
					success: function(data)
					{
						if(typeof(data.exitoso) != "undefined")
						{	
							swal({
							title: "Integrante Agregado",
							type: "success",
							showButtonCancel: false,
							confirmButtonText: "Listo",
							confirmButtonClass: "btn btn-info",
							closeOnConfirm: true
							},function(confirm){
								if(confirm)
								{
                                    $("#form_estructura").keypress(function(e){
                                        if(e.keyCode == 13)
                                        {
                                            return false;
                                        }
                                    });
									window.location.reload();
								}
							});
						}
						else
						{
							$("#aviso").html('');
							$("#aviso").html(data.registrado);
						}
					}
			});
			return false;
		});
	});
</script>