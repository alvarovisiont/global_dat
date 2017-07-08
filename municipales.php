<?php
	require_once "encabezado.php";
    $municipio = $_SESSION['municipio'];
?>

<div class="row">
	<div class="container-fluid">
		<div class="col-md-12">
			<table class="table table-bordered table-hover table-condensed" id="tabla">
				<thead>
					<th>USUARIO</th>
					<th>CATEGORÍA</th>
					<th>PARROQUÍA</th>
                    <th>UBCH</th>
                    <th>CONCEJOS</th>
                    <th>MISIÓN</th>
                    <th>INSTITUCIÓN</th>
                    <th>MOVIMIENTOS</th>
                    <th>CLAP</th>
                    <th>JUVENT</th>
                    <th>OTROS</th>
                    <th>Acción</th>
				</thead>
				<tbody style="text-align:center;">
					<?php
                        $crud->sql = "SELECT usuarios.id, usuario, consejo_comunal, institucion, movimiento_social, mision,id_parroquia, categoria, juventud, otros,
                                        permisos, ubch, id_clap, nombre, apellido, cedula, telefono, direccion, responsables.id as id_responsable,
                                        (SELECT nombre from categoria where id = usuarios.categoria) as categoria1,
                                        (SELECT descripcion from centro_v where id_centro = usuarios.ubch) as descripcion,
										(SELECT parroquia from parroquias where id = usuarios.id_parroquia) as parroquia
										FROM usuarios 
                                        INNER JOIN responsables ON usuarios.id = responsables.id_usuario
                                        WHERE id_municipio = $municipio and usuarios.nivel = 3
                                        ";
						$crud->leer();
						$total = count($crud->filas);
						if($total > 0)
						{
							foreach ($crud->filas as  $row) 
							{
                                $comunidad = "";
                                $codigo = "";
                                if($row['id_clap'] != null)
                                {
                                    $crud->sql = "SELECT comunidad, ape_usu from reg_usuarios where id_usu = $row[id_clap]";
                                    $crud->leer1();
                                    $comunidad = $crud->filas1[0]['comunidad'];
                                    $codigo    = $crud->filas1[0]['ape_usu'];
                                }
							?>
								<tr>
									<td><?php echo $row['usuario']; ?></td>
									<td><?php echo "<strong>".$row['categoria1']."</strong>"; ?></td>
									<td><?php echo $row['parroquia']; ?></td>
                                    <td><?php echo $row['descripcion']; ?></td>
                                    <td><?php echo $row['consejo_comunal']; ?></td>
                                    <td><?php echo $row['mision']; ?></td>
                                    <td><?php echo $row['institucion']; ?></td>
                                    <td><?php echo $row['movimiento_social']; ?></td>
                                    <td><?php echo $comunidad."<br>".$codigo; ?></td>
                                    <td><?php echo $row['juventud']; ?></td>
                                    <td><?php echo $row['otros']; ?></td>
                                    <td>
                                    <button class="btn btn-success btn-xs" title="Modificar" data-toggle="modal" data-target="#modificar_cuenta" data-backdrop="static"
                                    data-id_modi= "<?php echo $row['id']; ?>"
                                    data-parro_modi = "<?php echo $row['id_parroquia']; ?>"
                                    data-categoria_modi = "<?php echo $row['categoria']; ?>"
                                    data-permisos_modi = "<?php echo $row['permisos']; ?>"
                                    data-ubch_modi = "<?php echo $row['ubch']; ?>"
                                    data-concejo_modi = "<?php echo $row['consejo_comunal']; ?>"
                                    data-mision_modi = "<?php echo $row['mision']; ?>"
                                    data-institucion_modi = "<?php echo $row['institucion']; ?>"
                                    data-movimiento_modi = "<?php echo $row['movimiento_social']; ?>"
                                    data-juventud_modi = "<?php echo $row['juventud']; ?>"
                                    data-otros_modi = "<?php echo $row['otros']; ?>"
                                    data-clap_modi = "<?php echo $row['id_clap']; ?>"
                                    data-nombre_modi = "<?php echo $row['nombre']; ?>"
                                    data-apellido_modi = "<?php echo $row['apellido']; ?>"
                                    data-cedula_modi = "<?php echo $row['cedula']; ?>"
                                    data-telefono_modi = "<?php echo $row['telefono']; ?>"
                                    data-direccion_modi = "<?php echo $row['direccion']; ?>"
                                    data-id_responsable = "<?php echo $row['id_responsable']; ?>"
                                    >
                                    <span class="glyphicon glyphicon-edit"></span>
                                    </button>
                                        <button class="btn btn-danger btn-xs eliminar" title="Eliminar" data-eliminar="<?php echo $row['id']; ?> "><span class="glyphicon glyphicon-trash"></span></button>
                                    </td>
								</tr>
							<?php	
							}
						}
						else
						{
						?>
							<tr>
								<td colspan=""></td>
                                <td colspan=""></td>
                                <td colspan=""></td>
                                <td colspan=""></td>
                                <td colspan=""></td>
                                <td colspan=""></td>
                                <td colspan=""></td>
                                <td colspan=""></td>
                                <td colspan=""></td>
                                <td colspan=""></td>
                                <td colspan=""></td>
                                <td colspan=""></td>
							</tr>
						<?php
						}

					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div id="agregar_locales" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header login-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Agregar Cuenta</h4>
                </div>
                 <form class="form-horizontal" id="form-agregar" action="grabar_locales.php" method="POST">
                 <input type="hidden" name="accion" value="locales_agregar">
                    <div class="modal-body">
                   		<div class="row">
                            <div class="form-group">
                            	<div class="col-md-6">
                            		<select name="estado" id="estado" readonly="">
                            			<?php
                            				$crud->sql = "SELECT id , estado from estados where id = $_SESSION[estado]";
                            				$crud->leer();
                            				foreach ($crud->filas as $value) 
                            				{
                            					?>

                            						<option value='<?php echo $value["id"]; ?>' selected=""><?php echo $value["estado"]; ?></option>
                            			<?php
                            				}
                            			?>?>
                            		</select>
                            	</div>
                            	<div class="col-md-6">
                            		<select name="municipio" id="municipio" class="form-control">
                            			<?php
                            				$crud->sql = "SELECT id_municipio , municipio from municipios where id_estado = $_SESSION[estado] and id_municipio = $municipio";
                            				$crud->leer();
                            				foreach ($crud->filas as $value) 
                            				{
                            				?>
                            					<option value='<?php echo $value["id_municipio"]; ?>'><?php echo utf8_encode($value["municipio"]); ?></option>
                            			<?php
                            				}
                            				?>
                            		</select>
                            	</div>
                            </div>
                            <div class="form-group">
                            	<div class="col-md-6">
                            		<select name="parroquia" id="parroquia" class="form-control" required="">
                            			<?php
                            				$crud->sql = "SELECT id , parroquia from parroquias where id_estado = $_SESSION[estado] and id_municipio = $municipio";
                            				$crud->leer();
                            				foreach ($crud->filas as $value) 
                            				{
                            				?>
                            					<option value='<?php echo $value["id"]; ?>'><?php echo utf8_encode($value["parroquia"]); ?></option>
                            			<?php
                            				}
                            				?>
                            		</select>
                            	</div>	
                            </div>
                            <div class="form-group">
                            	<div class="col-md-12">
                            		<select name="permisos" required="">
		                                <option value="1">Todo</option>
		                                <option value="2">Moderado</option>
		                                <option value="3">Regtringido</option>
	                            	</select>
                            	</div>
                            </div>
                            <div class="form-group">
                            	<div class="col-md-12">
                            		<select class="form-control" name="categoria" id="categoria" required="">
                            			<option></option>
                            			<option value="3">UBCH</option>
                            			<option value="4">Concejo Comunal</option>
                            			<option value="5">Misiones</option>
                            			<option value="6">Instituto</option>
                            			<option value="8">Movimientos Sociales</option>
                            			<option value="7">Clap</option>
                                        <option value="9">Juventud</option>
                                        <option value="10">Otros</option>
                            		</select>
                            	</div>
                            </div>
                            <div class="form-group">
                            	<div class="col-md-12">
                            		<section id="section1" style="display: none"> 
                            			<?php
                            			$crud->sql = "SELECT centro_v.id_centro, descripcion from centro_v";
                            			$crud->leer();
                            			$ubch = $crud->filas;
										$crud->sql = "SELECT ubch from usuarios where ubch <> 0 and ubch is not null";
                            			$crud->leer();                            			
                            			$ubch_usuarios = $crud->filas;
                            			echo "<select name='ubch' id='ubch' class='form-control'>";
                                        echo "<option></option><option></option>";
                            			foreach ($ubch as $row) 
                            			{
                            				if(count($ubch_usuarios) > 0)
                            				{
                            					foreach ($ubch_usuarios as $row1) 
                            					{
                            						if($row1['ubch'] != $row['id_centro'])
                            						{
                            							echo "<option value='".$row['id_centro']."'>".utf8_encode($row['descripcion'])."</option>";
                            						}
                            					}
                            				}
                            				else
                            				{
                            					echo "<option value='".$row['id_centro']."'>".utf8_encode($row['descripcion'])."</option>";	
                            				}
                            			}
                            			echo "</select>";
                            			?>
                            		</section>
                            		<section id="section2" style="display: none"> 
                            			<input type="text" name="consejo_comunal" id="consejo_comunal" placeholder="Indique le nombre del concejo">
                            		</section>
                            		<section id="section3" style="display: none"> 
                            			<input type="text" name="misiones" id="misiones" placeholder="Indique le nombre de la misión">
                            		</section>
                            		<section id="section4" style="display: none"> 
                            			<input type="text" name="institucion" id="institucion" placeholder="Indique le nombre de la Institución">
                            		</section>
                            		<section id="section5" style="display: none"> 
                            			<input type="text" name="movimientos_sociales" id="movimientos_sociales" placeholder="Indique le nombre del Movimiento">
                            		</section>
                            		<section id="section6" style="display: none"> 
                            		<?php
                            				
                            				?>
                            			<select id="clap" name="clap" class="form-control">
                                        <option></option>
                                        <option></option>
                            			<?php
                            				
                            				$crud->sql = "SELECT id_usu, ape_usu, comunidad from reg_usuarios where grupo <> '' and id_estado = $_SESSION[estado] and id_municipio = $_SESSION[municipio]";
                            				$crud->leer1();
                            				$claps = $crud->filas1;
                            				$crud->sql = "SELECT id_clap from usuarios where id_clap <> 0 and id_clap is not null";
                            				$crud->leer1();
                            				$clap_registrado = $crud->filas1;
                            				foreach ($claps as $row) 
                            				{
                            					if(count($clap_registrado) > 0)
                            					{
                            						foreach ($clap_registrado as $row1) 
                            						{
                            							if($row1['id_clap'] != $row['id_usu'])
                            							{
                            								echo "<option value='".$row['id_usu']."'>".utf8_encode($row['comunidad'])." - ".utf8_encode($row['ape_usu'])."</option>";
                            							}
                            						}
                            					}
                            					else
                            					{
                            						echo "<option value='".$row['id_usu']."'>".utf8_encode($row['comunidad'])." - ".utf8_encode($row['ape_usu'])."</option>";
                            					}
                            				}
                            				?>
                            			</select>
                            		</section>
                                    <section id="section7" style="display: none"> 
                                        <input type="text" name="juventud" id="juventud" placeholder="Indique le nombre de la Organización">
                                    </section>
                                    <section id="section8" style="display: none"> 
                                        <input type="text" name="otros" id="otros" placeholder="Indique le nombre del ente">
                                    </section>
                            	</div>
                            </div>
                            <section id="encargado" style="display: none">
                                <h3>Datos del encargado</h3>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Cédula</label>
                                    <div class="col-md-4">
                                        <input type="number" name="cedula" id="cedula" class="form-control" required="Ingrese la cédula">
                                    </div>
                                    <label class="control-label col-md-2">Nombre</label>
                                    <div class="col-md-4">
                                        <input type="text" name="nombre" id="nombre" class="form-control" required="Ingrese el nombre">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Apellido</label>
                                    <div class="col-md-4">
                                        <input type="text" name="apellido" id="apellido" class="form-control" required="Ingrese el Apellido">
                                    </div>
                                    <label class="control-label col-md-2">Teléfono</label>
                                    <div class="col-md-4">
                                        <input type="number" name="telefono" id="telefono" class="form-control" required="Ingrese el Telefono">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Dirección</label>
                                    <div class="col-md-10">
                                       <input type="text" name="direccion" id="direccion" required="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-offset-2 col-md-8 text-center">
                                    <p  id="aviso" class="label label-danger" style="color: white; font-weight: bold; font-size: 12px;"></p>
                                </div>
                            </section>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="add-project" id="grabar">Crear</button>
                    <button type="button" class="cancel" data-dismiss="modal">Cerrar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

