<?php
    
include "config/config.php";

session_start();

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

$resultado = $connect->query("SELECT * FROM usuario WHERE usuario= '$usuario' AND senha = '$senha'");

if(mysqli_num_rows($resultado) > 0){

    while($dados = $resultado->fetch_array()){
        $nome = $dados['nome'];
    }
    $_SESSION['nome'] = $nome;
    $_SESSION['acesso'] = "true";
    
    echo "login_ok";
    echo " ".$nome;
} else {
    
    unset($_SESSION['nome']);
    unset($_SESSION['acesso']);    
    
    echo "login_erro";
}

?>