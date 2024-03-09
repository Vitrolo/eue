<?php

include('./conexao/banco.php');

$db = new DataBase();

class Crud_receita{

    

    private $conn;
    private $table_name = "receitas";
    Private $table_name2 = "comentarios";
    Private $table_name3 = "favoritar";
    Private $table_name4 = "cadastros";

    public function __construct($db){
        $this->conn = $db;
    }

    //funcao para criar receitas
    public function criar_receita($postValues){
        $titulo = $postValues['titulo'];
        $descricao = $postValues['descricao'];
        $ingredientes = $postValues['ingredientes'];
        $modo_preparo = $postValues['modo_preparo'];
        $categoria = $postValues['categoria'];
    
        $query = "INSERT INTO ".$this->table_name." (titulo, descricao, ingredientes, modo_preparo, categoria, imagem) VALUES (?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $titulo);
        $stmt->bindParam(2, $descricao);
        $stmt->bindParam(3, $ingredientes);
        $stmt->bindParam(4, $modo_preparo);
        $stmt->bindParam(5, $categoria);
    
        if (isset($_FILES['imagem'])) {
            $arquivo = $_FILES['imagem'];
            $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
            $ex_permitidos = array('jpg', 'jpeg', 'png', 'gif');
    
            if (!in_array(strtolower($extensao), $ex_permitidos)) {
                die('Tipo de arquivo não é permitido');
            } else {
                $nome_arquivo = $arquivo['name']; // Nome do arquivo original
                move_uploaded_file($arquivo['tmp_name'], 'imagens/' . $nome_arquivo);
                // Aqui você pode salvar o nome do arquivo no banco de dados se necessário
                $stmt->bindParam(6, $nome_arquivo);
            }
        }
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    
    

    //funcao para mostar as receitas
    public function mostrar_receita(){
        $query = "SELECT * FROM ". $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    //funcao para editar as receitas
    public function editar_receita($postValues){

        $id = $postValues['id'];
        $titulo = $postValues['titulo'];
        $descricao = $postValues['descricao'];
        $ingredientes = $postValues['ingredientes'];
        $modo_preparo = $postValues['modo_preparo'];
        $categoria = $postValues['categoria'];
    
        if(empty($id) || empty($titulo) || empty($descricao) || empty($ingredientes) || empty($modo_preparo) || empty($categoria)){
            return false;
        }
    
        // Verifique se um novo arquivo de imagem foi enviado
        $nova_imagem = false;
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $arquivo = $_FILES['imagem'];
            $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
            $ex_permitidos = array('jpg', 'jpeg', 'png', 'gif');
    
            if (!in_array(strtolower($extensao), $ex_permitidos)) {
                die('Tipo de arquivo não é permitido');
            } else {
                $nome_arquivo = $arquivo['name'];
                move_uploaded_file($arquivo['tmp_name'], 'imagens/' . $nome_arquivo);
                $nova_imagem = true;
            }
        }
    
        // Atualize os dados da receita no banco de dados
        $query = "UPDATE " . $this->table_name . " SET titulo = ?, descricao = ?, ingredientes = ?, modo_preparo = ?, categoria = ?";
        if ($nova_imagem) {
            $query .= ", imagem = ?";
        }
        $query .= " WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $titulo);
        $stmt->bindParam(2, $descricao);
        $stmt->bindParam(3, $ingredientes);
        $stmt->bindParam(4, $modo_preparo);
        $stmt->bindParam(5, $categoria);
        
        if ($nova_imagem) {
            $stmt->bindParam(6, $nome_arquivo);
            $stmt->bindParam(7, $id);
        } else {
            $stmt->bindParam(6, $id);
        }
    
        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }
    //funcao para deletar as receitas
    public function excluir_receita($id){

        // Excluir os favoritos relacionados à receita
        $query_favoritos = "DELETE FROM " . $this->table_name3 . " WHERE id_fav_receita = ?";
        $stmt_favoritos = $this->conn->prepare($query_favoritos);
        $stmt_favoritos->bindParam(1, $id);
        $stmt_favoritos->execute();
    
        // Excluir os comentários relacionados à receita
        $query_comentarios = "DELETE FROM " . $this->table_name2 . " WHERE id_receita = ?";
        $stmt_comentarios = $this->conn->prepare($query_comentarios);
        $stmt_comentarios->bindParam(1, $id);
        $stmt_comentarios->execute();
    
        // Excluir a receita
        $query_receita = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt_receita = $this->conn->prepare($query_receita);
        $stmt_receita->bindParam(1, $id);
        $stmt_receita->execute();
    
        // Retornar os resultados, se necessário
        return $stmt_receita->fetch(PDO::FETCH_ASSOC);
    }

    //funcao para pegar os registros do banco e colocar no formulário html
    public function readOne($id){

        $query = "SELECT * FROM ". $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt -> bindParam(1,$id);
        $stmt-> execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function favoritar_receita($id_receita){
        $id_usuario = $_SESSION['id_usuario'];
        
        // Verifique se já existe um registro de favorito para essa receita
        $query_check = "SELECT * FROM " . $this->table_name3 . " WHERE id_fav_receita = ? AND id_fav_usuario = ?";
        $stmt_check = $this->conn->prepare($query_check);
        $stmt_check->bindParam(1, $id_receita);
        $stmt_check->bindParam(2, $id_usuario);
        $stmt_check->execute();
    
        if ($stmt_check->rowCount() > 0) {
            // Já existe um registro de favorito para essa receita, não faça nada
            return false;
        }
    
        // Insira o registro de favorito na tabela "favoritar"
        $query = "INSERT INTO " . $this->table_name3 . " (id_favorito, id_fav_receita, id_fav_usuario) VALUES (NULL, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_receita);
        $stmt->bindParam(2, $id_usuario);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function desfavoritar_receita($id_receita){
        $id_usuario = $_SESSION['id_usuario'];
    
        // Verifique se existe um registro de favorito para essa receita associado ao usuário específico
        $query_check = "SELECT * FROM " . $this->table_name3 . " WHERE id_fav_receita = ? AND id_fav_usuario = ?";
        $stmt_check = $this->conn->prepare($query_check);
        $stmt_check->bindParam(1, $id_receita);
        $stmt_check->bindParam(2, $id_usuario);
        $stmt_check->execute();
    
        if ($stmt_check->rowCount() === 0) {
            // Não há registro de favorito para essa receita associado ao usuário, não faça nada
            return false;
        }
    
        // Exclua o registro de favorito da tabela "favoritar"
        $query = "DELETE FROM " . $this->table_name3 . " WHERE id_fav_receita = ? AND id_fav_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_receita);
        $stmt->bindParam(2, $id_usuario);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function isReceitaFavoritada($id_receita){

        $id_usuario = $_SESSION['id_usuario'];
    
        // Verifique se existe um registro de favorito para essa receita associado ao usuário específico
        $query_check = "SELECT * FROM " . $this->table_name3 . " WHERE id_fav_receita = ? AND id_fav_usuario = ?";
        $stmt_check = $this->conn->prepare($query_check);
        $stmt_check->bindParam(1, $id_receita);
        $stmt_check->bindParam(2, $id_usuario);
        $stmt_check->execute();
    
        return $stmt_check->rowCount() > 0;
    }
}
