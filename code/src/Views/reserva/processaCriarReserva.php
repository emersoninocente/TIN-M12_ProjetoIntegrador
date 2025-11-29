<?php
// src/Views/processaCriarReserva.php
require_once __DIR__ . '/../../Controllers/AuthController.php';
require_once __DIR__ . '/../../Controllers/ReservaController.php';

AuthController::verificarLogin();
$usuarioLogado = AuthController::getUsuarioLogado();

$livro_id = $_GET['livro_id'] ?? null;

if (!$livro_id) {
    header('Location: ../livro/listarLivros.php?erro=livro_invalido');
    exit;
}

try {
    $reservaController = new ReservaController();
    $result = $reservaController->criarReserva($usuarioLogado['id'], $livro_id);

    if ($result) {
        header('Location: listarReservas.php?sucesso=reserva_criada');
        exit;
    } else {
        header('Location: ../livro/listarLivros.php?erro=reserva&mensagem=Falha ao criar reserva');
        exit;
    }
} catch (InvalidArgumentException $e) {
    header('Location: ../livro/listarLivros.php?erro=reserva&mensagem=' . urlencode($e->getMessage()));
    exit;
} catch (Exception $e) {
    header('Location: ../livro/listarLivros.php?erro=reserva&mensagem=Erro no sistema');
    exit;
}
?>