<?php
// src/Views/dashboard.php
require_once __DIR__ . '/../Controllers/AuthController.php';

// Verifica se está logado
AuthController::verificarLogin();
$usuarioLogado = AuthController::getUsuarioLogado();
$perfil = $usuarioLogado['perfil'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Biblioteca</title>
    <link rel="stylesheet" href="../../public/style.css">
</head>
<body>
    <div class="container">
        <?php include 'partials/header.php'; ?>
        <br>
        <h2>Bem-vindo, <?php echo htmlspecialchars($usuarioLogado['nome']); ?>!</h2>
        
        <div class="dashboard-cards">
            <!-- Card: Minhas Reservas -->
            <div class="card">
                <h3>📚 Minhas Reservas</h3>
                <p>Visualize e gerencie suas reservas de livros</p>
                <a href="reserva/listarReservas.php" class="btn-novo">Acessar</a>
            </div>

            <!-- Card: Catálogo de Livros -->
            <div class="card">
                <h3>📖 Catálogo de Livros</h3>
                <p>Pesquise e reserve livros disponíveis</p>
                <a href="livro/listarLivros.php" class="btn-novo">Acessar</a>
            </div>

            <!-- Card: Meu Perfil -->
            <div class="card">
                <h3>👤 Meu Perfil</h3>
                <p>Edite seus dados e altere sua senha</p>
                <a href="usuario/editarMeuPerfil.php" class="btn-novo">Acessar</a>
            </div>

            <?php if ($perfil === 'bibliotecario' || $perfil === 'administrador'): ?>
            <!-- Card: Gerenciar Usuários -->
            <div class="card">
                <h3>👥 Gerenciar Usuários</h3>
                <p>Cadastre e gerencie usuários do sistema</p>
                <a href="usuario/listarUsuarios.php" class="btn-novo">Acessar</a>
            </div>

            <!-- Card: Gerenciar Livros -->
            <div class="card">
                <h3>📚 Gerenciar Livros</h3>
                <p>Cadastre e edite livros do acervo</p>
                <a href="livro/listarLivrosGerenciar.php" class="btn-novo">Acessar</a>
            </div>

            <!-- Card: Todas as Reservas -->
            <div class="card">
                <h3>📋 Todas as Reservas</h3>
                <p>Gerencie todas as reservas do sistema</p>
                <a href="reserva/listarTodasReservas.php" class="btn-novo">Acessar</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>