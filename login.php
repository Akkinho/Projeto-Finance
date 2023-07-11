<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Login</title>
</head>
<body>
    <div class="corpo">
        <header>
            <h2>Entrar em Sua Conta</h2>
        </header>
        <form action="assets/php/validaLogin.php" class="form" id="loginForm" method="post">
            <div class="form-corpo">
                <label for="email">Email</label>
                <input type="email" autocomplete="off" id="email" name="email" placeholder="Email">
                <div class="erroMsg"></div>
            </div>
            <div class="form-corpo">
                <label for="password">Password</label>
                <input type="password" autocomplete="off" id="password" class="password" name="password" placeholder="Password">
                <div class="erroMsg"></div>
            </div>
            <button type="submit">Login</button>
        </form>
        <footer>
            <h5>Não tem uma conta?</h5>
            <h3><a href="cadastro.php">Faça seu cadastro</a></h3>
        </footer>
    </div>
    <script src="assets/js/validaLogin.js"></script>
</body>
</html>