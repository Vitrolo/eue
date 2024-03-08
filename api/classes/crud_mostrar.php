<?php

include('../conexao/banco.php');

$db = new DataBase();

class Crud_mostrar{

    private $conn;
    private $table_name = "receitas";
    Private $table_name3 = "favoritar";
    
    public function __construct($db){
        $this->conn = $db;
    }

    public function mostrar_receita(){
        $query = "SELECT * FROM ". $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
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