<?php
// src/Views/reserva/processaRetirada.php
require_once __DIR__ . '/../../Controllers/AuthController.php';
require_once __DIR__ . '/../../Controllers/ReservaController.php';

AuthController::verificarPermissao(['bibliotecario', 'administrador']);
$usuarioLogado = AuthController::getUsuarioLogado();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header('Location: listarTodasReservas.php');
    exit;
}

$reserva_id = $_POST['reserva_id'] ?? null;
$data_prevista_devolucao = $_POST['data_prevista_devolucao'] ?? null;

if (!$reserva_id || !$data_prevista_devolucao) {
    header('Location: listarTodasReservas.php?erro=dados_invalidos&mensagem=Dados incompletos');
    exit;
}

try {
    $reservaController = new ReservaController();
    $result = $reservaController->processarRetirada(
        $reserva_id,
        $usuarioLogado['id'],
        $data_prevista_devolucao
    );

    if ($result) {
        header('Location: listarTodasReservas.php?sucesso=retirada_processada');
        exit;
    } else {
        header('Location: processarRetirada.php?id=' . $reserva_id . '&erro=falha&mensagem=Falha ao processar retirada');
        exit;
    }
} catch (InvalidArgumentException $e) {
    header('Location: processarRetirada.php?id=' . $reserva_id . '&erro=validacao&mensagem=' . urlencode($e->getMessage()));
    exit;
} catch (Exception $e) {
    header('Location: processarRetirada.php?id=' . $reserva_id . '&erro=sistema&mensagem=Erro no sistema');
    exit;
}
?>