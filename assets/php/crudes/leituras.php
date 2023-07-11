<?php
    require __DIR__ . "/../includes/session.php";
    require __DIR__ . "/../includes/con_db.php";
    $user_id = $_SESSION["id_usuario"];

    if(isset($_GET["lanc_id"])){
        $lancID = $_GET["lanc_id"];
        $sql = "SELECT long_description FROM lancamentos WHERE id = ".$lancID;
        $query = mysqli_query($con, $sql);
        if(mysqli_num_rows($query) > 0){
            $assoc = mysqli_fetch_assoc($query);
            $longDesc = $assoc["long_description"];
            echo $longDesc;
        }else{
            echo "Nenhuma Registro Efetuado";
            echo mysqli_error($con);
        }
        exit; 
    }

    $clause = "";

    if(isset($_GET["month"])){
        $anoMes = explode('-', $_GET["month"]);
        $ano = $anoMes[0];
        $mes = $anoMes[1];

        $clause = "WHERE user_id = '$user_id' AND MONTH(datetime) = $mes";
        if(isset($ano)){
            $clause .= " AND YEAR(datetime) = $ano";
        }
        
        $sql = "SELECT * FROM lancamentos $clause ORDER BY datetime DESC";
        $query = mysqli_query($con, $sql);

        if(mysqli_num_rows($query) > 0){
            while($assoc = mysqli_fetch_assoc($query)){
                $datetime = date("d/m/Y", strtotime($assoc["datetime"]));
                $type = $assoc["type"];
                $subtype = $assoc["subtype"];
                $desc = $assoc["description"];
                $valores = number_format($assoc["valores"], 2, ",", ",");

                echo "<tr>"; 
                echo "<td>" . $datetime . "</td>";
                echo "<td>" . $type . "</td>";
                echo "<td>" . $subtype . "</td>";
                echo "<td>" . $desc . "</td>";
                echo "<td>" . $valores . " " . "R$" . "</td>";
                echo "<td class='icon-container'>";
                echo "<i class='bi bi-eye view-icon' data-id= '"  . $assoc['id'] . "'></i>";
                echo "<i class='bi bi-pencil-square update-icon' data-id='"   . $assoc['id'] . "'></i>";
                echo "<i class='bi bi-trash delete-icon' data-id='"   . $assoc['id'] . "' ></i>";
                echo "</td>";
                echo "</tr>";
            }
        }else{
            echo "<tr><td colspan='6'>Nenhum Registro Efetuado</td></tr>";
        }
    }else{
        echo "<tr><td colspan='6'>Nenhum Registro Efetuado</td></tr>";
    }
    
    mysqli_close($con);
?>