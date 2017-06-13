<?php
session_start();

if($_SESSION['acesso'] != "true"){
    header('location:index.html');
}
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Controle de Temperatura</title>

    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/estilo-controle.css" rel="stylesheet" type="text/css"/>
    
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/bootbox.min.js" type="text/javascript"></script>
    <script src="js/highcharts.js" type="text/javascript"></script>
    
    <script>
		var chart; // global
		
		function requestData() {
			$.ajax({
				url: 'plotgrafico.php', 
				success: function(point) {
					var series = chart.series[0],
					shift = series.data.length > 40; 
					chart.series[0].addPoint(eval(point), true, shift);
					setTimeout(requestData, 3000);	
				},
				cache: false
			});
		}
			
		$(document).ready(function() {
                            Highcharts.setOptions({
                                global: {
                                timezoneOffset: 3 * 60
                                }
                            });

        
                            chart = new Highcharts.Chart({
				chart: {
					renderTo: 'container',
					defaultSeriesType: 'spline',
					spacingLeft: 10,
                                        spacingRight:10,
                                        spacingTop:10,
                                        events: {
						load: requestData
					}
				},
				title: {
					text: 'Temperatura'
				},
				xAxis: {
					type: 'datetime',
					tickPixelInterval: 50,
					maxZoom: 20 * 1000
				},
				yAxis: {
					minPadding: 0.2,
					maxPadding: 0.2,
					title: {
						text: 'Temp (ºC)',
						margin: 10
					}
				},
				series: [{
					name: 'Sensor 1',
					data: []
					}]
			});
                        
		});
		</script>
    
  </head>
  <body>
     <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Projeto</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Botão 1</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Opções <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">opção 1</a></li>
                <li><a href="#">opção 2</a></li>
                <li><a href="#">opção 3</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Mais opções</li>
                <li><a href="#">opção 4</a></li>
                <li><a href="#">opção 5</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="sair.php">Sair <span class="sr-only">(current)</span></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
    <div class="container">
        <h4>Bem vindo <?php echo $_SESSION['nome'];?></h4>
    </div>
    <div id="container"></div>
		
    <div class="container" style="margin: 20px auto">
    <div style="text-align: center">
        <a target="_blank" href="aquisicaodados.php" class="btn btn-primary btn-lg active" role="button">Server data</a>
    </div> 
    </div>
    
    <div class="container">
         <table class="table table-striped">
        <tr>
            <td>ID</td>
            <td>SENSOR</td>
            <td>TEMPERATURA</td>
            <td>DATA</td> 
        </tr>
        <?php
            include "config/config.php";

            $sql="SELECT id, sensor, temp, date FROM dados";
            $result=mysqli_query($connect,$sql);

            while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                echo "<tr>";
                echo    "<td>".$row["id"]."</td>";
                echo    "<td>".$row["sensor"]."</td>";
                echo    "<td>".$row["temp"]."</td>";
                echo    "<td>".$row["date"]."</td>";
                echo "</tr>";           
            }
        ?>
        </table>          
     </div>
    
  </body>
</html>