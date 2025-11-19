<?php
// src/Views/processaTrocarSenhaUsuario.php;
require_once __DIR__ . '/../Controllers/UsuarioController.php';

// Valida se método enviado é o que estamos esperando
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header('Location: listarUsuario.php');
    exit;
}

// Capturar os dados recebidos
$id = $_POST['id'];
$pass_1 = $_POST['password_1'];
$pass_2 = $_POST['password_2'];

try {
    if ($pass_1 === $pass_2) {
        $usuarioController = new UsuarioController();
        $ret = $usuarioController->atualizaSenha($id, $pass_1);
        if ($ret){
            header('Location: listarUsuarios.php?sucesso=troca_senhaOk');
            exit;
        } else {
            header('Location: listarUsuarios.php?erro=troca_senhaNOk');
            exit;
        }
    } else {
        header('Location: trocarSenhaUsuario.php?erro=senhas_nconferem');
        exit;
    }
} catch (InvalidArgumentException $e){
    header('Location: trocarSenhaUsuario.php?erro=validacao&mensagem=' . urlencode($e->getMessage()));
    exit;
}
?>