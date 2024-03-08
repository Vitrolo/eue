<?php
session_start();

require_once ('classes/crud_receita.php');
require_once ('conexao/banco.php');

$database = new DataBase();
$db = $database->getConnection();
$crud = new Crud_receita($db);


if(isset($_GET['action'])){
    switch($_GET['action']){
        case 'criar':
            $crud->criar_receita($_POST);
            $rows = $crud->mostrar_receita();
            header('location: index.php');
            break;
        case 'mostrar':
            $rows = $crud->mostrar_receita();
            break;
        case 'editar':
            if(isset($_POST['id'])){
                $crud->editar_receita($_POST);
                header("Location: index.php");
            }            
            $rows = $crud->mostrar_receita();
            break;
        case 'favoritar':
            $crud->favoritar_receita($_GET['id']);
            $rows = $crud->mostrar_receita();
            header('location: index.php');
            break;
        case 'excluir':
            $crud->excluir_receita($_GET['id']);
            $rows = $crud->mostrar_receita();
            header('location: index.php');
            break;
        case 'desfavoritar':
            $crud->desfavoritar_receita($_GET['id']);
            $rows = $crud->mostrar_receita();
            header('location: index.php');
    }
}else{
    $rows = $crud->mostrar_receita();
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
    <link rel="stylesheet" href="CSS/home.css">
    <title>Culinary World</title>
</head>



<body>
    <header>
    <nav>
        <a href="index.php"><h2 class="logo"> Culinary <span> World </span> </h2></a>

        <?php
            if (!isset($_SESSION['nome'])) {
                $email = null;
                $nome = null;
                $id_usuario = null;
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
                    <a href="php/perfil.php">
                        <i class="fa-regular fa-user"> Ver perfil</i>
                    </a>
                </li>
                <li class="perfil-dropdown-list-item">
                    <a href="php/editar_perfil.php">
                        <i class="fa-regular fa-edit"> Editar perfil</i>
                    </a>
                </li>
                <hr />
                <li class="perfil-dropdown-list-item">
                    <a href="classes/logout.php">
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
    <main>

        
        <?php
            if($email == "adm@gmail.com"){
        ?>
        <button class="abrir-form" id="openModalBtn">+</button>

        <?php
            }
        ?>

        <?php
            if(isset($_GET['action']) && $_GET['action'] == 'editar' && isset($_GET['id'])){
                $id = $_GET['id'];
                $result = $crud->readOne($id);

                if(!$result){
                    echo"Registro não encontrado";
                    exit();
                }
                $titulo = $result['titulo'];
                $descricao = $result['descricao'];
                $ingredientes = $result['ingredientes'];
                $modo_preparo = $result['modo_preparo'];
                $categoria = $result['categoria'];
        ?>

        <div class="form-editar-inteiro">
            <div class="form-editar">
                <span class="close">&times;</span>
                <h2>Editar uma receita</h2>
                <form method="POST" action="?action=editar" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <input type="text" name="titulo" placeholder="insira o titulo da receita" value="<?php echo $titulo ?>" required>

                    <input type="text" name="descricao" placeholder="insira a descricao da receita" value="<?php echo $descricao ?>" required>

                    <input type="text" name="ingredientes" placeholder="insira os ingredientes da receita" value="<?php echo $ingredientes ?>" required>

                    <input type="text" name="modo_preparo" placeholder="insira o modo de preparo da receita" value="<?php echo $modo_preparo ?>" required>

                    <input type="file" name="imagem" placeholder="altere a capa para a receita">

                    <select name="categoria" required>
                        <option value=" <?php echo $categoria ?> " selected disabled> <?php echo $categoria ?></option>
                        <option value="Pratos">Pratos</option>
                        <option value="Aperitivos">Aperitivos</option>
                        <option value="Lanches">Lanches</option>
                        <option value="Bebidas">Bebidas</option>
                        <option value="Carnes">Carnes</option>
                        <option value="Massas">Massas</option>
                        <option value="Saladas">Saladas</option>
                        <option value="Sopas">Sopas</option>
                        <option value="Sobremesas">Sobremesas</option>
                        <option value="Pratos Vegetarianos">Pratos Vegetarianos</option>
                        <option value="Pratos Veganos">Pratos Veganos</option>
                    </select>

                    <input type="submit" value="Enviar" class="botao-criar" onclick="return confirm('tem certeza que deseja atualizar?')">
                </form>
            </div>
        </div>

        <?php
            }else{
                
              
               
                
        ?>

        <div id="myModal" class="modal">

        <?php
        
        ?>
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Registrar uma receita</h2>
                <form method="POST" action="?action=criar" enctype="multipart/form-data">
                    <input type="text" name="titulo" placeholder="insira o titulo da receita" required>

                    <input type="text" name="descricao" placeholder="insira a descricao da receita" required>

                    <input type="text" name="ingredientes" placeholder="insira os ingredientes da receita" required>

                    <input type="text" name="modo_preparo" placeholder="insira o modo de preparo da receita" required>

                    <select name="categoria" required>
                        <option value="" selected disabled>Selecione uma categoria</option>
                        <option value="Pratos">Pratos</option>
                        <option value="Aperitivos">Aperitivos</option>
                        <option value="Lanches">Lanches</option>
                        <option value="Bebidas">Bebidas</option>
                        <option value="Carnes">Carnes</option>
                        <option value="Massas">Massas</option>
                        <option value="Saladas">Saladas</option>
                        <option value="Sopas">Sopas</option>
                        <option value="Sobremesas">Sobremesas</option>
                        <option value="Pratos Vegetarianos">Pratos Vegetarianos</option>
                        <option value="Pratos Veganos">Pratos Veganos</option>
                    </select>

                    <input type="file" name="imagem" placeholder="insira uma capa para a receita" required>


                    <input type="submit" name="enviar" value="Enviar" class="botao-criar">
                </form>
            </div>
        </div>

        

        <?php
            }
        ?>

    <div class="receitas">
        <h1>Receitas</h1>
    </div>
        <?php
            if (isset($rows)) {
                echo "<div class='card-container'>";
                foreach($rows as $row){
                    echo "<div class='card'>";
                    if (isset($_SESSION['nome'])){
                    $favoritada = $crud->isReceitaFavoritada($row['id']);
                        if($favoritada){
                            echo "<a href='?action=desfavoritar&id=" . $row['id'] . "' class='botao-fav favoritada'><i class='fas fa-star'></i></a>";
                        } else {
                            echo "<a href='?action=favoritar&id=" . $row['id'] . "' class='botao-fav'><i class='far fa-star'></i></a>";
                        }
                    }
                    echo "<a href='php/receita.php?id=".$row['id']."' class='card-link'>";
                    echo "<div class='titulo-imagem'>";
                    echo "<h1>".$row['titulo']."</h1>";
                    echo "<img src='imagens/".$row['imagem']."' alt='Imagem da receita'>";
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
                    echo "<div class='card-actions'>";
                    if($email == "adm@gmail.com"){
                        echo "<a href='?action=editar&id=".$row['id']."' class='botao-editar'>Editar</a>";
                        echo "<a href='?action=excluir&id=".$row['id']."' onclick='return confirm(\"Tem certeza que deseja deletar esse registro?\")' id='openModalBtn' class='botao-excluir'>Excluir</a>";
                    }
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<h1>Nenhum registro encontrado</h1>";
            }
                ?>

    </main>
    <script src="./JS/script.js"></script>
</body>
</html>