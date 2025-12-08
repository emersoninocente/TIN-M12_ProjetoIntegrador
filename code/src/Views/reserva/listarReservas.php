<?php
// src/Views/reserva/listarReservas.php
require_once __DIR__ . '/../../Controllers/AuthController.php';
require_once __DIR__ . '/../../Controllers/ReservaController.php';

AuthController::verificarLogin();
$usuarioLogado = AuthController::getUsuarioLogado();

$reservaController = new ReservaController();
$reservas = $reservaController->listarReservasUsuario($usuarioLogado['id']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Reservas - Sistema de Biblioteca</title>
    <link rel="stylesheet" href="../../../public/style.css">
</head>
<body>
    <div class="container">
        <?php include '../partials/header.php'; ?>
        <br>
        <h2>Minhas Reservas</h2>

        <?php
            if (isset($_GET['sucesso'])) {
                echo '<div class="alert alert-sucesso">';
                switch($_GET['sucesso']) {
                    case 'reserva_criada':
                        echo "Reserva criada com sucesso!";
                        break;
                    case 'reserva_cancelada':
                        echo "Reserva cancelada com sucesso!";
                        break;
                }
                echo '</div>';
            }

            if (isset($_GET['erro'])) {
                echo '<div class="alert alert-erro">';
                switch($_GET['erro']) {
                    case 'cancelar':
                        echo "Erro ao cancelar reserva: " . htmlspecialchars($_GET['mensagem'] ?? '');
                        break;
                    case 'sem_reservas':
                        echo "Você ainda não possui reservas.";
                        break;
                }
                echo '</div>';
            }
        ?>

        <div class="actions-bar">
            <a href="../livro/listarLivros.php" class="btn-novo">📖 Buscar Livros</a>
        </div>

        <?php if (empty($reservas)): ?>
            <div class="empty-state">
                <p>Você ainda não possui reservas.</p>
                <a href="../livro/listarLivros.php" class="btn-novo">Buscar Livros para Reservar</a>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Livro</th>
                        <th>Data Reserva</th>
                        <th>Data Retirada</th>
                        <th>Data Prev. Devolução</th>
                        <th>Data Devolução</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($reservas as $reserva): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reserva['id']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['livro_titulo']); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($reserva['data_reserva'])); ?></td>
                        <td><?php echo $reserva['data_retirada'] ? date('d/m/Y', strtotime($reserva['data_retirada'])) : '-'; ?></td>
                        <td><?php echo $reserva['data_prevista_devolucao'] ? date('d/m/Y', strtotime($reserva['data_prevista_devolucao'])) : '-'; ?></td>
                        <td><?php echo $reserva['data_devolucao'] ? date('d/m/Y', strtotime($reserva['data_devolucao'])) : '-'; ?></td>
                        <td>
                            <span class="status-badge status-<?php echo $reserva['status']; ?>">
                                <?php 
                                    switch($reserva['status']) {
                                        case 'pendente': echo 'Pendente'; break;
                                        case 'ativa': echo 'Ativa'; break;
                                        case 'concluida': echo 'Concluída'; break;
                                        default: echo htmlspecialchars($reserva['status']);
                                    }
                                ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($reserva['status'] === 'pendente'): ?>
                                <a href="processaCancelarReserva.php?id=<?php echo $reserva['id']; ?>" 
                                   class="btn-deletar"
                                   onclick="return confirm('Tem certeza que deseja cancelar esta reserva?');">
                                    Cancelar
                                </a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <style>
        .actions-bar {
            margin: 20px 0;
            display: flex;
            gap: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #f9f9f9;
            border-radius: 8px;
            margin-top: 20px;
        }

        .empty-state p {
            font-size: 18px;
            color: #666;
            margin-bottom: 20px;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-pendente {
            background: #fff3cd;
            color: #856404;
        }

        .status-ativa {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-concluida {
            background: #d4edda;
            color: #155724;
        }

        .text-muted {
            color: #999;
        }
    </style>
</body>
</html>