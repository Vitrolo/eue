<?php

include('../conexao/banco.php');

$db = new DataBase();

class Crud_comentario{

    private $conn;
    private $table_name = "comentarios";

    public function __construct($db){
        $this->conn = $db;
    }

    public function criar_comentario($postValues){
        $comentario = $postValues['comentario'];
        $id_receita = $postValues['id_receita'];
        $autor = $_SESSION['nome'];
    
        $query = "INSERT INTO ".$this->table_name." (comentario, id_receita, autor) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $comentario);
        $stmt->bindParam(2, $id_receita);
        $stmt->bindParam(3, $autor);
    
        if ($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function mostrar_comentario(){   
        $query = "SELECT * FROM ". $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function editar_comentario($postValues){
        $id_comentario = $postValues['id_comentario'];
        $id_receita = $postValues['id_receita'];
        $autor = $postValues['autor'];
        $data_hora = $postValues['data_hora'];
        $comentario = $postValues['comentario'];

        if(empty($id_comentario) || empty($id_receita) || empty($autor) || empty($data_hora)|| empty($comentario) ){
            return false;
        }

        $query = "UPDATE ". $this->table_name . " SET id_receita = ?, autor = ?, data_hora = ?, comentario = ? WHERE id_comentario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_receita);
        $stmt->bindParam(2, $autor);
        $stmt->bindParam(3, $data_hora);
        $stmt->bindParam(4, $comentario);
        $stmt->bindParam(5, $id_comentario);

        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function excluir_comentario($id_comentario){
        $query = "DELETE FROM ". $this->table_name. " WHERE id_comentario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$id_comentario);
        $stmt-> execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function readOne($id_comentario){
        $query = "SELECT * FROM ". $this->table_name . " WHERE id_comentario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_comentario);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}