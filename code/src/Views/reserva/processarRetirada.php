<?php
// src/Views/reserva/processarRetirada.php
require_once __DIR__ . '/../../Controllers/AuthController.php';
require_once __DIR__ . '/../../Controllers/ReservaController.php';
require_once __DIR__ . '/../../Models/UsuarioModel.php';
require_once __DIR__ . '/../../Models/LivroModel.php';

AuthController::verificarPermissao(['bibliotecario', 'administrador']);

$reserva_id = $_GET['id'] ?? null;

if (!$reserva_id) {
    header('Location: listarTodasReservas.php?erro=id_invalido');
    exit;
}

// Busca informações da reserva
$reservaController = new ReservaController();
$todasReservas = $reservaController->listarTodasReservas();
$reserva = null;

foreach ($todasReservas as $r) {
    if ($r['id'] == $reserva_id) {
        $reserva = $r;
        break;
    }
}

if (!$reserva) {
    header('Location: listarTodasReservas.php?erro=reserva_nao_encontrada');
    exit;
}

// Busca informações do usuário e do livro
$usuarioModel = new UsuarioModel();
$livroModel = new LivroModel();

$usuario = $usuarioModel->findById($reserva['usuario_id']);
$livros = $livroModel->readAll();
$livro = null;

foreach ($livros as $l) {
    if ($l['id'] == $reserva['livro_id']) {
        $livro = $l;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processar Retirada - Sistema de Biblioteca</title>
    <link rel="stylesheet" href="../../public/style.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>

    <div class="container">
        <h2>Processar Retirada de Livro</h2>

        <?php
            if (isset($_GET['erro'])) {
                echo '<div class="alert alert-erro">';
                echo htmlspecialchars($_GET['mensagem'] ?? 'Erro ao processar retirada');
                echo '</div>';
            }
        ?>

        <div class="info-card">
            <h3>📋 Detalhes da Reserva</h3>
            <div class="info-grid">
                <div class="info-item">
                    <strong>Reserva ID:</strong>
                    <span><?php echo htmlspecialchars($reserva['id']); ?></span>
                </div>
                <div class="info-item">
                    <strong>Data da Reserva:</strong>
                    <span><?php echo date('d/m/Y H:i', strtotime($reserva['data_reserva'])); ?></span>
                </div>
                <div class="info-item">
                    <strong>Usuário:</strong>
                    <span><?php echo htmlspecialchars($usuario['nome'] ?? 'N/A'); ?> (ID: <?php echo $reserva['usuario_id']; ?>)</span>
                </div>
                <div class="info-item">
                    <strong>E-mail:</strong>
                    <span><?php echo htmlspecialchars($usuario['email'] ?? 'N/A'); ?></span>
                </div>
                <div class="info-item">
                    <strong>Telefone:</strong>
                    <span><?php echo htmlspecialchars($usuario['telefone'] ?? 'N/A'); ?></span>
                </div>
                <div class="info-item">
                    <strong>Livro:</strong>
                    <span><?php echo htmlspecialchars($livro['titulo'] ?? 'N/A'); ?></span>
                </div>
                <div class="info-item">
                    <strong>Autor:</strong>
                    <span><?php echo htmlspecialchars($livro['autor'] ?? 'N/A'); ?></span>
                </div>
                <div class="info-item">
                    <strong>ISBN:</strong>
                    <span><?php echo htmlspecialchars($livro['isbn'] ?? 'N/A'); ?></span>
                </div>
            </div>
        </div>

        <form action="processaRetirada.php" method="POST">
            <input type="hidden" name="reserva_id" value="<?php echo htmlspecialchars($reserva_id); ?>">

            <div class="form-group">
                <label for="data_prevista_devolucao">Data Prevista de Devolução:<span class="required">*</span></label>
                <input type="date" 
                       id="data_prevista_devolucao" 
                       name="data_prevista_devolucao" 
                       min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" 
                       value="<?php echo date('Y-m-d', strtotime('+14 days')); ?>" 
                       required>
                <small>Por padrão, 14 dias a partir de hoje. A data deve ser futura.</small>
            </div>

            <div class="info-box">
                <h3>ℹ️ Informações da Retirada</h3>
                <p><strong>Data de Retirada:</strong> <?php echo date('d/m/Y'); ?> (hoje)</p>
                <p><strong>Bibliotecário Responsável:</strong> <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></p>
            </div>

            <div class="alert alert-info">
                <strong>Importante:</strong> Ao confirmar a retirada, o status da reserva será alterado para "Ativa" e o livro ficará vinculado ao usuário até a devolução.
            </div>

            <div class="form-group">
                <button type="submit" class="btn-novo">✓ Confirmar Retirada</button>
                <button type="button" onclick="window.location.href='listarTodasReservas.php'" class="btn-cancelar">Cancelar</button>
            </div>
        </form>
    </div>

    <style>
        .info-card {
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 25px;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .info-card h3 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
            font-size: 18px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .info-item strong {
            color: #666;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-item span {
            color: #333;
            font-size: 15px;
        }

        .info-box {
            background: #f0f8ff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }

        .info-box h3 {
            margin-top: 0;
            color: #333;
            font-size: 16px;
        }

        .info-box p {
            margin: 10px 0;
            color: #666;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }

        small {
            display: block;
            margin-top: 5px;
            color: #666;
            font-size: 12px;
        }

        .required {
            color: #dc3545;
        }
    </style>
</body>
</html>