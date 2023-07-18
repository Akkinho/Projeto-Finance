<?php
    require __DIR__ . "/includes/con_db.php";
    $lanc_id = $_GET["id"];
    $sql = "SELECT * FROM lancamentos WHERE id = $lanc_id";
    $query = mysqli_query($con, $sql);

    if($query){
        $assoc = mysqli_fetch_assoc($query);
        echo json_encode($assoc);
    }else{
        echo json_encode([]);
    }

    mysqli_close($con);
?>