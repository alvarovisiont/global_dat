<?php
	require_once "encabezado.php";
	require_once "conexion/conexion.php";
	$model = new Conexion();
	$db = $model->conectar();
?>
	<div class="row">
		<div class="container-fluid">
			<div class="col-md-12">
				<table class="table table-bordered table-hover table-condensed" id="tabla">
					<thead>
						<th>USUARIO</th>
						<th>CATEGORÍA</th>
						<th>ESTADO</th>
	                    <th>Acción</th>
					</thead>
					<tbody style="text-align:center;">
						<?php
	                       $crud->sql = "SELECT usuarios.id, usuario, id_estado,
	                                        nombre, apellido, cedula, telefono, direccion, responsables.id as id_responsable,
	                                        (SELECT nombre from categoria where id = usuarios.categoria) as categoria1,
                                            (SELECT estado from estados where id = usuarios.id_estado) as estado
											FROM usuarios 
	                                        LEFT JOIN responsables ON usuarios.id = responsables.id_usuario
	                                        WHERE usuarios.nivel = 1
	                                        ";
							$crud->leer();
							$total = count($crud->filas);
							if($total > 0)
							{
								foreach ($crud->filas as  $row) 
								{
								?>
									<tr>
										<td><?php echo $row['usuario']; ?></td>
										<td><?php echo $row['categoria1']; ?></td>
										<td><?php echo $row['estado']; ?></td>
	                                    <td>
                                    		<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#mod_project" data-backdrop="static"
												data-id_mod="<?php echo $row['id']; ?>"
												data-id_estado="<?php echo $row['id_estado']; ?>"
												data-nombre_modi="<?php echo $row['nombre']; ?>"
                                                data-apellido_modi="<?php echo $row['apellido']; ?>"
                                                data-cedula_modi="<?php echo $row['cedula']; ?>"
                                                data-telefono_modi="<?php echo $row['telefono']; ?>"
                                                data-direccion_modi="<?php echo $row['direccion']; ?>"
                                                data-responsable_modi="<?php echo $row['id_responsable']; ?>"
                                                ><span class="glyphicon glyphicon-edit"></span>
											</button>
	                                        <button class="btn btn-danger btn-sm eliminar" title="Eliminar" data-eliminar="<?php echo $row['id']; ?> "><span class="glyphicon glyphicon-trash"></span></button>
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
								</tr>
							<?php
							}

						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div id="add_project" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header login-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Agregar Cuenta</h4>
                </div>
                 <form class="form-horizontal" id="form-agregar" action="grabar_cuentas.php" method="POST">
                 <input type="hidden" name="accion" value="estados_grabar">
                 <input type="hidden" name="nivel" value="1">
                    <div class="modal-body">
                            <div class="form-group">
                            	<div class="col-md-6">
                            		<select name="estado" id="estado" required="">
                                        <option></option>
                            			<?php
                            				$crud->sql = "SELECT id , estado from estados ORDER BY estado asc";
                            				$crud->leer();
                            				foreach ($crud->filas as $value) 
                            				{
                            					?>
                            						<option value='<?php echo $value["id"]; ?>'><?php echo $value["estado"]; ?></option>
                            			<?php
                            				}
                            			?>?>
                            		</select>
                            	</div>
                            </div>
                            <section id="encargado">
                                <h3>Datos del encargado</h3>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Cédula</label>
                                    <div class="col-md-4">
                                        <input type="number" name="cedula" id="cedula" class="form-control" required="" placeholder="Ingrese la cédula">
                                    </div>
                                    <label class="control-label col-md-2">Nombre</label>
                                    <div class="col-md-4">
                                        <input type="text" name="nombre" id="nombre" class="form-control" required="" placeholder="Ingrese el nombre">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Apellido</label>
                                    <div class="col-md-4">
                                        <input type="text" name="apellido" id="apellido" class="form-control" required="" placeholder="Ingrese el Apellido">
                                    </div>
                                    <label class="control-label col-md-2">Teléfono</label>
                                    <div class="col-md-4">
                                        <input type="number" name="telefono" id="telefono" class="form-control" required="" placeholder="Ingrese el Telefono">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Dirección</label>
                                    <div class="col-md-10">
                                       <input type="text" name="direccion" id="direccion" required="" class="form-control">
                                    </div>
                                </div>
                            </section>
                            <div class="form-group text-center">
                            <br>
                            	<div id="aviso"></div>
                            </div>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="add-project">Crear</button>
                    <button type="button" class="cancel" data-dismiss="modal">Cerrar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div id="mod_project" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header login-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Modificar Cuenta</h4>
                </div>
                 <form class="form-horizontal" id="form-modi" action="grabar_cuentas.php" method="POST">
                 <input type="hidden" name="accion" value="estados_modificar">
                 <input type="hidden" name="id_modi" id="id_modi">
                 <input type="hidden" name="id_responsable_modi" id="id_responsable_modi">
                    <div class="modal-body">
                    		<div class="form-group">
                            	<div class="col-md-6">
                            		<select name="estado_modi" id="estado_modi">
                            			<?php
                            				$crud->sql = "SELECT id , estado from estados";
                            				$crud->leer();
                            				foreach ($crud->filas as $value) 
                            				{
                            					?>

                            						<option value='<?php echo $value["id"]; ?>'><?php echo $value["estado"]; ?></option>
                            			<?php
                            				}
                            			?>?>
                            		</select>
                            	</div>
                            </div>
                            <section id="encargado_modi">
                                <h3>Datos del encargado</h3>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Cédula</label>
                                    <div class="col-md-4">
                                        <input type="number" name="cedula_modi" id="cedula_modi" class="form-control" required="Ingrese la cédula">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Nombre</label>
                                    <div class="col-md-4">
                                        <input type="text" name="nombre_modi" id="nombre_modi" class="form-control" required="Ingrese el nombre">
                                    </div>
                                    <label class="control-label col-md-2">Apellido</label>
                                    <div class="col-md-4">
                                        <input type="text" name="apellido_modi" id="apellido_modi" class="form-control" required="Ingrese el Apellido">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Teléfono</label>
                                    <div class="col-md-4">
                                        <input type="number" name="telefono_modi" id="telefono_modi" class="form-control" required="Ingrese el Telefono">
                                    </div>
                                    <label class="control-label col-md-2">Dirección</label>
                                    <div class="col-md-10">
                                       <input type="text" name="direccion_modi" id="direccion_modi" required="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <br>
                                    <div id="aviso1"></div>
                                </div>
                            </section>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="add-project">Modificar</button>
                    <button type="button" class="cancel" data-dismiss="modal">Cerrar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div id="estadisticas" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
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
	$(document).ready(function(){

		$("#usuario_modi").select2();
		$("#municipio").select2();
        $("#parroquia_modificar").select2();

         function rev_rep(ced,nivel){
            if(nivel == 1)
            {
                $("#aviso").html('');
                $("#aviso").show('slow/400/fast');
                $("#aviso").text('Cargando datos por favor espere...');
                $("#nombre").prop('readonly', true);
                $("#apellido").prop('readonly', true);
                $.get('http://consultaelectoral.bva.org.ve/cedula='+ced, function(data,textStatus) {

                    if(typeof(data[0].p_nombre) != 'undefined')
                    {

                        $("#aviso").html('');
                        $("#nombre").val(data[0].p_nombre);
                        $("#apellido").val(data[0].p_apellido);
                    }        
                });
                setTimeout(function(){
                    $("#aviso").hide('slow/400/fast');
                    $("#nombre").prop('readonly', false);
                    $("#apellido").prop('readonly', false);
                },2500);
            }
            else
            {
                $("#aviso1").html('');
                $("#aviso1").show('slow/400/fast');
                $("#aviso1").text('Cargando datos por favor espere...');
                $("#nombre_modi").prop('readonly', true);
                $("#apellido_modi").prop('readonly', true);
                $.get('http://consultaelectoral.bva.org.ve/cedula='+ced, function(data,textStatus) {

                    if(typeof(data[0].p_nombre) != 'undefined')
                    {
                        
                        $("#aviso1").html('');
                        $("#nombre_modi").val(data[0].p_nombre);
                        $("#apellido_modi").val(data[0].p_apellido);
                    }
                }); 

                setTimeout(function(){
                    $("#aviso1").hide('slow/400/fast');
                    $("#nombre_modi").prop('readonly', false);
                    $("#apellido_modi").prop('readonly', false);
                },2500);
            }
                
        };

        $("#cedula").on("blur", function(){
            rev_rep($(this).val(),1);
        });

        $("#cedula_modi").on("blur", function(){
            rev_rep($(this).val(),2);
        });

		function pregunta()
		{	
		var agree=confirm("Está seguro de eliminar este Registro? Este proceso es irreversible.");
		if (agree)
		  return true ;
		else
		   return false ;
		}

		$("#tabla").dataTable({
			"language" : {"url" : "json/esp.json"},
			order: [2, 'desc']
		});

		$("#form-agregar").submit(function(){
			$.ajax({
				url: $(this).attr('action'),
				type: "POST",
				data: $(this).serialize(),
				dataType: "JSON",
				success: function(data)
				{
					if(typeof(data.registrado) == "undefined")
					{
						$("#aviso").html('');

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
					else
					{
						$("#aviso").html('');
                        $("#aviso").show('slow/400/fast');
						$("#aviso").html(data.registrado);
					}
				}
			});
			return false;
		});

		$("#add-project").on('show.bs.modal', function(){
			$("#aviso").html('');
		});

//----------------------modales modificar--------------------------------------------

		$("#mod_project").on('show.bs.modal', function(e){

				var x = $(e.relatedTarget).data().id_mod;
					$(e.currentTarget).find('#id_modi').val(x);
				var x = $(e.relatedTarget).data().id_estado;
					$(e.currentTarget).find('#estado_modi').val(x).prop('selected', true).change();
                var x = $(e.relatedTarget).data().nombre_modi;
                    $(e.currentTarget).find('#nombre_modi').val(x);
                var x = $(e.relatedTarget).data().apellido_modi;
                    $(e.currentTarget).find('#apellido_modi').val(x);
                var x = $(e.relatedTarget).data().cedula_modi;
                    $(e.currentTarget).find('#cedula_modi').val(x);
                var x = $(e.relatedTarget).data().telefono_modi;
                    $(e.currentTarget).find('#telefono_modi').val(x);
                var x = $(e.relatedTarget).data().direccion_modi;
                    $(e.currentTarget).find('#direccion_modi').val(x);
                var x = $(e.relatedTarget).data().responsable_modi;
                    $(e.currentTarget).find('#id_responsable_modi').val(x);
		});

// ==================================== BUSCAR MUNICIPIO ========================================================0


//-------------------------------------------------------------------------------------------------------------------------------------
		$("#form-modi").submit(function(){
			$.ajax({
				url: $(this).attr('action'),
				type: "POST",
				data: $(this).serialize(),
				dataType: "JSON",
				success: function(data)
				{
					if(typeof(data.exito) != "undefined")
					{
						swal({
                        title: "Cuenta Modificada",
                        type: "success",
                        showButtonCancel: false,
                        confirmButtonText: "Cerrar",
                        confirmButtonClass: "btn btn-info",
                        closeOnConfirm: true
                        },function(confirm){
                            if(confirm)
                            {
                                $("#form-modi").keypress(function(e){
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
                        swal({
                        title: "Error, ya existe una cuenta creada para este estado",
                        type: "error",
                        timer: 2000
                        });   
                    }
				}
			});
			return false;
		});

		$(".eliminar").click(function(e){
			var flujo = pregunta(),
				x = $(e.currentTarget).data('eliminar');
			if(flujo)
			{
				$.post('grabar_cuentas.php', {id: x, accion: 'estados_eliminar'}, function(){
					window.location.reload();
				});
			}
			else
			{
				return false;
			}
		});

		/*$("#municipio").change(function(){
			var x = $(this).val();
			$.getJSON('grabar_cuentas.php', {id : x, accion: 'parroquias'}, function(data){
				var filas = "";
				$.each(data, function(i,e){
					filas+= "<option value='"+e.id+"'>"+e.parroquia+"</option>";
				});
				$("#parroquia").html('');
				$("#parroquia").html(filas);
			});
		});*/

        //-----estadísticas del sistema----------------------------------


        var chart;

            var data = [
                <?php 
                    $crud->sql = "SELECT 
                    (SELECT nombre from categoria where id = usuarios.categoria) as categoria, 
                    COUNT(*) as total from usuarios where categoria = 1 GROUP BY categoria
                    ORDER BY total DESC
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
