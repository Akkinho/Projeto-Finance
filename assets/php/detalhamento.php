<?php
    session_start();
    require __DIR__ . "/includes/con_db.php";
    $user_id = $_SESSION["id_usuario"];

    $sql = "SELECT DISTINCT DATE_FORMAT(datetime, '%m-%Y') AS monthYear, datetime FROM lancamentos WHERE user_id = ? ORDER BY datetime DESC";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $meses = array();
    while ($assoc = mysqli_fetch_assoc($result)){
        $anoMes = explode("-", $assoc["monthYear"]);
        $mes = $anoMes[0];
        $ano = $anoMes[1];

        $sql = "SELECT SUM(valores) AS despesas FROM lancamentos WHERE user_id = ? AND type = 'despesa' AND MONTH(datetime) = ? AND YEAR(datetime) = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "iii", $user_id, $mes, $ano);
        mysqli_stmt_execute($stmt);
        $resultDespesa = mysqli_stmt_get_result($stmt);
        
        if(mysqli_num_rows($resultDespesa) > 0){
            $assocDespesa = mysqli_fetch_assoc($resultDespesa);
            $despesas = $assocDespesa["despesas"];
        }

        $sql = "SELECT SUM(valores) AS renda FROM lancamentos WHERE user_id = ? AND type = 'renda' AND MONTH(datetime) = ? AND YEAR(datetime) = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "iii", $user_id, $mes, $ano);
        mysqli_stmt_execute($stmt);
        $resultRenda = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($resultRenda) > 0){
            $assocRenda = mysqli_fetch_assoc($resultRenda);
            $renda = $assocRenda["renda"];
        }

        $lucro = $renda - $despesas;

        $meses[] = [
            "mes" => $mes,
            "ano" => $ano,
            "despesas" => number_format($despesas, 2, ",", "."),
            "renda" => number_format($renda, 2, ",", "."),
            "lucro" => number_format($lucro, 2, ",", ".")
        ];
    }

    usort($meses, function($a, $b){
        return strtotime($a["ano"] . "-" . $a["mes"] . "-01") - strtotime($b["ano"] . "-" . $b["mes"] . "-01");
    });

    $mesesUnique = array_unique($meses, SORT_REGULAR);

    echo json_encode(array_values($mesesUnique));
    mysqli_close($con);
?>