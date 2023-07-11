<?php
    session_start();
    require __DIR__."/../includes/con_db.php";
    $user_id = $_SESSION["id_usuario"];
    $request = file_get_contents("php://input", true);
    $data = json_decode($request);
    $lancID = $_POST["lanc_id"];
    $date = $_POST["date-update"];
    $type = $_POST["select-update"];
    $subtype = $_POST["subtype-update"];
    $desc = $_POST["desc-update"];
    $longDesc = $_POST["desc-detalhada-update"];
    $valor = str_replace(".", "", $_POST["valor-update"]);
    $valor = str_replace(",", ".", $valor);
    $valor = floatval($valor);

    $result = [];

    if(!isset($lancID) || !isset($date) || !isset($type) || !isset($desc) || !isset($valor)){
        $result["return"] = "erro";
        http_response_code(400);
        echo json_encode($result);
        exit();
    }

    $sql = "UPDATE lancamentos SET datetime = ?, type = ?, subtype = ?, description = ?, long_description = ?, valores = ? WHERE id = ? AND user_id = ?";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssii", $date, $type, $subtype, $desc, $longDesc, $valor, $lancID, $user_id);
    mysqli_stmt_execute($stmt);

    if(mysqli_affected_rows($con) > 0){
        $result["return"] = "sucesso";
        $result["msg"] = "Lançamento Modificado";
        http_response_code(200);
    }else{
        $result["return"] = "erro";
        $result["msg"] = "Falho ao Modificar Lançamento";
        http_response_code(500);
    }
    echo json_encode($result);

    mysqli_stmt_close($stmt);
    mysqli_close($con);
?>