<div id="modificar_cuenta" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header login-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Modificar Cuenta</h4>
            </div>
            <form class="form-horizontal" id="form_modificar" action="grabar_locales.php" method="POST">
            <input type="hidden" name="accion" value="modificar_cuenta">
            <input type="hidden" name="id_modificar_cuenta" id="id_modificar_cuenta">
            <input type="hidden" name="id_modificar_responsable" id="id_modificar_responsable">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                                <div class="col-md-6">
                                    <select name="estado" id="estado" disabled="">
                                        <?php
                                            $crud->sql = "SELECT id , estado from estados where id = $_SESSION[estado]";
                                            $crud->leer();
                                            foreach ($crud->filas as $value) 
                                            {
                                                ?>

                                                    <option value='<?php echo $value["id"]; ?>' selected=""><?php echo $value["estado"]; ?></option>
                                        <?php
                                            }
                                        ?>?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select name="municipio" id="municipio" class="form-control">
                                        <?php
                                            $crud->sql = "SELECT id_municipio , municipio from municipios where id_estado = $_SESSION[estado] and id_municipio = $municipio";
                                            $crud->leer();
                                            foreach ($crud->filas as $value) 
                                            {
                                            ?>
                                                <option value='<?php echo $value["id_municipio"]; ?>'><?php echo utf8_encode($value["municipio"]); ?></option>
                                        <?php
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <select name="parroquia_modi" id="parroquia_modi" class="form-control" required="">
                                        <?php
                                            $crud->sql = "SELECT id , parroquia from parroquias where id_estado = $_SESSION[estado] and id_municipio = $municipio";
                                            $crud->leer();
                                            foreach ($crud->filas as $value) 
                                            {
                                            ?>
                                                <option value='<?php echo $value["id"]; ?>'><?php echo utf8_encode($value["parroquia"]); ?></option>
                                        <?php
                                            }
                                            ?>
                                    </select>
                                </div>  
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <select name="permisos_modi" id="permisos_modi" required="">
                                        <option value="1">Todo</option>
                                        <option value="2">Moderado</option>
                                        <option value="3">Regtringido</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <select class="form-control" name="categoria_modi" id="categoria_modi" required="" disabled="">
                                        <option></option>
                                        <option value="3">UBCH</option>
                                        <option value="4">Concejo Comunal</option>
                                        <option value="5">Misiones</option>
                                        <option value="6">Instituto</option>
                                        <option value="8">Movimientos Sociales</option>
                                        <option value="7">Clap</option>
                                        <option value="9">Juventud</option>
                                        <option value="10">Otros</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <section id="section1_modi" style="display: none"> 
                                        <?php

                                        $crud->sql = "SELECT centro_v.id_centro, descripcion from centro_v INNER JOIN ubch ON centro_v.id_centro = ubch.id_centro";
                                        $crud->leer();
                                        $ubch = $crud->filas;
                                        echo "<select name='ubch_modi' id='ubch_modi' class='form-control'>";
                                        echo "<option></option><option></option>";
                                        foreach ($ubch as $row) 
                                        {
                                                echo "<option value='".$row['id_centro']."'>".utf8_encode($row['descripcion'])."</option>"; 
                                        }
                                        echo "</select>";
                                        ?>
                                    </section>
                                    <section id="section2_modi" style="display: none"> 
                                        <input type="text" name="consejo_comunal_modi" id="consejo_comunal_modi" placeholder="Indique le nombre del concejo">
                                    </section>
                                    <section id="section3_modi" style="display: none"> 
                                        <input type="text" name="misiones_modi" id="misiones_modi" placeholder="Indique le nombre de la misión">
                                    </section>
                                    <section id="section4_modi" style="display: none"> 
                                        <input type="text" name="institucion_modi" id="institucion_modi" placeholder="Indique le nombre de la Institución">
                                    </section>
                                    <section id="section5_modi" style="display: none"> 
                                        <input type="text" name="movimientos_sociales_modi" id="movimientos_sociales_modi" placeholder="Indique le nombre del Movimiento">
                                    </section>
                                    <section id="section6_modi" style="display: none"> 
                                    <?php
                                            
                                            ?>
                                        <select id="clap_modi" name="clap_modi" class="form-control">
                                        <option></option>
                                        <option></option>
                                        <?php
                                            
                                            $crud->sql = "SELECT id_usu, ape_usu, comunidad from reg_usuarios where grupo <> '' and id_estado = $_SESSION[estado] and id_municipio = $_SESSION[municipio]";
                                            $crud->leer1();
                                            $claps = $crud->filas1;
                                            foreach ($claps as $row) 
                                            {
                                                    echo "<option value='".$row['id_usu']."'>".utf8_encode($row['comunidad'])." - ".utf8_encode($row['ape_usu'])."</option>";
                                                
                                            }
                                            ?>
                                        </select>
                                    </section>
                                      <section id="section7_modi" style="display: none"> 
                                        <input type="text" name="juventud_modi" id="juventud_modi">
                                    </section>
                                      <section id="section8_modi" style="display: none"> 
                                        <input type="text" name="otros_modi" id="otros_modi">
                                    </section>
                                </div>
                            </div>
                            <section id="encargado_modi">
                                <h3>Datos del encargado</h3>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Cédula</label>
                                    <div class="col-md-4">
                                        <input type="number" name="cedula_modi" id="cedula_modi" class="form-control" required="Ingrese la cédula">
                                    </div>
                                    <label class="control-label col-md-2">Nombre</label>
                                    <div class="col-md-4">
                                        <input type="text" name="nombre_modi" id="nombre_modi" class="form-control" required="Ingrese el nombre">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Teléfono</label>
                                    <div class="col-md-4">
                                        <input type="number" name="telefono_modi" id="telefono_modi" class="form-control" required="Ingrese el Telefono">
                                    </div>
                                    <label class="control-label col-md-2">Apellido</label>
                                    <div class="col-md-4">
                                        <input type="text" name="apellido_modi" id="apellido_modi" class="form-control" required="Ingrese el Apellido">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Dirección</label>
                                    <div class="col-md-10">
                                       <input type="text" name="direccion_modi" id="direccion_modi" required="" class="form-control">
                                    </div>
                                </div>
                            </section>
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

 <div id="cambiar_contraseña" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header login-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Modificar Contraseña</h4>
            </div>
            <form class="form-horizontal" id="form_clave" action="grabar_locales.php" method="POST">
            <input type="hidden" name="accion" value="cambiar_clave">
            <input type="hidden" name="id_modificar" id="id_modificar">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-md-3">Contraseña Insegura</label>
                            <div class="col-md-7">
                                <input type="text" name="contra_vieja" id="contra_vieja" readonly="" class="text-center" style="border-color: red;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nueva Contraseña</label>
                            <div class="col-md-7">
                                <input type="text" name="contra_nueva" id="contra_nueva">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Repita su Contraseña</label>
                            <div class="col-md-7">
                                <input type="text" name="contra_repite" id="contra_repite">
                            </div>
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
<div id="estadisticas" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header login-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title" style="color: white">Estadisticas del sistema</h3>
            </div>
             <form class="form-horizontal">
                <div class="modal-body">
                    <div class="row">
                        <div id="chartdiv" style="width: 100%; height: 400px;"></div>                      
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="cancel" data-dismiss="modal">Cerrar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>
<script type="text/javascript" src="js/select2.js"></script>
<script src="js/amcharts/amcharts.js" type="text/javascript"></script>
<script src="js/amcharts/funnel.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){

//Verificar contraseña-------------------------------------------------

    $.getJSON('grabar_locales.php', {accion: 'verificar_municipales', cuenta: '<?php echo $_SESSION["user"]; ?>'}, function(data){
        if(typeof(data.error) == "undefined")
        {
            if(data.actualizar == 0)
            {
                $("#contra_vieja").val(data.clave);
                $("#id_modificar").val(data.id);
                $("#cambiar_contraseña").modal('show');
                $("#cambiar_contraseña").on('shown.bs.modal', function(){
                    $("#contra_nueva").focus();
                });
            }   
        }

    });

    $("#form_clave").submit(function(){
        if($("#contra_nueva").val() != $("#contra_repite").val())
        {
            alert("Las contraseñas no coinciden");
            return false;
        }
        else
        {
            $.post('grabar_locales.php', $(this).serialize(), function(){
                swal({
                    title: "Contraseña Cambiada",
                            type: "success",
                            showButtonCancel: false,
                            confirmButtonText: "Cerrar",
                            confirmButtonClass: "btn btn-info",
                            closeOnConfirm: true
                            },function(confirm){
                                if(confirm)
                                {
                                    $("#form_clave").keypress(function(e){
                                        if(e.keyCode == 13)
                                        {
                                            return false;
                                        }
                                    });

                                   $("#cambiar_contraseña").modal('hide');
                                }
                });
            });
        }
        return false;   
    });

//-----------------Otros-----------------------------------------------------
		$("#parroquia").select2();
        $("#parroquia_modi").select2();
        $("#clap_modi").select2();
		$("#clap").select2();
		$("#ubch").select2();
        

        $("#tabla").dataTable({
            "language" : {"url" : "json/esp.json"},
            order : [1, "asc"]
        });

//Sección de código que muestra las categorías------------------------

		$("#categoria").on("change", function(){
			var val = $(this).val();
			if(val == 3)
			{
				$("section").hide('slow/400/fast');
				$("#section1").show('slow/400/fast');

                $("#ubch").prop('required', true);
                $("#consejo_comunal").prop('required', false);
                $("#misiones").prop('required', false);
                $("#institucion").prop('required', false);
                $("#movimientos_sociales").prop('required', false);
                $("#clap").prop('required', false);
                $("#juventud").prop('required', false);
                $("#otros").prop('required', false);

			}
			else if(val == 4)
			{
				$("section").hide('slow/400/fast');
				$("#section2").show('slow/400/fast');
				$("#consejo_comunal").focus();

                $("#consejo_comunal").prop('required', true);
                $("#ubch").prop('required', false);
                $("#misiones").prop('required', false);
                $("#institucion").prop('required', false);
                $("#movimientos_sociales").prop('required', false);
                $("#clap").prop('required', false);
                $("#juventud").prop('required', false);
                $("#otros").prop('required', false);
			}
			else if(val == 5)
			{
				$("section").hide('slow/400/fast');
				$("#section3").show('slow/400/fast');
				$("#misiones").focus();

                $("#misiones").prop('required', true);
                $("#ubch").prop('required', false);
                $("#consejo_comunal").prop('required', false);
                $("#institucion").prop('required', false);
                $("#movimientos_sociales").prop('required', false);
                $("#clap").prop('required', false);
                $("#juventud").prop('required', false);
                $("#otros").prop('required', false);
			}
			else if(val == 6)
			{
				$("section").hide('slow/400/fast');
				$("#section4").show('slow/400/fast');
				$("#institucion").focus();

                $("#institucion").prop('required', true);
                $("#ubch").prop('required', false);
                $("#consejo_comunal").prop('required', false);
                $("#misiones").prop('required', false);
                $("#movimientos_sociales").prop('required', false);
                $("#clap").prop('required', false);
                $("#juventud").prop('required', false);
                $("#otros").prop('required', false);
			}
			else if(val == 7)
			{
				$("section").hide('slow/400/fast');
				$("#section6").show('slow/400/fast');

                $("#clap").prop('required', true);
                $("#ubch").prop('required', false);
                $("#consejo_comunal").prop('required', false);
                $("#misiones").prop('required', false);
                $("#institucion").prop('required', false);
                $("#movimientos_sociales").prop('required', false);
                $("#juventud").prop('required', false);
                $("#otros").prop('required', false);
			}
			else if(val == 9)
			{
				$("section").hide('slow/400/fast');
				$("#section7").show('slow/400/fast');
				$("#juventud").focus();

                $("#juventud").prop('required', true);
                $("#movimientos_sociales").prop('required', false);
                $("#ubch").prop('required', false);
                $("#consejo_comunal").prop('required', false);
                $("#misiones").prop('required', false);
                $("#institucion").prop('required', false);
                $("#clap").prop('required', false);
                $("#otros").prop('required', false);
			}
            else if(val == 10)
            {
                $("section").hide('slow/400/fast');
                $("#section8").show('slow/400/fast');
                $("#otros").focus();

                $("#otros").prop('required', true);
                $("#movimientos_sociales").prop('required', false);
                $("#ubch").prop('required', false);
                $("#consejo_comunal").prop('required', false);
                $("#misiones").prop('required', false);
                $("#institucion").prop('required', false);
                $("#clap").prop('required', false);
                $("#juventud").prop('required', false);
            }
		});

//Sección de código que muestra los campos del encargado---------------------

        $("#ubch").on("change", function(){
            $("#encargado").show('slow/400/fast');
            $("#grabar").prop('disabled', false);
        });

        $("#consejo_comunal").blur(function(){
           $("#encargado").show('slow/400/fast'); 
           $("#grabar").prop('disabled', false);
        });

        $("#misiones").blur(function(){
           $("#encargado").show('slow/400/fast'); 
           $("#grabar").prop('disabled', false);
        });

        $("#institucion").blur(function(){
           $("#encargado").show('slow/400/fast'); 
           $("#grabar").prop('disabled', false);
        });

        $("#movimientos_sociales").blur(function(){
           $("#encargado").show('slow/400/fast'); 
           $("#grabar").prop('disabled', false);
        });

        $("#clap").change(function(){
           $("#encargado").show('slow/400/fast'); 
           $("#grabar").prop('disabled', false);
        });

         $("#otros").blur(function(){
           $("#encargado").show('slow/400/fast'); 
           $("#grabar").prop('disabled', false);
        });

        $("#juventud").blur(function(){
           $("#encargado").show('slow/400/fast'); 
           $("#grabar").prop('disabled', false);
        });

//------------------------------------------------------------------------
		$("#agregar_locales").on('hidden.bs.modal', function(){
			$("section").hide('slow/400/fast');
		});

		$("#form-agregar").submit(function(){

            if($("#nombre").val() == "")
            {
                $("#encargado").show('slow/400/fast');
                return false;
            }

			$.ajax({
					url: $(this).attr('action'),
					type: "POST",
					data: $(this).serialize(),
					success: function()
					{
							swal({
							title: "Cuenta agregada",
							type: "success",
							showButtonCancel: false,
							confirmButtonText: "Cerrar",
							confirmButtonClass: "btn btn-info",
							closeOnConfirm: true
							},function(confirm){
								if(confirm)
								{
                                    $("#form-agregar").keypress(function(e){
                                        if(e.keyCode == 13)
                                        {
                                            return false;
                                        }
                                    });
									window.location.reload();
								}
							});
					}
			});
			return false;
		});

        $("#form_modificar").submit(function(){
            $("#categoria_modi").prop('disabled', false);
        });

//-----------modal_modificar------------------------------------


$("#modificar_cuenta").on('show.bs.modal', function(e){
    var x = $(e.relatedTarget).data().id_modi;
            $(e.currentTarget).find("#id_modificar_cuenta").val(x);
    var x = $(e.relatedTarget).data().parro_modi;
            $(e.currentTarget).find("#parroquia_modi").val(x).prop('selected',true).change();
    var x = $(e.relatedTarget).data().categoria_modi;
            $(e.currentTarget).find("#categoria_modi").val(x).prop('selected',true);
    var x = $(e.relatedTarget).data().permisos_modi;
            $(e.currentTarget).find("#permisos_modi").val(x).prop('selected',true);

    var x = $(e.relatedTarget).data().ubch_modi;
    if(x != "")
    {
        $("#section1_modi").show('slow/400/fast');
        $(e.currentTarget).find("#ubch_modi").val(x).prop('selected', true).change();
    }

    var x = $(e.relatedTarget).data().concejo_modi;
    if(x != "")
    {
        $("#section2_modi").show('slow/400/fast');
        $(e.currentTarget).find("#consejo_comunal_modi").val(x);
    }

    var x = $(e.relatedTarget).data().mision_modi;
    if(x != "")
    {
        $("#section3_modi").show('slow/400/fast');
        $(e.currentTarget).find("#misiones_modi").val(x);   
    }

    var x = $(e.relatedTarget).data().institucion_modi;
    if(x != "")
    {
        $("#section4_modi").show('slow/400/fast');
        $(e.currentTarget).find("#institucion_modi").val(x);   
    }  

    var x = $(e.relatedTarget).data().movimiento_modi;
    if(x != "")
    {
        $("#section5_modi").show('slow/400/fast');
        $(e.currentTarget).find("#movimientos_sociales_modi").val(x);   
    } 

    var x = $(e.relatedTarget).data().clap_modi;
    if(x != "")
    {
        $("#section6_modi").show('slow/400/fast');
        $(e.currentTarget).find("#clap_modi").val(x).prop('selected', true).change();   
    }

    var x = $(e.relatedTarget).data().juventud_modi;
    if(x != "")
    {
        $("#section7_modi").show('slow/400/fast');
        $(e.currentTarget).find("#juventud_modi").val(x);   
    }

    var x = $(e.relatedTarget).data().otros_modi;
    if(x != "")
    {
        $("#section8_modi").show('slow/400/fast');
        $(e.currentTarget).find("#otros_modi").val(x);   
    }

    var x = $(e.relatedTarget).data().nombre_modi;
            $(e.currentTarget).find("#nombre_modi").val(x);
    var x = $(e.relatedTarget).data().apellido_modi;
            $(e.currentTarget).find("#apellido_modi").val(x);
    var x = $(e.relatedTarget).data().cedula_modi;
            $(e.currentTarget).find("#cedula_modi").val(x);
    var x = $(e.relatedTarget).data().telefono_modi;
            $(e.currentTarget).find("#telefono_modi").val(x);
    var x = $(e.relatedTarget).data().direccion_modi;
            $(e.currentTarget).find("#direccion_modi").val(x);
    var x = $(e.relatedTarget).data().id_responsable;
            $(e.currentTarget).find("#id_modificar_responsable").val(x);
    $("#encargado_modi").show('slow/400/fast');

});

$("#modificar_cuenta").on('hidden.bs.modal', function(){
    $("#section1_modi").hide('slow/400/fast');
    $("#section2_modi").hide('slow/400/fast');
    $("#section3_modi").hide('slow/400/fast');
    $("#section6_modi").hide('slow/400/fast');
    $("#section4_modi").hide('slow/400/fast');
    $("#section5_modi").hide('slow/400/fast');
    $("#section6_modi").hide('slow/400/fast');
    $("#section7_modi").hide('slow/400/fast');
});

    $("#form_modificar").submit(function(){
        $("#categoria_modi").prop('disabled', false);
    });



//------------------------------------------------------------------

        function pregunta()
        {
            var agree = confirm("¿Esta seguro que quiere eliminar esta cuenta?");
            if(agree)
            {
                return true;
            }
            else
            {
                return false;   
            }
        }

        $(".eliminar").click(function(){
            var confirm = pregunta();
            if(confirm)
            {
                window.location.href ="grabar_locales.php?accion=eliminar&id="+btoa($(this).data('eliminar'));
            }
        });

        function rev_rep(ced){
            $("#aviso").html('');
            $("#aviso").show('slow/400/fast');
            $("#aviso").html('Cargando datos por favor espere...');
            $.get('http://consultaelectoral.bva.org.ve/cedula='+ced, function(data,textStatus) {
                if(data.length > 0)
                {
                    $("#aviso").html('');
                    $("#nombre").val(data[0].p_nombre);
                    $("#apellido").val(data[0].p_apellido);
                }        
            });
             setTimeout(function(){
                $("#aviso").hide('slow/400/fast');
            }, 2000);
        };

        $("#cedula").on("blur", function(){
            rev_rep($(this).val());
        });

        //------------gráficos de las estadísticas---------------------------------

            var chart;

            var data = [
                <?php 

                    $colores = ["#FF6600", "#FCD202", "#B0DE09", "#0D8ECF", "#2A0CD0", "#CD0D74"];
                    $crud->sql = "SELECT 
                    (SELECT nombre from categoria where id = usuarios.categoria) as categoria, 
                    COUNT(*) as total from usuarios where categoria <> 1 and categoria <> 2 and id_estado = $_SESSION[estado] and id_municipio = $municipio GROUP BY categoria ORDER BY total desc
                    ";

                    $crud->leer();
                    $x = 0;
                    if(count($crud->filas) > 0)
                    {
                        foreach ($crud->filas as $row) 
                        {
                        ?>
                            
                            {
                                "title": "<?php echo $row['categoria']; ?>",
                                "value": <?php echo $row['total']; ?>
                            },
                            
                        <?php
                        $x++;
                        }
                    }
                    ?>
            ];


            AmCharts.ready(function () {

                chart = new AmCharts.AmFunnelChart();
                chart.titleField = "title";
                chart.balloon.cornerRadius = 0;
                chart.marginRight = 220;
                chart.marginLeft = 15;
                chart.labelPosition = "right";
                chart.funnelAlpha = 0.9;
                chart.valueField = "value";
                chart.dataProvider = data;
                chart.startX = 0;
                chart.balloon.animationTime = 0.2;
                chart.neckWidth = "40%";
                chart.startAlpha = 0;
                chart.neckHeight = "30%";
                chart.balloonText = "[[title]]:<b>[[value]]</b>";

                chart.creditsPosition = "top-right";
                chart.write("chartdiv");
            });
	});
</script>