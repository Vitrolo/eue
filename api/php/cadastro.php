<?php
session_start();

if (isset($_SESSION['nome'])) {
    header('location: ../index.php');
}


require_once ('../classes/crud_cadastro.php');
require_once ('../conexao/banco.php');

$database = new DataBase();
$db = $database->getConnection();
$crud = new Crud_cadastro($db);


if (isset($_GET['action'])){
    switch($_GET['action']){
        case 'criar':
            if ($crud->criar_cadastro($_POST)) {
                $rows = $crud->mostrar_cadastro();
                header('location: cadastro.php');
            }
            break;
        case 'mostrar':
            $rows = $crud->mostrar_cadastro();
    }
} else {
    $rows = $crud->mostrar_cadastro();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../CSS/cadastro.css">
  <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
</head>
<header>
    <nav>
        <a href="../index.php"><h2 class="logo"> Culinary <span> World </span> </h2></a>
        <ul>
        </ul>
        <div class="botoes">
            <a href="cadastro.php"><button type="button" class="botao-cadastrar"> Entrar ou Cadastrar </button></a>
        </div>
    </nav>
</header>

<body>
    <div class="centralizar">
        <div class="container">
            <div class="buttonsForm">
                <div class="btnColor"></div>
                    <button id="btnSignin">Entrar</button>
                    <button id="btnSignup">Cadastrar</button>
                </div>

                <form method="POST" action="../classes/crud_login.php" id="signin">
                    <input type="text" name="nome" placeholder="Nome" required />
                    <input type="email" name="email" placeholder="Email" required />
                    <input type="password" name="senha" placeholder="Senha" required />
                    <button type="submit">Entrar</button>
                </form>

                <form method="POST" action="?action=criar" id="signup">
                <input type="text" name="nome" placeholder="Nome" required />
                    <input type="email" name="email" placeholder="Email" required />
                    <input type="password" name="senha" placeholder="Senha" required />
                    <input type="password" name="confirmar_senha" placeholder="Confirmar Senha" required />
                    <button type="submit" value="Enviar">Cadastrar</button>
                </form>
        </div>
    </div>
  <script src="../JS/cadastro.js"></script>
</body>
</html>