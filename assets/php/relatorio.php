<?php
    session_start();
    require __DIR__ . "includes/con_db.php";
    $user_id = $_SESSION["id_usuario"];

    $sql = "SELECT DISTiNCT DATE_FORMAT(datetime, '%m-%Y') as anoMes, datetime FROM lancamentos WHERE user_id = ? ORDER BY datetime DESC";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    $meses = array();
    while($assoc = mysqli_fetch_assoc($res)){
        $anoMeses = explode("-", $assoc["anoMes"]);
        $mes = $anoMeses[0];
        $ano = $anoMeses[1];

        $sql = "SELECT SUM(valores) AS despesas FROM lancamentos WHERE user_id = ? AND type = 'despesa' AND MONTH(datetime) = ? AND YEAR(datetime) = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "iii", $user_id, $mes, $ano);
        mysqli_stmt_execute($stmt);
        $resDesp = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($resDesp) > 0){
            $assocDesp = mysqli_fetch_assoc($resDesp);
            $despesas = $assocDesp["despesas"];
        }

        $sql = "SELECT SUM(valores) AS renda FROM lancamentos WHERE user_id = ? AND type = 'renda' AND MONTH(datetime) = ? AND YEAR(datetime) = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "iii", $user_id, $mes, $ano);
        mysqli_stmt_execute($stmt);
        $resRenda = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($resRenda) > 0){
            $assocRenda = mysqli_fetch_assoc($resRenda);
            $renda = $assocRenda["renda"];
        }

        $lucro = $renda - $despesas;

        $meses[] = [
            "month" => $mes,
            "ano" => $ano,
            "despesas" => number_format($despesas, 2, ",", "."),
            "renda" => number_format($renda, 2, ",", "."),
            "lucro" => number_format($lucro, 2, ",", ".")
        ];
    }

    usort($meses, function($a, $b){
        return strtotime($a["ano"]."-".$a["mes"]."-01") - strtotime($b["ano"]."-".$b["mes"]."-01");
    });
    echo json_encode($meses);

    mysqli_close($con);
?>