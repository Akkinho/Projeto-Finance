<?php
    include_once("includes/con_db.php");

    header("Content-Type: application/json");
    $request = file_get_contents("php://input");
    $data = json_decode($request);
    $name = $data->name;
    $email = $data->email;
    $password = $data->password;
    $confPassword = $data->confPass;
    $result = array();

    if(empty($name)){
        $result["erroName"] = "Insira um nome de usuario";
    }else if(!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $name)){
        $result["erroName"] = "O nome de usuario deve ter entre 3 e 23 caracteres e não pode conter caracteres especiais";
    }

    if(empty($email)){
        $result["erroEmail"] = "Insira um email";
    }else{
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $query = mysqli_query($con, $sql);
        if(!$query){
            $result["conErro"] = "erro";
        }

        if(mysqli_num_rows($query) > 0){
            $result["erroEmail"] = "Email já existe";
        }
    }

    if(empty($password)){
        $result["erroPassword"] = "Insira uma senha";
    }else if(strlen($password) < 6){
        $result["erroPassword"] = "Senha deve conter no mínimo 6 dígitos";
    }else if(!preg_match('/[0-9]/', $password) || !preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)){
        $result["erroPassword"] = "Senha deve conter pelo menos um número e um caracter especial";
    }

    if(empty($confPassword)){
        $result["erroConfPass"] = "Confirme sua senha";
    }

    if(count($result) == 0){
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users VALUES (NULL, '$name', '$email', '$pass_hash')";
        $query = mysqli_query($con, $sql);

        if(!$query){
            $result["conErro"] = "erro";
            $result["return"] = "erro";
        }else{
            $result["return"] = "sucesso";
            $result["redirect"] = "login.php";
        }
    }else{
        $result["return"] = "erro";
    }
    echo json_encode($result);
?>