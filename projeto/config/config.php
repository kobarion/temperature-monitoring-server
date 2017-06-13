<?php

    $servidor = "localhost";
    $usuario = "root";
    $senha = "usbw";
    $banco = "bdprojeto";
    
    $connect = mysqli_connect($servidor, $usuario, $senha, $banco);
    
    if(mysqli_connect_error($connect)){
        echo "An error has ocurred.";
    } else{
        //echo "Conectou com sucesso";
    }

?>