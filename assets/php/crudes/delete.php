<?php
    session_start();
    require __DIR__. "/../includes/con_db.php";
    $user_id = $_SESSION["id_usuario"];
    $request = file_get_contents("php://input", true);
    $data = json_decode($request);
    $id = $_GET["lanc_id"];
    $sql = "DELETE FROM lancamentos WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
    mysqli_stmt_execute($stmt);

    if(mysqli_affected_rows($con) > 0){
        echo json_encode(array("msg" => "Lançamento excluído"));
        http_response_code(200);
    }else{
        echo json_encode(array("erro" => "Erro ao excluir lançamento"));
        http_response_code(500);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
?>