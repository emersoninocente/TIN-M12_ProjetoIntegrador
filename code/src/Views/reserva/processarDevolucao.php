<?php
// src/Views/processarDevolucao.php
require_once __DIR__ . '/../../Controllers/AuthController.php';

AuthController::verificarPermissao(['bibliotecario', 'administrador']);

$reserva_id = $_GET['id'] ?? null;

if (!$reserva_id) {
    header('Location: listarTodasReservas.php?erro=id_invalido');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processar Devolução - Sistema de Biblioteca</title>
    <link rel="stylesheet" href="../../../public/style.css">
</head>
<body>
    <?php include '../partials/header.php'; ?>

    <div class="container">
        <h2>Processar Devolução de Livro</h2>

        <?php
            if (isset($_GET['erro'])) {
                echo '<div class="alert alert-erro">';
                echo htmlspecialchars($_GET['mensagem'] ?? 'Erro ao processar devolução');
                echo '</div>';
            }
        ?>

        <form action="processaDevolucao.php" method="POST">
            <input type="hidden" name="reserva_id" value="<?php echo htmlspecialchars($reserva_id); ?>">

            <div class="info-box">
                <h3>ℹ️ Informações da Devolução</h3>
                <p><strong>Reserva ID:</strong> <?php echo htmlspecialchars($reserva_id); ?></p>
                <p><strong>Data de Devolução:</strong> <?php echo date('d/m/Y H:i'); ?></p>
            </div>

            <div class="form-group">
                <label for="observacoes">Observações (opcional):</label>
                <textarea id="observacoes" name="observacoes" rows="4" placeholder="Ex: Livro devolvido em bom estado, sem avarias"></textarea>
                <small>Informe o estado do livro ou qualquer observação relevante</small>
            </div>

            <div class="alert alert-info">
                <strong>Importante:</strong> Ao confirmar a devolução, o status da reserva será alterado para "Concluída" e o livro ficará disponível novamente no acervo.
            </div>

            <div class="form-group">
                <button type="submit" class="btn-novo">✓ Confirmar Devolução</button>
                <button type="button" onclick="window.location.href='listarTodasReservas.php'" class="btn-cancelar">Cancelar</button>
            </div>
        </form>
    </div>

    <style>
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
            font-size: 18px;
        }

        .info-box p {
            margin: 10px 0;
            color: #666;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: inherit;
            resize: vertical;
        }

        small {
            display: block;
            margin-top: 5px;
            color: #666;
            font-size: 12px;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</body>
</html>