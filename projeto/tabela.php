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
    <link href="css/estilo-tabela.css" rel="stylesheet" type="text/css"/>
    
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/bootbox.min.js" type="text/javascript"></script>
    <script src="js/highcharts.js" type="text/javascript"></script>
    <script src="js/moment.js" type="text/javascript"></script>
    <script src="js/combodate.js" type="text/javascript"></script>    
    
    <script type="text/javascript">
        
        $(function() {
            $( "#formdate" ).submit(function(){
                var objetos = this;
                var dados = new FormData(objetos);
                
                $.ajax({
                    type: "POST",
                    url: '.php',
                    data: dados,
                    processData: false,
                    cache: false,
                    contentType: false,
                    success: function(resultado){
                        if(resultado.indexOf("dados_ok") >= 0){
                            // do something
                        } else if(resultado.indexOf("null_erro") >= 0){
                            bootbox.alert({
                                message: "Não existem registros nesse período.",
                                size: 'small',
                                backdrop: true
                            });
                        }
                    }
                });
                return false;

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
          <a class="navbar-brand" href="controle.php">Projeto</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="tabela.php">Tabela</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Opções <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="grafico1.php">Gráfico 1</a></li>
                <li><a href="grafico2.php">Gráfico 2</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Mais opções</li>
                <li><a href="#">opção 4</a></li>
              </ul>
            </li>
            <li class="active"><a target="_blank" href="aquisicaodados.php">Server data</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="sair.php">Sair <span class="sr-only">(current)</span></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    		
 <!--   <form>
        <div class="container" style="margin: 5px auto">
        <h4 class="form-control-heading text-center">Escolha o periodo de seleção:</h4>
        <input type="text" id="time1" data-format="DD-MM-YYYY HH:mm" data-template="DD / MM / YYYY     HH : mm" name="datetime" data-custom-class="form-control" style="margin: 10px">
            <script>
                $(function(){
                    $('#time1').combodate({
                    maxYear: (new Date()).getFullYear(),  
                    smartDays: true,
                    value: new Date()
                    });
                });
            </script>
        <input type="text" id="time2" data-format="DD-MM-YYYY HH:mm" data-template="DD / MM / YYYY     HH : mm" name="datetime" data-custom-class="form-control" style="margin: 10px">
            <script>
            $(function(){
                $('#time2').combodate({
                maxYear: (new Date()).getFullYear(),  
                smartDays: true,
                value: new Date()
                });
            });
            </script>
        <button class="btn btn-sm btn-primary" type="submit" style="text-align: center">Definir periodo</button>
        </div>
    </form>-->
    <form id="formdate" name="formdate">
        <div class="container" style="text-align: center">
            <label>Data inicial</label>
            <input type="text" id="time1" name="time1" data-format="DD-MM-YYYY HH:mm" data-template="DD / MM / YYYY     HH : mm"  data-custom-class="form-control">
            <script>
                $(function(){
                    $('#time1').combodate({
                    maxYear: (new Date()).getFullYear(),  
                    smartDays: true,
                    value: new Date()
                    });
                });
            </script>

        </div> <!-- /container -->

        <div class="container" style="text-align: center">
            <label>&nbsp;Data final</label>
            <input type="text" id="time2" name="time2" data-format="DD-MM-YYYY HH:mm" data-template="DD / MM / YYYY     HH : mm"  data-custom-class="form-control">
            <script>
            $(function(){
                $('#time2').combodate({
                maxYear: (new Date()).getFullYear(),  
                smartDays: true,
                value: new Date()
                });
            });
            </script>
        </div>
        <div class="container" style="margin: 20px auto">
        <div style="text-align: center">
            <button type="submit" class="btn btn-primary">Definir periodo</button>
        </div>
        </div>
    </form>  
        
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
