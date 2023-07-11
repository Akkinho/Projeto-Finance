<?php
    session_start();
    require __DIR__."/includes/con_db.php";
    $user_id = $_SESSION["id_usuario"];

    if(isset($_GET["month"])){
        $anoMes = explode("-", $_GET["month"]);
        $ano = $anoMes[0];
        $mes = $anoMes[1];
        $sql = "SELECT SUM(valores) AS despesas FROM lancamentos WHERE user_id = ? AND type = 'despesa' AND MONTH(datetime) = ? AND YEAR(datetime) = ?";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "iii", $user_id, $mes, $ano);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($res) > 0){
            $assoc = mysqli_fetch_assoc($res);
            $despesas = $assoc["despesas"];
        }

        $sql = "SELECT SUM(valores) AS renda FROM lancamentos WHERE user_id = ? AND type = 'renda' AND MONTH(datetime) = ? AND YEAR(datetime) = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "iii", $user_id, $mes, $ano);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($res) > 0){
            $assoc = mysqli_fetch_assoc($res);
            $renda = $assoc["renda"];
        }

        $lucro = $renda - $despesas;
        echo json_encode([
            "despesas" => number_format($despesas, 2, ",", "."),
            "renda" => number_format($renda, 2, ",", "."),
            "lucro" => number_format($lucro, 2, ",", ".")
        ]);

        mysqli_close($con);
    }

?>