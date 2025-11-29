<?php
// src/Views/processaLogin.php
require_once __DIR__ . '/../Controllers/AuthController.php';

// Valida se método enviado é o que estamos esperando
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header('Location: ../../index.php');
    exit;
}

// Capturar os dados recebidos
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

try {
    $authController = new AuthController();
    $result = $authController->login($email, $senha);

    if ($result) {
        // Redireciona para o dashboard
        header('Location: dashboard.php');
        exit;
    }
} catch (InvalidArgumentException $e) {
    // Redireciona para login com mensagem de erro
    header('Location: ../../index.php?erro=credenciais&mensagem=' . urlencode($e->getMessage()));
    exit;
} catch (Exception $e) {
    // Erro genérico do sistema
    header('Location: ../../index.php?erro=sistema');
    exit;
}
?>