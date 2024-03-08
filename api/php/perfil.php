<?php
session_start();


require_once ('../classes/crud_cadastro.php');
require_once ('../classes/crud_mostrar.php');
require_once ('../conexao/banco.php');

$database = new DataBase();
$db = $database->getConnection();

$crud = new Crud_mostrar($db);
$crud_cadastro = new Crud_cadastro($db);

if(isset($_GET['action'])){
    switch($_GET['action']){
        case 'mostrar':
            $rows = $crud->mostrar_receita();
            break;
        case 'excluir':
            $crud_cadastro->excluir_cadastro();
            $rows_cadastro = $crud_cadastro->mostrar_cadastro();
            break;
        case 'favoritar':
            $crud->favoritar_receita($_GET['id']);
            $rows = $crud->mostrar_receita();
            header('location: perfil.php');
            break;
        case 'desfavoritar':
            $crud->desfavoritar_receita($_GET['id']);
            $rows = $crud->mostrar_receita();
            header('location: perfil.php');
    }
}

$rows = $crud->mostrar_receita();
$rows_cadastro = $crud_cadastro->mostrar_cadastro();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <title>Perfil</title>
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../CSS/perfil.css" />
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
                    $email = $_SESSION['email'];
                    $nome = $_SESSION['nome'];
                    $id_usuario = $_SESSION['id_usuario'];
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
            <div class="perfil-header">
                <div class="perfil-nome"> <h1><?php echo $nome; ?></h1></div>
                <div class="perfil-email"> <h3><?php echo $email; ?></h3></div>
            </div>

            <div class="perfil-info">
                <a href='editar_perfil.php' class="perfil-info-item">
                    <h3>Editar Perfil</h3>
                    <p>Edite suas informações</p>
                </a>
            </div>
        </div>
        <div class="fav_titulo">
            <div class="listra">
                <h1>Favoritos</h1>
            </div>


            <div class="carousel">
                <?php
                    if (isset($rows)) {
                        echo "<div class='card-container'>";
                        foreach($rows as $row){
                            if($crud->isReceitaFavoritada($row['id'])){
                                echo "<div class='card'>";
                                if (isset($_SESSION['nome'])){
                                $favoritada = $crud->isReceitaFavoritada($row['id']);
                                    if($favoritada){
                                        // A receita está favoritada, exibe o botão de desfavoritar
                                        echo "<a href='?action=desfavoritar&id=" . $row['id'] . "' class='botao-fav favoritada'><i class='fas fa-star'></i></a>";
                                    }
                                }
                                echo "<a href='../php/receita.php?id=".$row['id']."' class='card-link'>";
                                echo "<div class='titulo-imagem'>";
                                echo "<h1>".$row['titulo']."</h1>";
                                echo "<img src='../imagens/".$row['imagem']."' alt='Imagem da receita'>";
                                echo "</div>";
                                echo "<h2> Descrição </h2>";
                                echo "<p> ".$row['descricao']."</p>";
                                echo "<h2> Ingredientes </h2>";
                                echo "<p> ".$row['ingredientes']."</p>";
                                echo "<h2> Modo Preparo </h2>";
                                echo "<p> ".$row['modo_preparo']."</p>";
                                echo "<h2> Categoria </h2>";
                                echo "<p> ".$row['categoria']."</p>";
                                echo "</a>";
                                echo "</div>";
                            }
                        }
                        echo "</div>";
                    }
                ?>
            </div>
        </div>
        <style>
            .carousel {
            width: 100%;
            height: 800px;
            overflow-y: scroll;
            }
        </style>
        </div>
    </div>
    <script src="../JS/script.js"></script>
</body>
</html>