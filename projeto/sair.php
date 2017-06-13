<?php

session_start();

unset($_SESSION['nome']);
unset($_SESSION['acesso']);

session_destroy();

header('location:index.html');

?>
