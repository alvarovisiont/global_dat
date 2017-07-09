<?php
	require_once "encabezado.php";
?>
<div class="row">
	<div class="container-fluid">
		<div class="col-md-12">
			<table class="table table-strepead table hover" id="tabla">
				<thead>
					<th>Nac</th>
					<th>cédula</th>
					<th>Nombre</th>
					<th>Cargo</th>
				</thead>
				<tbody>
					<?php
                        $data = [];

                        if($_SESSION['estado'] == 17)
                        {
                            $crud->sql = "SELECT id,cedula, nombre, telefono, cargo,
                                        (SELECT count(*) from caracterizacion where id_ubch_lider = ubch_sucre.id and estado = $_SESSION[estado]) as conformantes from ubch_sucre where ubch = ".$_SESSION['ubch'];
                            $crud->leer();
                            if(count($crud->filas) > 0)
                            {
                                foreach ($crud->filas as $row) 
                                {
                                    if($row['conformantes'] > 0)
                                    {
                                        $data = ["$row[nombre]" => $row['id']];
                                    }
                                    echo "<tr>
                                                <td>".substr($row['cedula'], 0,1)."</td>
                                                <td>".substr($row['cedula'], 2)."</td>
                                                <td>".$row['nombre']."</td>
                                                <td>".$row['cargo']."</td>
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
                        }
                        else
                        {
                            $crud->sql = "SELECT id, nac, cedula, (SELECT descripcion from ubch_cargoss where id_cargo = ubch.id_cargo) as cargo,
                                        (SELECT count(*) from caracterizacion where id_ubch_lider = ubch.id) as conformantes from ubch where id_centro = ".$_SESSION['ubch'];    

                            $crud->leer();
                            if(count($crud->filas) > 0)
                            {
                                foreach ($crud->filas as $row) 
                                {
                                     $crud->sql = "SELECT primer_ape, segundo_ape, primer_nom, segundo_nom from rep_nueva2 where cedula = ".$row['cedula'];
                                    $crud->leer();
                                    if($crud->filas[0]['primer_ape'] == "")
                                    {
                                        echo $row['cedula']."<br>";
                                        echo "<tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>"; 
                                    }
                                    else
                                    {
                                        foreach ($crud->filas as $fila) 
                                        {   
                                            $data = ["$fila[primer_nom] "."$fila[primer_ape]" => $row['id']];
                                            echo "<tr>
                                                    <td>$row[nac]</td>
                                                    <td>$row[cedula]</td>
                                                    <td>".$fila['primer_nom']." ".$fila['segundo_nom']."</td>
                                                    <td>".$fila['primer_ape']." ".$fila['segundo_ape']."</td>
                                                    <td>".$row['cargo']."</td>
                                                    <td>".$row['conformantes']."</td>
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
                                    </tr>"; 
                            }
                        }
                        
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>



<div>
	<div>
		<div>
			<div id="agregar_estructura" class="modal fade" role="dialog">
			    <div class="modal-dialog">
			        <!-- Modal content-->
			        <div class="modal-content">
			            <div class="modal-header login-header">
			                <button type="button" class="close" data-dismiss="modal">×</button>
			                <h4 class="modal-title">Agregar Estructura</h4>
			            </div>
			            <form class="form-horizontal" id="form_estructura" action="grabar_poblacion.php" method="POST">
			                <input type="hidden" name="accion" value="estructura_clap">
			                <div class="modal-body">
			                    <div class="row">
			                        <div class="form-group">
			                            <label class="control-label col-md-3">Cédula</label>
			                            <div class="col-md-7">
			                                <input type="text" name="cedula" id="cedula" required="">
			                            </div>
			                        </div>
			                        <div class="form-group">
			                            <label class="control-label col-md-3">Nombre y Apellido</label>
			                            <div class="col-md-7">
			                                <input type="text" name="nombre_completo" id="nombre_completo" required="">
			                            </div>
			                        </div>
			                        <div class="form-group">
			                            <label class="control-label col-md-3">Teléfono</label>
			                            <div class="col-md-7">
			                                <input type="number" name="telefono" id="telefono" required="">
			                            </div>
			                        </div>
			                        <div class="form-group">
			                            <label class="control-label col-md-3">Rol</label>
			                            <div class="col-md-7">
			                                 <select class="form-control" required="" id="rol" name="rol">
			                                 <option></option>
			                                 <option></option>
			                                    <?php
			                                        $crud->sql = "SELECT id_forma_coman, fila from forma_coman where nom_formato = 'UBCH' and id_forma_coman <> 6 and id_forma_coman <> 4 and id_forma_coman <> 6";
			                                        $crud->leer();
			                                        foreach ($crud->filas as $row) 
			                                        {
			                                            echo "<option value='".$row['id_forma_coman']."'>".$row['fila']."</option>";
			                                        }
			                                    ?>
			                                </select>
			                            </div>
			                        </div>
			                        <br>
			                        <div class="text-center">
			                            <p class="label label-danger" style="color: white; font-weight: bold; font-size: 12px;" id="aviso"></p>
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
<script type="text/javascript" src="js/select2.min.js"></script>
<script src="js/amcharts/amcharts.js" type="text/javascript"></script>
<script src="js/amcharts/serial.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){

        $("#tabla").dataTable({
            "language" : {"url" : "json/esp.json"}
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

        //--------------------- gráficos----------------------------------

        var chart;
            var graph;
            var chartData = [
            <?php 
                if($_SESSION['estado'] == 17)
                {

                    $crud->sql = "SELECT id, (SELECT count(*) from caracterizacion where id_ubch_lider = ubch_sucre.id and estado = $_SESSION[estado] and municipio = $_SESSION[municipio]) as total from ubch_sucre where ubch = ".$_SESSION['ubch'];
                }
                else
                {
                    $crud->sql = "SELECT id, (SELECT count(*) from caracterizacion where id_ubch_lider = ubch.id and estado = $_SESSION[estado] and municipio = $_SESSION[municipio]) as total from ubch where id_centro = ".$_SESSION['ubch'];
                }

                $crud->leer();
                if(count($crud->filas) > 0)
                {
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
