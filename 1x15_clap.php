<?php
	require_once "encabezado.php";
?>
	<div class="row">
		<div class="container-fluid">
			<div class="col-md-12">
				<table class="table table-streped table-bordered table-hover table-collapse" id="tabla">
					<thead>
						<th style="text-align: center;">Cédula</th>
	                    <th style="text-align: center;">Nombre y Apellido</th>
	                    <th style="text-align: center;">Ente</th>
	                    <th style="text-align: center;">Télefono</th>
	                    <th style="text-align: center;">Rol</th>
	                    <th style="text-align: center;">1x15</th>
					</thead>
	                <tbody style="text-align: center;">
	                    <?php
	                        $crud->sql = "SELECT id_usu_det,nom_usu,ape_usu, ced, telf, id_rol,
	                        (SELECT descripcion from rol where id_rol = reg_usuarios_det.id_rol) as rol, 
	                        (SELECT descripcion from entes where id_ente = reg_usuarios_det.id_ente) as ente
	                        from reg_usuarios_det where id_usu = $_SESSION[clap] and id_ente <> ''";
	                        $crud->leer();
                            $total = count($crud->filas);
                            if($total > 0)
                            {
                                foreach ($crud->filas as $row) 
                                {
                                    $crud->sql = "SELECT id from 1x15_clap where id_lider_1x15 = $row[id_usu_det]";
                                    $crud->total();
                                    $integrantes = $crud->total;

                                    if($row['id_rol'] == 1)
                                    {
                                        $rol = "1.".$row['rol'];
                                    }
                                    else
                                    {
                                        $rol = $row['rol'];
                                    }
                                    $boton = "<a href='conformantes_1x15.php?id=".base64_encode($row['id_usu_det'])."' class='btn btn-danger btn-sm'>$integrantes&nbsp;&nbsp;<span class='glyphicon glyphicon-user'></span></a>";
                                    echo "<tr>
                                            <td>".$row['ced']."</td>
                                            <td>".$row['nom_usu']." ".$row['ape_usu']."</td>
                                            <td>".$row['ente']."</td>
                                            <td>".$row['telf']."</td>
                                            <td>".$rol."</td>
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
			order : [4, "asc"]
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