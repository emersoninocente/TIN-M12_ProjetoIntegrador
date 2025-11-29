<?php
// src/Views/usuario/processaAlterarMinhaSenha.php
require_once __DIR__ . '/../../Controllers/AuthController.php';
require_once __DIR__ . '/../../Controllers/UsuarioController.php';
require_once __DIR__ . '/../../Models/UsuarioModel.php';

AuthController::verificarLogin();
$usuarioLogado = AuthController::getUsuarioLogado();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header('Location: editarMeuPerfil.php');
    exit;
}

$id = $_POST['id'] ?? null;
$senha_atual = $_POST['senha_atual'] ?? '';
$senha_nova = $_POST['senha_nova'] ?? '';
$senha_confirma = $_POST['senha_confirma'] ?? '';

// Verifica se o ID corresponde ao usuário logado
if ($id != $usuarioLogado['id']) {
    header('Location: ../dashboard.php?erro=acesso_negado');
    exit;
}

try {
    // Verifica se as senhas novas conferem
    if ($senha_nova !== $senha_confirma) {
        header('Location: editarMeuPerfil.php?erro=validacao&mensagem=' . urlencode('As senhas não conferem!'));
        exit;
    }

    // Busca o usuário para verificar a senha atual
    $usuarioModel = new UsuarioModel();
    $usuario = $usuarioModel->findByEmail($usuarioLogado['email']);

    if (!$usuario) {
        header('Location: editarMeuPerfil.php?erro=validacao&mensagem=' . urlencode('Usuário não encontrado!'));
        exit;
    }

    // Verifica se a senha atual está correta
    if (!password_verify($senha_atual, $usuario['senha'])) {
        header('Location: editarMeuPerfil.php?erro=validacao&mensagem=' . urlencode('Senha atual incorreta!'));
        exit;
    }

    // Atualiza a senha
    $usuarioController = new UsuarioController();
    $result = $usuarioController->atualizaSenha($id, $senha_nova);

    if ($result) {
        header('Location: editarMeuPerfil.php?sucesso=senha_alterada');
        exit;
    } else {
        header('Location: editarMeuPerfil.php?erro=falha_atualizar');
        exit;
    }
} catch (InvalidArgumentException $e) {
    header('Location: editarMeuPerfil.php?erro=validacao&mensagem=' . urlencode($e->getMessage()));
    exit;
}
?>