<?php
// srv/Views/processaEditarUsuario.php;
require_once __DIR__ . '/../Controllers/UsuarioController.php';

// Valida se método enviado é o que estamos esperando
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header('Location: editarUsuario.php');
    exit;
}

// Capturar os dados recebidos
$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];
$perfil = $_POST['perfil'];
$ativo = $_POST['ativo'];

// Vamos validar os dados usando a classe ControllerUsuario
try {
    $usuarioController = new UsuarioController();

    $result = $usuarioController->atualizaUsuario(
        $id,
        $nome,
        $email,
        $cpf,
        $telefone,
        $perfil,
        $ativo
    );

    if ($result) {
        header('Location: listarUsuarios.php?sucesso=usuario_atualizar');
        exit;
    } else {
        header('Location: criarUsuario.php?erro=falha_atualizar');
        exit;
    }

} catch (InvalidArgumentException $e){
    header('Location: editarUsuario.php?erro=validacao&mensagem=' . urlencode($e->getMessage()));
    exit;
}



?>