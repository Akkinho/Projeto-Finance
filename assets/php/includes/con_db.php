<?php
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $dbname     = "faixa";

    $con = mysqli_connect($servername, $username, $password, $dbname);

    if(!$con){
        die("Falha na Conexão: ".mysqli_connect_error());
    }
?>