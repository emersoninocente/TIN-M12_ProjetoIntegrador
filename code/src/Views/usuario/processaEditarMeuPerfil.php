<?php
// src/Views/usuario/processaEditarMeuPerfil.php
require_once __DIR__ . '/../../Controllers/AuthController.php';
require_once __DIR__ . '/../../Controllers/UsuarioController.php';

AuthController::verificarLogin();
$usuarioLogado = AuthController::getUsuarioLogado();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header('Location: editarMeuPerfil.php');
    exit;
}

$id = $_POST['id'] ?? null;

// Verifica se o ID corresponde ao usuário logado
if ($id != $usuarioLogado['id']) {
    header('Location: ../dashboard.php?erro=acesso_negado');
    exit;
}

$nome = $_POST['nome'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];

try {
    $usuarioController = new UsuarioController();
    
    // Busca os dados atuais do usuário para manter perfil e status
    $usuarioModel = new UsuarioModel();
    $usuario = $usuarioModel->findById($id);
    
    $result = $usuarioController->atualizaUsuario(
        $id,
        $nome,
        $email,
        $cpf,
        $telefone,
        $usuario['perfil'],
        $usuario['ativo']
    );

    if ($result) {
        // Atualiza os dados na sessão
        $_SESSION['usuario_nome'] = $nome;
        $_SESSION['usuario_email'] = $email;
        
        header('Location: editarMeuPerfil.php?sucesso=perfil_atualizado');
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