<?php
    include("../includes/con_db.php");
    session_start();
    $data = $_POST["data"];
    $tipo = $_POST["select"];
    $subTipo = $_POST["select-sub"];
    $desc = $_POST["desc"];
    $longDesc = $_POST["desc-long"];
    $valor = str_replace(".", "", $_POST["valor"]);
    $valor = str_replace(",", ".", $valor);
    $valor = floatval($valor);
    $user_id = $_SESSION["id_usuario"];
    $result = array();

    $sql = "INSERT INTO lancamentos VALUES (NULL, '$user_id', '$data', '$tipo', '$subTipo', '$desc', '$longDesc', '$valor')";
    
    if(mysqli_query($con, $sql)){
        $result["return"] = "sucesso";
    }else{
        $result["return"] = "erro";
    }

    mysqli_close($con);
    echo json_encode($result);

?>