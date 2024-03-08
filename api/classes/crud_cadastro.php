<?php

include('../conexao/banco.php');

$db = new DataBase();

class Crud_cadastro{

    private $conn;
    private $table_name = "cadastros";
    private $table_name2 = "comentarios";
    private $table_name3 = "favoritar";

    public function __construct($db){
        $this->conn = $db;
    }

    //funcao para criar cadastros
    public function criar_cadastro($postValues)
    {
        $nome = $postValues['nome'];
        $email = $postValues['email'];
        $senha = $postValues['senha'];
        $confirmar_senha = $postValues['confirmar_senha'];
        // Verificar se o e-mail já existe
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();
        if ($senha !== $confirmar_senha) {
            echo '<script>alert("As senhas não coincidem.");</script>';
            return false;
        }
        if ($stmt->rowCount() > 0) {
            echo '<script>alert("Email já utilizado");</script>';
            return false; // E-mail já está em uso
        }

        $query = "SELECT * FROM " . $this->table_name . " WHERE nome = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            echo '<script>alert("Nome de usuário já existente");</script>';
            return false; // Nome de usuário já existe
        }
        $query = "INSERT INTO " . $this->table_name . " (nome, email, senha, confirmar_senha) VALUES (?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $senha);
        $stmt->bindParam(4, $confirmar_senha);
        if ($stmt->execute()) {

            return true;
        } else {
            return false;
        }
    }

    public function excluir_perfil($id){
        // Excluir a receita
        $id_usuaario = $_SESSION['id_usuario'];
        $nome = $_SESSION['nome'];
        $query_favorito = "DELETE FROM " . $this->table_name3 . " WHERE id_fav_usuario = ?";
        $stmt_favorito = $this->conn->prepare($query_favorito);
        $stmt_favorito->bindParam(1, $id_usuaario);
        $stmt_favorito->execute();   

        $query_comentarios = "DELETE FROM " . $this->table_name2 . " WHERE autor = ?";
        $stmt_comentarios = $this->conn->prepare($query_comentarios);
        $stmt_comentarios->bindParam(1, $nome);
        $stmt_comentarios->execute();   

        $query_receita = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt_receita = $this->conn->prepare($query_receita);
        $stmt_receita->bindParam(1, $id);
        $stmt_receita->execute();
    
        // Retornar os resultados, se necessário
        return $stmt_receita->fetch(PDO::FETCH_ASSOC);
    }

    public function editar_cadastro($postValues){
        $id = $postValues['id'];
        $nome = $postValues['nome'];
        $novo_nome = $postValues['nome'];
        $email = $postValues['email'];
        $senha = $postValues['senha'];
        $confirmar_senha = $postValues['confirmar_senha'];
    
        if(empty($id) || empty($nome) || empty($email) || empty($senha) || empty($confirmar_senha)){
            return false;
        }
    
        // Verificar se o e-mail existe no banco de dados, exceto se for o e-mail do próprio usuário
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE email = ? AND id != ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $email_exists = $row['count'];
    
        if($email_exists > 0){
            echo"<script>alert('Email já cadastrado, insira outro')</script>";
            return false; // O email já existe no banco de dados, não permitir a edição
        }
    
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE nome = ? AND id != ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $name_exists = $row['count'];
    
        if($name_exists > 0){
            echo"<script>alert('Nome de usuário já existente')</script>";
            return false; // O nome de usuário já existe no banco de dados, não permitir a edição
        }
    
        if ($senha !== $confirmar_senha) {
            echo"<script>alert('As senhas não correspondem')</script>";
            return false;
        }
    
        // Remover temporariamente a restrição de chave estrangeira
        $this->conn->exec('SET FOREIGN_KEY_CHECKS = 0;');
    
        // Atualizar os registros relacionados na tabela "comentarios"
        $query = "UPDATE " . $this->table_name2 . " SET autor = ? WHERE autor = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $novo_nome);
        $stmt->bindParam(2, $_SESSION['nome']);
        $stmt->execute();
    
        // Atualize os dados do cadastro no banco de dados
        $query = "UPDATE " . $this->table_name . " SET nome = ?, email = ?, senha = ?, confirmar_senha = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $senha);
        $stmt->bindParam(4, $confirmar_senha);
        $stmt->bindParam(5, $id);
    
        if ($stmt->execute()) {
            // Reativar a restrição de chave estrangeira
            $this->conn->exec('SET FOREIGN_KEY_CHECKS = 1;');
            return true;
        } else {
            // Reativar a restrição de chave estrangeira
            $this->conn->exec('SET FOREIGN_KEY_CHECKS = 1;');
            return false;
        }
    }

    //funcao para mostar as receitas
    public function mostrar_cadastro(){
        $query = "SELECT * FROM ". $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function verificar_login($nome, $email, $senha)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE nome = ? AND email = ? AND senha = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $senha);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true; // Credenciais válidas
        } else {
            return false; // Credenciais inválidas
        }
    }

    public function obter_id_usuario($nome, $email, $senha) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE nome = ? AND email = ? AND senha = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $senha);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['id']; // Retorna o ID do usuário
        } else {
            return null; // Usuário não encontrado
        }
    }
}