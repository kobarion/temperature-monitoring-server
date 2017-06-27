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
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    
    <title>Gráfico 4</title>

    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/estilo-controle.css" rel="stylesheet" type="text/css"/>
    <link href="css/estilo-tabela.css" rel="stylesheet" type="text/css"/>
    <link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/manifest.json">
    
    
    <script src="js/jquery.min.js" type="text/javascript"></script> 
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/bootbox.min.js" type="text/javascript"></script>
    <script src="js/highstock.js" type="text/javascript"></script>
    <script src="js/highcharts-more.js" type="text/javascript"></script>
    <script src="js/exporting.js" type="text/javascript"></script>
    <script src="js/moment.js" type="text/javascript"></script>
    <script src="js/combodate.js" type="text/javascript"></script>
    
    <script>
    var chart;
    $(function() {
            $( "#formdate" ).submit(function(){
                var objetos = this;
                var dados = new FormData(objetos);
                
                $.ajax({
                    type: "POST",
                    url: 'plotgrafico4.php',
                    data: dados,
                    processData: false,
                    cache: false,
                    contentType: false,
                    success: function (data) {
                    Highcharts.setOptions({
                        lang: {
                            exportButtonTitle: "Exportar",
                            printButtonTitle: "Imprimir",
                            rangeSelectorFrom: "De",
                            rangeSelectorTo: "Até",
                            rangeSelectorZoom: "Periodo",
                            downloadPNG: 'Salvar gráfico como imagem PNG',
                            downloadJPEG: 'Salvar gráfico como imagem JPEG',
                            downloadSVG: 'Salvar gráfico como imagem SVG',
                            downloadPDF: 'Salvar em documento PDF',
                            contextButtonTitle: 'Opções',
                            printChart: 'Imprimir gráfico'
                            }
                        }
                    );                        
                        chart = new Highcharts.stockChart('container', {

                            chart:{
                              renderTo: 'container'  
                            },
                            rangeSelector: {
                                selected: 1
                            },

                            title: {
                                text: 'Temperatura'
                            },

                            series: [{
                                name: 'sensor1',
                                data: data,
                                tooltip: {
                                    valueDecimals: 2
                                }
                            }]
                        });
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
                  <li><a href="grafico4.php">Gráfico 4</a></li>
                </ul>
              <li class="active"><a target="_blank" href="aquisicaodados.php">Server data</a></li>              
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="active"><a href="sair.php">Sair <span class="sr-only">(current)</span></a></li>
            </ul>
        </div><!--/.nav-collapse -->
        </div>
    </nav>

    <form id="formdate" name="formdate" >
        <div class="container" style="text-align: center">
            <label>Data inicial</label>
            <input type="text" id="date1" name="date1" data-format="YYYY-MM-DD HH:mm:ss" data-template="DD / MM / YYYY     HH : mm"  data-custom-class="form-control">
            <script>
                $(function(){
                    $('#date1').combodate({
                    maxYear: (new Date()).getFullYear(),  
                    smartDays: true,
                    value: new Date()
                    });
                });
            </script>

        </div> <!-- /container -->

        <div class="container" style="text-align: center">
            <label>&nbsp;Data final</label>
            <input type="text" id="date2" name="date2" data-format="YYYY-MM-DD HH:mm:ss" data-template="DD / MM / YYYY     HH : mm"  data-custom-class="form-control">
            <script>
            $(function(){
                $('#date2').combodate({
                    maxYear: (new Date()).getFullYear(),  
                    smartDays: true,
                    value: new Date()
                    });
                });
            </script>
        </div>

        <div class="container" style="margin: 20px auto">
        <div style="text-align: center">
            <button class="btn btn-primary" type="submit">Definir periodo</button>
        </div>
        </div>

    </form>    

    <div id="container" style="margin: 20px"></div>

    </body>
</html>

