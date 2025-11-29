<?php
// processa_usuario.php

// Inclui o controller
require_once __DIR__ . '/src/Controllers/UsuarioController.php';

// Inicializa variáveis para a view
$mensagem = '';
$dadosSubmetidos = [];

// Verifica se o formulário foi enviado (requisição POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Armazena os dados submetidos para repopular o formulário em caso de erro
    $dadosSubmetidos = $_POST;

    try {
        // Instancia o controller
        $usuarioController = new UsuarioController();

        // Extrai os dados do POST
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $cpf = $_POST['cpf'] ?? '';
        $telefone = $_POST['telefone'] ?? '';
        $perfil = $_POST['perfil'] ?? '';
        
        // Conforme a lógica do controller, 'ativo' é sempre 1 na criação
        $ativo = 1;

        // Tenta criar o usuário
        $sucesso = $usuarioController->criarUsuario($nome, $email, $senha, $cpf, $telefone, $perfil, $ativo);

        if ($sucesso) {
            $mensagem = "Usuário cadastrado com sucesso!";
            // Limpa os dados submetidos para não repopular o form após o sucesso
            $dadosSubmetidos = []; 
        } else {
            // Caso o método create() retorne false por alguma razão interna do Model
            $mensagem = "Ocorreu um erro ao cadastrar o usuário. Tente novamente.";
        }

    } catch (InvalidArgumentException $e) {
        // Captura a exceção de validação lançada pelo controller
        $mensagem = $e->getMessage();
    } catch (Exception $e) {
        // Captura qualquer outro erro inesperado
        $mensagem = "Erro inesperado: " . $e->getMessage();
    }
}

// Inclui o arquivo da View. A view terá acesso às variáveis $mensagem e $dadosSubmetidos
require_once __DIR__ . '/src/Views/criarUsuarioView.php';