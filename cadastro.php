<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/cadastro.css">
    <title>Cadastro</title>
</head>
<body>
    <div class="corpo">
        <header>
            <h2>Criar Conta</h2>
        </header>
        <form action="assets/php/validaCadastro.php" class="form" id="form" method="post">
            <div class="form-corpo">
                <label for="username">Username</label>
                <input type="text" autocomplete="off" id="username" name="username" placeholder="Username">
                <div class="erroMsg"></div>
            </div>
            <div class="form-corpo">
                <label for="email">Email</label>
                <input class="verde" autocomplete="off" type="email" id="email" name="email" placeholder="Email">
                <div class="erroMsg"></div>
            </div>
            <div class="form-corpo">
                <label for="password">Password</label>
                <input type="password" id="password" class="password" name="password" placeholder="Password">
                <div class="erroMsg"></div>
            </div>
            <div class="form-corpo">
                <label for="Confpass">Confirm Password</label>
                <input type="password" id="confPass" name="confPass" placeholder="Confirm Password">
                <div class="erroMsg"></div>
            </div>
            <button type="submit" id="btn">Cadastrar</button>
        </form>
        <footer>
            <h5>Já tem uma conta?</h5>
            <h3><a href="login.php">Faça Login</a></h3>
        </footer>
    </div>
    <script src="assets/js/validaCadastro.js"></script>
</body>
</html>