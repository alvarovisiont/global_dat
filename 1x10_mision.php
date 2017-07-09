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
					<th class="text-center">Conformantes</th>
				</thead>
				<tbody class="text-center">
				<?php
					$crud->sql = "SELECT id, nombre, apellido, cedula, nac, telefono FROM estructuras WHERE id_mision = $_SESSION[id]";
					$crud->leer();
					if(count($crud->filas) > 0)
					{
						foreach ($crud->filas as $row) 
						{
							$crud->sql = "SELECT id from caracterizacion where id_mision_lider = $row[id] and estado = $_SESSION[estado] and municipio = $_SESSION[municipio]";
							$crud->total();
							$boton = "<a href='1x10_conformantes_mision.php?id_mision=".base64_encode($row['id'])."' data-toggle='modal' class='btn btn-danger btn-sm' title='editar'>
							$crud->total&nbsp;&nbsp;<span class='glyphicon glyphicon-user'></span></a>";
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
			order: [1 , "asc"]
		});

		 var chart;
            var graph;
            var chartData = [
            <?php 
                $crud->sql = "SELECT nombre, apellido, 
                                (SELECT count(*) from caracterizacion where id_mision_lider = estructuras.id) as total FROM estructuras WHERE id_mision = $_SESSION[id]";
                $crud->leer();
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
                    
            ?>
            ];

		 AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "category";
                chart.startDuration = 1;
                chart.autoGridCount = false;
                chart.gridCount = 10;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.labelRotation = 90;
                categoryAxis.gridPosition = "start";

                //value
                 
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