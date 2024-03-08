<?php
session_start();
$email = $_SESSION['email'];
$nome = $_SESSION['nome'];
$id_usuario = $_SESSION['id_usuario'];

require_once ('../classes/crud_cadastro.php');
require_once ('../classes/crud_mostrar.php');
require_once ('../conexao/banco.php');

$database = new DataBase();
$db = $database->getConnection();

$crud_cadastro = new Crud_cadastro($db);

if(isset($_GET['action'])){
    switch($_GET['action']){
        case 'mostrar':
            $rows = $crud->mostrar_cadastro();
            break;
        case 'editar':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $postValues = array(
                    'id' => $_POST['id'],
                    'nome' => $_POST['nome'],
                    'email' => $_POST['email'],
                    'senha' => $_POST['senha'],
                    'confirmar_senha' => $_POST['confirmar_senha']
                );
                
                if ($crud_cadastro->editar_cadastro($postValues)) {
                    header('location: ../classes/logout.php');
                }
            }
            break;
        case 'excluir':
            $crud_cadastro->excluir_perfil($_SESSION['id_usuario']);
            $rows = $crud_cadastro->excluir_perfil($_SESSION['id_usuario']);
            header('location: ../classes/logout.php');
            break;

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <title>Editar Perfil</title>
    <!--Font Awesome-->
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!--CSS-->
    <link rel="stylesheet" href="../CSS/editar_perfil.css" />
</head>
<body>
    <header>
        <nav>
            <a href="../index.php"><h2 class="logo"> Culinary <span> World </span> </h2></a>
            <ul>
            </ul>

            <?php
                if (!isset($_SESSION['nome'])) {
                    $email = null;
                    $nome = null;
                    $id_usuario = null;
                    header('location: ../index.php');
            ?>
            <div class="botoes">
                <a href="php/cadastro.php"><button type="button" class="botao-cadastrar"> Entrar ou Cadastrar </button></a>
            </div>

            <?php
                }else{
            ?>
            <div class="perfil-dropdown">
                <div class="perfil-dropdown-btn" onclick="toggle()">
                    <span>
                    <?php echo $nome; ?>
                        <i class="fa-solid fa-angle-down"></i>
                    </span>
                </div>
                <ul class="perfil-dropdown-list">
                    <li class="perfil-dropdown-list-item">
                        <a href="perfil.php">
                            <i class="fa-regular fa-user"> Ver perfil</i>
                        </a>
                    </li>
                    <li class="perfil-dropdown-list-item">
                        <a href="editar_perfil.php">
                            <i class="fa-regular fa-edit"> Editar perfil</i>
                        </a>
                    </li>
                    <hr />
                    <li class="perfil-dropdown-list-item">
                        <a href="../classes/logout.php">
                            <i class="fa-solid fa-arrow-right-from-bracket"> Sair </i>
                        </a>
                    </li>
                </ul>
            </div>
            <?php
                }
            ?>
        </nav>
    </header>
    <div class="geral">
        <div class="perfil-container">  
            <a href="perfil.php">
                <button class="voltar"> Voltar</button>
            </a>
            <div class="perfil-header">
                <div class="perfil-nome"> <h1><?php echo $nome; ?></h1></div>
                <div class="perfil-email"> <h3><?php echo $email; ?></h3></div>
            </div>
            <form class="perfil-editar-form" method="post" action="?action=editar">
                <input type="hidden" name="id" value="<?php echo $id_usuario; ?>">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" placeholder="Digite seu nome" value="<?php echo $nome; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Digite seu email" value="<?php echo $email; ?>" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                </div>
                <div class="form-group">
                    <label for="confirmar_senha">Confirmar Senha:</label>
                    <input type="password" id="senha" name="confirmar_senha" placeholder="Confirme sua senha" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-submit">Salvar</button>
                </div>
            </form>
            <div class="apagar-conta">
            <a href="?action=excluir&id_usuario=<?php echo $id_usuario?>" class="apagar" onclick="return confirm('Tem certeza que deseja excluir a conta?')">Excluir Conta</a>
            </div>
        </div>
        <div class="separador"></div>
    </div>
    <script src="../JS/script.js"></script>
</body>
</html>