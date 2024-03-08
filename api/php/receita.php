<?php
session_start();

require_once ('../classes/crud_comentario.php');
require_once ('../classes/crud_mostrar.php');
require_once ('../conexao/banco.php');

$database = new DataBase();
$db = $database->getConnection();
$crud_coment = new Crud_comentario($db);
$rows_coment = $crud_coment->mostrar_comentario();

$crudo = new Crud_mostrar($db);
$rows = $crudo->mostrar_receita();


$id = $_GET['id'];

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'criar':
            $crud_coment->criar_comentario($_POST);
            $rows_coment = $crud_coment->mostrar_comentario();
            header('Location: receita.php?id=' . $id . '#comentarios');
            break;
        case 'mostrar':
            $rows_coment = $crud_coment->mostrar_comentario();
            break;
        case 'editar':
            if (isset($_POST['id_comentario'])) {
                $crud_coment->editar_comentario($_POST);
                $rows_coment = $crud_coment->mostrar_comentario();
                header('Location: receita.php?id=' . $id . '#comentarios');
            }
            break;
        case 'excluir':
            $crud_coment->excluir_comentario($_GET['id_comentario']);
            $rows_coment = $crud_coment->mostrar_comentario();
            header('Location: receita.php?id=' . $id . '#comentarios');
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link rel="stylesheet" href="../CSS/receita.css">
    <title> Receita </title>
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
                $_SESSION['nome'] = null;
        ?>
        <div class="botoes">
            <a href="../php/cadastro.php"><button type="button" class="botao-cadastrar"> Entrar ou Cadastrar </button></a>
        </div>

        <?php
            }else{
                $email = $_SESSION['email'];
                $nome = $_SESSION['nome'];

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
                    <a href="../php/perfil.php">
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

<?php
    if (isset($_GET['id'])) {
        $receitaEncontrada = false;
        if (isset($rows)) {
            foreach($rows as $row){
                if($row['id'] == $_GET['id']){
                    echo "<section class='recipe'>";
                    echo '<div class="container">';
                    echo "<h1>".$row['titulo']."</h1>";
                    echo "<img src='../imagens/".$row['imagem']."' alt='Imagem da receita'>";
                    echo "<p class='description'>".$row['descricao']."</p>";
                    echo '<div class="ingredients">';
                    echo '<h2 class="sub-titulo">Ingredientes</h2>';
                    echo '<ul>';
                    
                    $ingredientes = explode(',', $row['ingredientes']);
                    
                    foreach($ingredientes as $ingrediente) {
                        echo "<li>".$ingrediente."</li>";
                    }
                    
                    echo '</ul>';
                    echo '</div>';
                    echo '<div class="instructions">';
                    echo '<h2 class="sub-titulo">Modo de Preparo</h2>';
                    echo '<ol>';
                    
                    $passos = explode(',', $row['modo_preparo']);
                    
                    foreach($passos as $passo) {
                        echo "<li>".$passo."</li>";
                    }
                    
                    echo '</ol>';
                    echo '</div>';
                    echo '</div>';
                    echo '</section>';
                    $receitaEncontrada = true;
                    break;
                }
            }
        }
        if (!$receitaEncontrada) {
            header('Location: ../index.php');
            exit();
        }
    }

    if (isset($_GET['action']) && $_GET['action'] == 'editar' && isset($_GET['id_comentario'])) {
        $id_comentario = $_GET['id_comentario'];
        $result = $crud_coment->readOne($id_comentario);
        if (!$result) {
            echo "Registro não encontrado";
            exit();
        }
        $id_receita = $result['id_receita'];
        $autor = $result['autor'];
        $data_hora = $result['data_hora'];
        $comentario = $result['comentario'];
        echo '
        <div class="form-editar-inteiro">
            <div class="form-editar">
                <span class="close">&times;</span>
                <h2>Editar um comentário</h2>
                <form action="?action=editar&id=' . $_GET['id'] . '" method="POST">
                    <input type="hidden" name="id_comentario" value="' . $id_comentario . '">
                    <input type="hidden" name="id_receita" value="' . $id_receita . '">
                    <input type="hidden" name="autor" value="' . $autor . '">
                    <input type="hidden" name="data_hora" value="' . $data_hora . '">
                    <textarea name="comentario" rows="4" placeholder="Dê sua opinião" required>' . $comentario . '</textarea>
                    <button type="submit" class="botao-criar" onclick="return confirm(\'Tem certeza que deseja deletar esse registro?\')">Atualizar</button>
                </form>
            </div>
        </div>';
    }else{
    
        if (isset($_SESSION['nome'])) {
            echo '
            <div class="comentario_alinhar">
                <div class="form-comentario">
                    <h2 class="sub-titulo">Deixe um comentário</h2>
                    <form action="?action=criar&id=' . $_GET['id'] . '" method="POST">
                        <textarea name="comentario" rows="4" placeholder="Dê sua opinião" required></textarea>
                        <input type="hidden" name="id_receita" value="' . $_GET['id'] . '">
                        <button type="submit">Enviar</button>
                    </form>
                </div>
            </div>';
        }else{
            echo '
            <div class="comentario_alinhar">
                <div class="form-comentario">
                    <h2 class="sub-titulo">Deixe um comentário</h2>
                    <form action="?action=criar&id=' . $_GET['id'] . '" method="POST">
                        <textarea name="comentario" rows="4" placeholder="Você precisa estar logado para enviar um comentário" required disabled></textarea>
                        <input type="hidden" name="id_receita" value="' . $_GET['id'] . '">
                        <button type="submit" disabled>Enviar</button>
                    </form>
                </div>
            </div>';
        }
    }
    
    ?>

    <div class="comentarios-container" id="comentarios">
        <?php
            if (isset($rows_coment) && isset($_GET['id'])) {
                $id_receita = isset($_GET['id']) ? $_GET['id'] : null;
                foreach($rows_coment as $row){
                    if($row['id_receita'] == $_GET['id']){
                        echo '<div class="comment">';
                        echo '<div class="comment-header">';
                        echo '<a href="#" class="comment-author">' . $row['autor'] . '</a>';
                        echo '<span class="comment-date">' . $row['data_hora'] . '</span>';
                        echo '</div>';
                        echo '<div class="comment-content">' . $row['comentario'] . '</div>';

                        if ($row['autor'] == $_SESSION['nome']) {
                            echo "<a href='?action=editar&id=".$_GET['id']."&id_comentario=".$row['id_comentario']."' class='botao-editar'>Editar</a>";
                            echo "<a href='?action=excluir&id=".$_GET['id']."&id_comentario=".$row['id_comentario']."' onclick='return confirm(\"Tem certeza que deseja deletar esse registro?\")' id='openModalBtn' class='botao-excluir'>Excluir</a>";
                        } elseif ($email == "adm@gmail.com") {
                            echo "<a href='?action=excluir&id=".$_GET['id']."&id_comentario=".$row['id_comentario']."' onclick='return confirm(\"Tem certeza que deseja deletar esse registro?\")' id='openModalBtn' class='botao-excluir'>Excluir</a>";
                        }
                        
                        echo '</div>';
                    }
                }
            }
        ?>
    </div>
<script src="../JS/receita.js"></script>
</body>
</html>