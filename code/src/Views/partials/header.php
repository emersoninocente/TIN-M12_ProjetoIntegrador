<?php
// src/Views/partials/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="main-header">
    <div class="header-content">
        <div class="logo">
            <a href="<?php echo $_SESSION["urlroot"]; ?>src/Views/dashboard.php">📚 Sistema de Biblioteca</a>
        </div>
        <nav class="main-nav">
            <a href="<?php echo $_SESSION["urlroot"]; ?>src/Views/dashboard.php">Início</a>
            <a href="<?php echo $_SESSION["urlroot"]; ?>src/Views/reserva/listarReservas.php">Minhas Reservas</a>
            <a href="<?php echo $_SESSION["urlroot"]; ?>src/Views/livro/listarLivros.php">Livros</a>
            
            <?php if (isset($_SESSION['usuario_perfil']) && ($_SESSION['usuario_perfil'] === 'bibliotecario' || $_SESSION['usuario_perfil'] === 'administrador')): ?>
            <a href="<?php echo $_SESSION["urlroot"]; ?>src/Views/usuario/listarUsuarios.php">Usuários</a>
            <a href="<?php echo $_SESSION["urlroot"]; ?>src/Views/livro/listarLivrosGerenciar.php">Gerenciar Livros</a>
            <?php endif; ?>
            
            <div class="user-menu">
                <span>Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></span>
                <a href="<?php echo $_SESSION["urlroot"]; ?>src/Views/usuario/editarMeuPerfil.php">Meu Perfil</a>
                <a href="<?php echo $_SESSION["urlroot"]; ?>src/Views/processaLogout.php" class="btn-logout">Sair</a>
            </div>
        </nav>
    </div>
</header>

<style>
    .main-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .header-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .logo a {
        color: white;
        text-decoration: none;
        font-size: 24px;
        font-weight: bold;
    }

    .main-nav {
        display: flex;
        gap: 20px;
        align-items: center;
        flex-wrap: wrap;
    }

    .main-nav a {
        color: white;
        text-decoration: none;
        padding: 8px 15px;
        border-radius: 5px;
        transition: background 0.3s;
    }

    .main-nav a:hover {
        background: rgba(255,255,255,0.2);
    }

    .user-menu {
        display: flex;
        gap: 15px;
        align-items: center;
        margin-left: 20px;
        padding-left: 20px;
        border-left: 1px solid rgba(255,255,255,0.3);
    }

    .btn-logout {
        background: rgba(255,255,255,0.2);
        padding: 8px 15px !important;
    }

    .btn-logout:hover {
        background: rgba(255,255,255,0.3);
    }

    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            gap: 15px;
        }

        .main-nav {
            flex-direction: column;
            width: 100%;
        }

        .user-menu {
            margin-left: 0;
            padding-left: 0;
            border-left: none;
            border-top: 1px solid rgba(255,255,255,0.3);
            padding-top: 15px;
        }
    }
</style>