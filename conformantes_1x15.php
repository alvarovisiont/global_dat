<?php
	require_once "encabezado.php";
	$id = base64_decode($_GET['id']);
?>
		
	<div class="row">
		<div class="container-fluid">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-4">
						<button class="btn btn-success btn-block" data-toggle="modal" data-target="#modal_agg">Agregar nuevo integrante&nbsp;&nbsp;<span class="glyphicon glyphicon-plus"></span></button>
					</div>
				</div>
				<br>
				<br>
				<br>
				<div class="form-group">
					<div class="col-md-12">
						<table class="table table-streped table-bordered table-hover table-collapse" id="tabla">
							<thead>
								<th style="text-align: center;">Nac</th>
								<th style="text-align: center;">Cédula</th>
			                    <th style="text-align: center;">Nombre y Apellido</th>
			                    <th style="text-align: center;">Télefono</th>
			                    <th style="text-align: center;">Centro Votación</th>
							</thead>
			                <tbody style="text-align: center;">
			                    <?php
			                       	$crud->sql = "SELECT cedula, nac, nombre, apellido, telefono, 
			                       					(SELECT descripcion from centro_v where cod_viejo = 1x15_clap.centro_votacion) as centro_votacion from 1x15_clap where id_lider_1x15 = $id";
			                        $crud->leer();
			                        if(count($crud->filas) > 0)
			                        {	foreach ($crud->filas as $row) 
			                        	{
			                            echo "<tr>
			                                    <td>".$row['nac']."</td>
			                                    <td>".$row['cedula']."</td>
			                                    <td>".$row['nombre']." ".$row['apellido']."</td>
			                                    <td>".$row['telefono']."</td>
			                                    <td>".$row['centro_votacion']."</td>
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
			                        		</tr>";
			                        }
			                    ?>
			                </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="modal_agg" class="modal fade" role="dialog">
	    <div class="modal-dialog" style="width: 70%">
	        <div class="modal-content">
	            <div class="modal-header login-header">
	                <button type="button" class="close" data-dismiss="modal">×</button>
	                <h4 class="modal-title">Agregar Integrante&nbsp;<span class="glyphicon glyphicon-user"></span></h4>
	            </div>
                <div class="modal-body">
                    <div class="row">
                    	<div class="col-md-offset-4 col-md-4 text-center">
                    		<p  id="aviso" class="label label-danger" style="color: white; font-weight: bold; font-size: 12px;"></p>
                    	</div>
                    	<div class="col-md-12">
                    		<table class="table table-bordered table-streped table-hover" id="tabla1">
                    			<thead>
                    				<th class="text-center">Nac</th>
                    				<th class="text-center">Cédula</th>
                    				<th class="text-center">Nombre</th>
                    				<th class="text-center">Apellido</th>
                    				<th class="text-center">Telf</th>
                    				<th></th>
                    			</thead>
                    			<tbody>
                    				<?php
			                    		$crud->sql = "SELECT id_usu, nom_usu, ape_usu, ced, nac, telf from reg_personas_jf where id_clap1 = 			$_SESSION[clap] and ced <> ''
			                    						UNION 
			                    						SELECT id_usu_det, nom_usu, ape_usu, ced, nac, telf from reg_personas_det where id_clap1 = $_SESSION[clap] and ced <> ''";
			                    			$crud->leer1();
			                    			foreach ($crud->filas as $row) 
			                    			{
			                    				$button = "<button type='button' class='btn btn-block btn-sm agregar' style='background-color: #C5624D; color: white;' 
			                    					data-integrante='$row[id_usu]' 
			                    					data-nombre='$row[nom_usu]'
			                    					data-apellido= '$row[ape_usu]'
			                    					data-cedula= '$row[ced]'
			                    					data-nac= '$row[nac]'
			                    					data-telefono= '$row[telf]'
			                    					data-clap = '$_SESSION[clap]'
			                    					data-id_clap_lider = '$id'>Agregar</button>";
			                    				echo "<tr>
			                    						<td>$row[nac]</td>			
			                    						<td>$row[ced]</td>
			                    						<td>$row[nom_usu]</td>
			                    						<td>$row[ape_usu]</td>
			                    						<td>$row[telf]</td>
			                    						<td>".$button."</td>
			                    					</tr>";
			                    			}
		                    		?>
                    			</tbody>
                    		</table>
                    	</div>
                	</div>
                </div>
                <div class="modal-footer">
                </div>
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
<script type="text/javascript">
	$(function(){
		$("#tabla").dataTable({
			"language" : {"url" : "json/esp.json"},
			order : [4, "asc"]
		});
		$("#tabla1").dataTable({
			"language" : {"url" : "json/esp.json"},
			order : [1, "asc"]
		});

		$("#tabla1 > tbody").on('click', "tr > td > .agregar", function(){
			
			var id = $(this).data('integrante'),
				nombre = $(this).data('nombre'),
				apellido = $(this).data('apellido'),
				cedula = $(this).data('cedula'),
				nac = $(this).data('nac'),
				telefono = $(this).data('telefono'),
				clap = $(this).data('clap'),
				id_lider = $(this).data('id_clap_lider');

				$.ajax({
					url: "grabar_1x15_clap.php",
					type: "POST",
					dataType: "JSON",
					data: {id: id, nombre: nombre, apellido: apellido, cedula: cedula, nac: nac, telefono: telefono, clap: clap, id_lider: id_lider, accion: "agregar"},
					success: function(data)
					{
						if(typeof(data.exito) != "undefined")
						{
							swal({
							title: "Integrante Agregado",
							type: "success",
							showButtonCancel: false,
							confirmButtonText: "Cerrar",
							confirmButtonClass: "btn btn-info",
							closeOnConfirm: true
							},function(confirm){
								if(confirm)
								{
                                    $("#tabla1 > tbody").on('keypress', "tr > td > .agregar", function(e){
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
							setTimeout(function(){
								$("#aviso").hide('slow/400/fast');
							}, 2000);
						}
					}
				});
		});

		 var chart;
            var graph;
            var chartData = [
            <?php 
                $crud->sql = "SELECT nom_usu,  ape_usu, id_usu_det from reg_usuarios_det where id_usu = $_SESSION[clap] and id_ente <> ''";
                $crud->leer();
                foreach ($crud->filas as $row) 
                {
                    $crud->sql = "SELECT id from 1x15_clap where id_lider_1x15 = $row[id_usu_det]";
                    $crud->total();
                    if($crud->total > 0)
                    {
                        $nombre = $row['nom_usu']." ".$row['ape_usu'];
                    ?>
                        {
                        "category": "<?php echo $nombre; ?>",
                        "total": <?php echo $crud->total; ?>
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