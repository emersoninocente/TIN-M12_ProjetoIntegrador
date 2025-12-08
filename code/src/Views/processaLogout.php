<?php
// src/Views/processaLogout.php
require_once __DIR__ . '/../Controllers/AuthController.php';

// Realiza o logout (destrói a sessão e redireciona)
AuthController::logout();
?>