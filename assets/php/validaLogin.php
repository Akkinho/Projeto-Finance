<?php 
    session_start();
    include_once("includes/con_db.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        header("Content-Type: application/json");
        $request = file_get_contents("php://input");
        $data = json_decode($request);
        $email = $data->email;
        $password = $data->password;
        $result = array();

        if(empty($email)){
            $result["erroEmail"] = "Insira um email";
            $result["return"] = "erro";
        }else if(empty($password)){
            $result["erroPassword"] = "Insira uma senha";
            $result["return"] = "erro";
        }else{
            $sql = "SELECT * FROM users WHERE email='$email'";
            $query = mysqli_query($con, $sql);

            if(mysqli_num_rows($query) == 1){
                $fAssoc = mysqli_fetch_assoc($query);
                if(password_verify($password, $fAssoc["password"])){
                    $result["return"] = "sucesso";
                    $_SESSION["usuario"] = $fAssoc["username"];
                    $_SESSION["id_usuario"] = $fAssoc["id"];
                    $result["redirect"] = "index.php";
                }else{
                    $result["erroPassword"] = "Senha incorreta";
                    $result["return"] = "erro";
                }
            }else{
                $result["erroEmail"] = "Email não cadastrado";
                $result["return"] = "erro";
            }
        }
        echo json_encode($result);
    }
?>

