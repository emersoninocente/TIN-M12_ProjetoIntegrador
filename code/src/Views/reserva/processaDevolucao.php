<?php
// src/Views/reserva/processaDevolucao.php
require_once __DIR__ . '/../../Controllers/AuthController.php';
require_once __DIR__ . '/../../Controllers/ReservaController.php';

AuthController::verificarPermissao(['bibliotecario', 'administrador']);
$usuarioLogado = AuthController::getUsuarioLogado();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header('Location: listarTodasReservas.php');
    exit;
}

$reserva_id = $_POST['reserva_id'] ?? null;
$observacoes = $_POST['observacoes'] ?? null;

if (!$reserva_id) {
    header('Location: listarTodasReservas.php?erro=dados_invalidos&mensagem=ID da reserva não informado');
    exit;
}

try {
    $reservaController = new ReservaController();
    $result = $reservaController->processarDevolucao(
        $reserva_id,
        $usuarioLogado['id'],
        $observacoes
    );

    if ($result) {
        header('Location: listarTodasReservas.php?sucesso=devolucao_processada');
        exit;
    } else {
        header('Location: processarDevolucao.php?id=' . $reserva_id . '&erro=falha&mensagem=Falha ao processar devolução');
        exit;
    }
} catch (InvalidArgumentException $e) {
    header('Location: processarDevolucao.php?id=' . $reserva_id . '&erro=validacao&mensagem=' . urlencode($e->getMessage()));
    exit;
} catch (Exception $e) {
    header('Location: processarDevolucao.php?id=' . $reserva_id . '&erro=sistema&mensagem=Erro no sistema');
    exit;
}
?>