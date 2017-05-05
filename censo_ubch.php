<?php
	require_once "encabezado.php";
?>
<div class="row">
	<div class="container-fluid">
		<div class="col-md-12">
			<table class="table table-strepead table-hover" id="tabla">
				<thead>
					<th class="text-center">Nac</th>
					<th class="text-center">cédula</th>
					<th class="text-center">Nombre</th>
					<th class="text-center">Apellido</th>
					<th class="text-center">Cargo</th>
					<th class="text-center">UBCH</th>
					<th class="text-center"></th>
				</thead>
				<tbody class="text-center">
					<?php
						$crud->sql = "SELECT id, nac, cedula, (SELECT descripcion from ubch_cargoss where id_cargo = ubch.id_cargo) as cargo,
										(SELECT count(*) from caracterizacion where id_ubch_lider = ubch.id) as conformantes from ubch where $_SESSION[ubch]";
						$crud->leer();
                        $total = count($crud->filas);
                        if($total > 0)
                        {
                            foreach ($crud->filas as $row) 
                            {
                                $crud->sql = "SELECT primer_ape, segundo_ape, primer_nom, segundo_nom from rep_nueva2 where cedula = ".$row['cedula'];
                                $crud->leer();
                                if($crud->filas[0]['primer_ape'] == "")
                                {   
                                }
                                else
                                {
                                    foreach ($crud->filas as $fila) 
                                    {   
                                        $data = ["$fila[primer_nom] "."$fila[primer_ape]" => $row['id']];
                                        $boton = "<a href='conformantes_ubch.php?id=".base64_encode($row['id'])."' class='btn btn-danger btn-xs' data->Ver <span class='glyphicon glyphicon-user'></span></a>";

                                        echo "<tr>
                                                <td>$row[nac]</td>
                                                <td>$row[cedula]</td>
                                                <td>".$fila['primer_nom']." ".$fila['segundo_nom']."</td>
                                                <td>".$fila['primer_ape']." ".$fila['segundo_ape']."</td>
                                                <td>".$row['cargo']."</td>
                                                <td>".$row['conformantes']."</td>
                                                <td>".$boton."</td>
                                            </tr>"; 
                                    }
                                }
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
                                    <td></td>
                                </tr>"; 
    				    }		
					?>
				</tbody>
			</table>
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
<script src="js/amcharts/amcharts.js" type="text/javascript"></script>
<script src="js/amcharts/serial.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){
		$("#tabla").dataTable({
			"language" : {"url" : "json/esp.json"}
		});

		var chart;
            var graph;
            var chartData = [
            <?php 
            	$crud->sql = "SELECT id, (SELECT count(*) from caracterizacion where id_ubch_lider = ubch.id) as total from ubch where id_centro = ".$_SESSION['ubch'];
            	$crud->leer();
            	foreach ($crud->filas as $row) 
            	{
            			$nombre = array_search($row['id'], $data);
            		?>
	            		{
	                    "category": "<?php echo $nombre; ?>",
	                    "total": <?php echo $row['total']; ?>
	                	},
	                	<?php	
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