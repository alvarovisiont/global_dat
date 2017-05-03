<?php
	require_once "encabezado.php";
?>
<div class="row">
	<div class="container-fluid">
		<div class="col-md-12">
			<table class="table table-strepead table-hover" id="tabla">
				<thead>
					<th class="text-center">Nac</th>
					<th class="text-center">Cédula</th>
					<th class="text-center">Nombre</th>
					<th class="text-center">Apellido</th>
					<th class="text-center">Teléfono</th>
					<th class="text-center">Acciones</th>
				</thead>
				<tbody class="text-center">
				<?php
				    $crud->sql = "SELECT id, nombre, apellido, cedula, nac, telefono, email, direccion, fecha_nacimiento FROM estructuras WHERE id_consejo = $_SESSION[id]";
					$crud->leer();
                    if(count($crud->filas) > 0)
                    {
                        foreach ($crud->filas as $row) 
                        {
                            $boton = "<a href='#modificar_estructura' data-toggle='modal' class='btn btn-warning btn-sm' title='editar'
                                        data-id ='$row[id]'
                                        data-nombre ='$row[nombre]'
                                        data-apellido ='$row[apellido]'
                                        data-cedula ='$row[cedula]'
                                        data-nac ='$row[nac]'
                                        data-telefono ='$row[telefono]'
                                        data-email ='$row[email]'
                                        data-direccion ='$row[direccion]'
                                        data-fecha ='".date('d-m-Y', strtotime($row['fecha_nacimiento']))."'>
                            <span class='glyphicon glyphicon-edit'></span></a>";
                            echo "<tr>
                                    <td>$row[nac]</td>
                                    <td>$row[cedula]</td>
                                    <td>$row[nombre]</td>
                                    <td>$row[apellido]</td>
                                    <td>$row[telefono]</td>
                                    <td>".$boton."</td>
                                </tr>";
                        }
                    }
                    else
                    {
                        echo "<tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>";
                    }
				?>
				</tbody>
			</table>
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
            <form class="form-horizontal" id="form_clave" action="grabar_poblacion.php" method="POST">
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
                                <input type="text" name="contra_nueva" id="contra_nueva" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Repita su Contraseña</label>
                            <div class="col-md-7">
                                <input type="text" name="contra_repite" id="contra_repite" required="">
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
<div id="modificar_estructura" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header login-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Modificar Integrante</h4>
            </div>
             <form class="form-horizontal" id="form-modificar" action="grabar_consejo.php" method="POST">
             <input type="hidden" name="accion" value="modificar_estructura">
             <input type="hidden" name="id_modificar" id="id_modificar" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nacionalidad</label>
                            <div class="col-md-3">
                                <select class="form-control" id="nac_edit" name="nac_edit" required="">
                                    <option></option>
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                </select>
                            </div>
                            <label class="control-label col-md-2">Cédula</label>
                            <div class="col-md-4">
                                <input type="number" name="cedula_edit" id="cedula_edit" required="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nombre</label>
                            <div class="col-md-3">
                                <input type="text" name="nombre_edit" id="nombre_edit" required="" class="form-control">
                            </div>
                            <label class="control-label col-md-2">Apellido</label>
                            <div class="col-md-4">
                                <input type="text" name="apellido_edit" id="apellido_edit" required="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Teléfono</label>
                            <div class="col-md-3">
                                <input type="number" name="telefono_edit" id="telefono_edit" required="" class="form-control">
                            </div>
                            <label class="control-label col-md-2">Dirección</label>
                            <div class="col-md-4">
                                <input type="text" name="direccion_edit" id="direccion_edit" required="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-3">
                                <input type="email" name="email_edit" id="email_edit" class="form-control">
                            </div>
                            <label class="control-label col-md-2">Fecha_nac</label>
                            <div class="col-md-4">
                                <input type="text" name="fecha_nac_edit" id="fecha_nac_edit" required="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-offset-3 col-md-8 text-center">
                            <p  id="aviso_mod" class="label label-danger" style="color: white; font-weight: bold; font-size: 12px;"></p>
                        </div>
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
<div id="agregar_estructura" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header login-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Agregar Integrante</h4>
            </div>
             <form class="form-horizontal" id="form-agregar" action="grabar_consejo.php" method="POST">
             <input type="hidden" name="accion" value="grabar_estructura">
             <input type="hidden" name="id_consejo" value="<?php echo $_SESSION['id']; ?>">
             <input type="hidden" name="centro_vot" id="centro_vot">
                <div class="modal-body">
                	<div class="row">
                		<div class="form-group">
                			<label class="control-label col-md-3">Nacionalidad</label>
                			<div class="col-md-3">
                				<select class="form-control" id="nac" name="nac" required="">
                					<option></option>
                					<option value="V">V</option>
                					<option value="E">E</option>
                				</select>
                			</div>
                			<label class="control-label col-md-2">Cédula</label>
                			<div class="col-md-4">
                				<input type="number" name="cedula" id="cedula" required="" class="form-control">
                			</div>
                		</div>
                		<div class="form-group">
                			<label class="control-label col-md-3">Nombre</label>
                			<div class="col-md-3">
                				<input type="text" name="nombre" id="nombre" required="" class="form-control">
                			</div>
                			<label class="control-label col-md-2">Apellido</label>
                			<div class="col-md-4">
                				<input type="text" name="apellido" id="apellido" required="" class="form-control">
                			</div>
                		</div>
                		<div class="form-group">
                			<label class="control-label col-md-3">Teléfono</label>
                			<div class="col-md-3">
                				<input type="number" name="telefono" id="telefono" required="" class="form-control">
                			</div>
                			<label class="control-label col-md-2">Dirección</label>
                			<div class="col-md-4">
                				<input type="text" name="direccion" id="direccion" required="" class="form-control">
                			</div>
                		</div>
                		<div class="form-group">
                			<label class="control-label col-md-3">Email</label>
                			<div class="col-md-3">
                				<input type="email" name="email" id="email" class="form-control">
                			</div>
                			<label class="control-label col-md-2">Fecha_nac</label>
                			<div class="col-md-4">
                				<input type="text" name="fecha_nac" id="fecha_nac" required="" class="form-control">
                			</div>
                		</div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Sexo:</label>
                            <div class="col-md-3">
                                <input type="text" name="sexo" id="sexo" required="" class="form-control">
                            </div>
                        </div>
                		<div class="col-md-offset-2 col-md-8 text-center">
                    		<p  id="aviso" class="label label-danger" style="color: white; font-weight: bold; font-size: 12px;"></p>
                    	</div>
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
<div id="estadisticas" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header login-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title" style="color: white">Estadísticas del sistema</h3>
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
<script src="js/amcharts/amcharts.js" type="text/javascript"></script>
<script src="js/amcharts/serial.js" type="text/javascript"></script>    
<script src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$(function(){
		$("#tabla").dataTable({
			"language" : {"url" : "json/esp.json"}
		});	
		$("#fecha_nac").datepicker({
			format: "dd-mm-yyyy"
		}).on("changeDate", function(){
			$(this).datepicker('hide');
		});

        $.getJSON('grabar_poblacion.php', {accion: 'verificar', cuenta: '<?php echo $_SESSION["user"]; ?>'}, function(data){
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

        function rev_rep(ced){
            $("#aviso").html('');
            $("#aviso").show('slow/400/fast');
            $("#aviso").text('Cargando datos por favor espere...');
            $.get('http://consultaelectoral.bva.org.ve/cedula='+ced, function(data,textStatus) {
                if(data.length > 0)
                {
                    $("#aviso").html('');
                    $("#nombre").val(data[0].p_nombre);
                    $("#apellido").val(data[0].p_apellido);
                    $("#fecha_nac").val(data[0].f_nac);
                    $("#centro_vot").val(data[0].cod_nuevo);
                    $("#sexo").val(data[0].sexo);
                }        
            });
            setTimeout(function(){
            $("#aviso").hide('slow/400/fast');
            }, 3000);
        };

        $("#cedula").on("blur", function(){
            rev_rep($(this).val());
        });

        //modal modificar------------------------------------------


        $("#modificar_estructura").on('show.bs.modal', function(e){
        	var x = $(e.relatedTarget).data().id;
        			$(e.currentTarget).find("#id_modificar").val(x);
        	var x = $(e.relatedTarget).data().nombre;
        			$(e.currentTarget).find("#nombre_edit").val(x);
        	var x = $(e.relatedTarget).data().apellido;
        			$(e.currentTarget).find("#apellido_edit").val(x);
        	var x = $(e.relatedTarget).data().cedula;
        			$(e.currentTarget).find("#cedula_edit").val(x);
        	var x = $(e.relatedTarget).data().nac;
        			$(e.currentTarget).find("#nac_edit").val(x).prop('selected', true);
        	var x = $(e.relatedTarget).data().telefono;
        			$(e.currentTarget).find("#telefono_edit").val(x);
        	var x = $(e.relatedTarget).data().email;
        			$(e.currentTarget).find("#email_edit").val(x);
        	var x = $(e.relatedTarget).data().direccion;
        			$(e.currentTarget).find("#direccion_edit").val(x);
        	var x = $(e.relatedTarget).data().fecha;
        			$(e.currentTarget).find("#fecha_nac_edit").val(x);
        });
    //----------------------------SUBMITS-----------------------------------------


        $("#form_clave").submit(function(){
            if($("#contra_nueva").val() != $("#contra_repite").val())
            {
                alert("Las contraseñas no coinciden");
                return false;
            }
            else
            {
                $.post('grabar_poblacion.php', $(this).serialize(), function(){
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

        $("#form-agregar").submit(function(){
        	$.ajax({
        		url: $(this).attr('action'),
        		type: "POST",
        		data: $(this).serialize(),
        		dataType: "JSON",
        		success: function(data)
        		{
        			if(typeof(data.exito) != "undefined")
        			{
        				window.location.reload();	
        			}
        			else
        			{
        				$("#aviso").html('');
						$("#aviso").show('slow/400/fast');
						$("#aviso").html(data.registrado);
						setTimeout(function(){
							$("#aviso").hide('slow/400/fast');
						}, 2000);
        			}	
        		}
        	});
        	return false;
        });

        var chart;
            var graph;
            var chartData = [
            <?php 
                $crud->sql = "SELECT nombre, apellido, (SELECT COUNT(*) from caracterizacion where id_cc_lider = estructuras.id) as total from estructuras where id_consejo = $_SESSION[id]";
                $crud->leer();
                if(count($crud->filas) > 0)
                {
                    foreach ($crud->filas as $row) 
                    {
                            $nombre = $row['nombre']." ".$row['apellido'];
                        ?>
                            {
                            "category": "<?php echo $nombre; ?>",
                            "total": <?php echo $row['total']; ?>
                            },
                            <?php   
                    }
                }   
            ?>
            ];


            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "category";
                chart.startDuration = 1;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.labelRotation = 90;
                categoryAxis.gridPosition = "start";

                 var valueAxis = new AmCharts.ValueAxis();
                    valueAxis.axisAlpha = 0;
                    valueAxis.integersOnly = true;
                    chart.addValueAxis(valueAxis);

                // value
                // in case you don't want to change default settings of value axis,
                // you don't need to create it, as one value axis is created automatically.

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.valueField = "total";
                graph.balloonText = "[[category]]: <b>[[value]]</b>";
                graph.type = "column";
                graph.lineAlpha = 0;
                graph.fillAlphas = 0.8;
                chart.addGraph(graph);

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.zoomable = false;
                chartCursor.categoryBalloonEnabled = false;
                chart.addChartCursor(chartCursor);

                chart.creditsPosition = "top-right";

                chart.write("chartdiv");
            });
	});
</script>