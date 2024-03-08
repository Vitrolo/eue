<?php

session_start(); // Inicia a sessão

require_once('crud_cadastro.php');
require_once('../conexao/banco.php');

$db = new DataBase();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $crud = new Crud_cadastro($conn);

    // Verifica se as credenciais de login são válidas
    if ($crud->verificar_login($nome, $email, $senha)) {
        // Obtenha o ID do usuário do banco de dados
        $id_usuario = $crud->obter_id_usuario($nome, $email, $senha);

        $_SESSION['email'] = $email; // Armazena o email na sessão
        $_SESSION['nome'] = $nome; // Armazena o nome na sessão
        $_SESSION['id_usuario'] = $id_usuario; // Armazena o ID do usuário na sessão

        header('Location: ../index.php');
        exit();
    } else {
        print "<script> alert('Informações incorretas ') </script>";
        print "<script> location.href='../php/cadastro.php';</script>";
    }
}
