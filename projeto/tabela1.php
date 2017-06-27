<?php
session_start();

if($_SESSION['acesso'] != "true"){
    header('location:index.html');
}

$_SESSION['date1'] = $_POST['date1'];
$_SESSION['date2'] = $_POST['date2'];

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
    
    <title>Tabela</title>

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
    <script src="js/highcharts.js" type="text/javascript"></script>
    <script src="js/moment.js" type="text/javascript"></script>
    <script src="js/combodate.js" type="text/javascript"></script>    
    
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
            </li>
            <li class="active"><a target="_blank" href="aquisicaodados.php">Server data</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="sair.php">Sair <span class="sr-only">(current)</span></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
    <div class="container" style="text-align: center">
        <h4>Data Inicial : <?php echo $_SESSION['date1'];?></h4>
        <h4>Data Final   : <?php echo $_SESSION['date2'];?></h4>
    </div>
    
    <div class="container" style="margin: 20px auto">
        <div style="text-align: center">
            <a href="tabela.php" class="btn btn-primary active" role="button">Definir novo período</a>            
        </div>
    </div>
        
    <div class="container">
        <table class="table table-striped" id="tableID">
        <tr>
            <td>ID</td>
            <td>SENSOR</td>
            <td>TEMPERATURA</td>
            <td>DATA</td> 
        </tr>
               
        <?php
            include "config/config.php";
            
            $date1 = $_SESSION['date1'];
            $date2 = $_SESSION['date2'];
            
            $sql="SELECT id, sensor, temp, date FROM dados WHERE date BETWEEN '$date1' AND '$date2'";
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