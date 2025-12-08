<?php
// src/Views/listarTodasReservas.php
require_once __DIR__ . '/../../Controllers/AuthController.php';
require_once __DIR__ . '/../../Controllers/ReservaController.php';

AuthController::verificarPermissao(['bibliotecario', 'administrador']);
$usuarioLogado = AuthController::getUsuarioLogado();

$reservaController = new ReservaController();
$reservas = $reservaController->listarTodasReservas();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todas as Reservas - Sistema de Biblioteca</title>
    <link rel="stylesheet" href="../../../public/style.css">
</head>
<body>
    <?php include '../partials/header.php'; ?>

    <div class="container">
        <h2>Gerenciar Reservas</h2>

        <?php
            if (isset($_GET['sucesso'])) {
                echo '<div class="alert alert-sucesso">';
                switch($_GET['sucesso']) {
                    case 'retirada_processada':
                        echo "Retirada processada com sucesso!";
                        break;
                    case 'devolucao_processada':
                        echo "Devolução processada com sucesso!";
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
                        echo "Erro ao cancelar: " . htmlspecialchars($_GET['mensagem'] ?? 'Erro desconhecido');
                        break;
                    default:
                        echo "Erro: " . htmlspecialchars($_GET['mensagem'] ?? 'Erro desconhecido');
                }
                echo '</div>';
            }
        ?>

        <?php if (empty($reservas)): ?>
            <div class="empty-state">
                <p>Nenhuma reserva cadastrada no sistema.</p>
            </div>
        <?php else: ?>
            <!-- Filtros -->
            <div class="filters">
                <button class="filter-btn active" onclick="filterReservas('todas')">Todas (<?php echo count($reservas); ?>)</button>
                <button class="filter-btn" onclick="filterReservas('pendente')">
                    Pendentes (<?php echo count(array_filter($reservas, fn($r) => $r['status'] === 'pendente')); ?>)
                </button>
                <button class="filter-btn" onclick="filterReservas('ativa')">
                    Ativas (<?php echo count(array_filter($reservas, fn($r) => $r['status'] === 'ativa')); ?>)
                </button>
                <button class="filter-btn" onclick="filterReservas('concluida')">
                    Concluídas (<?php echo count(array_filter($reservas, fn($r) => $r['status'] === 'concluida')); ?>)
                </button>
            </div>

            <div class="table-responsive">
                <table id="reservasTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuário ID</th>
                            <th>Livro ID</th>
                            <th>Data Reserva</th>
                            <th>Data Retirada</th>
                            <th>Prev. Devolução</th>
                            <th>Data Devolução</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($reservas as $reserva): ?>
                        <tr data-status="<?php echo $reserva['status']; ?>">
                            <td><?php echo htmlspecialchars($reserva['id']); ?></td>
                            <td><?php echo htmlspecialchars($reserva['usuario_id']); ?></td>
                            <td><?php echo htmlspecialchars($reserva['livro_id']); ?></td>
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
                            <td class="actions-cell">
                                <?php if ($reserva['status'] === 'pendente'): ?>
                                    <a href="processarRetirada.php?id=<?php echo $reserva['id']; ?>" class="btn-editar btn-small">Processar Retirada</a>
                                    <a href="processaCancelarReserva.php?id=<?php echo $reserva['id']; ?>" 
                                       class="btn-deletar btn-small"
                                       onclick="return confirm('Tem certeza que deseja cancelar esta reserva?');">
                                        Cancelar
                                    </a>
                                <?php elseif ($reserva['status'] === 'ativa'): ?>
                                    <a href="processarDevolucao.php?id=<?php echo $reserva['id']; ?>" class="btn-editar btn-small">Processar Devolução</a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <style>
        .filters {
            margin: 20px 0;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 20px;
            background: #f0f0f0;
            border: 2px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
        }

        .filter-btn:hover {
            background: #e0e0e0;
        }

        .filter-btn.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            white-space: nowrap;
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

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #f9f9f9;
            border-radius: 8px;
            margin-top: 20px;
        }

        .actions-cell {
            white-space: nowrap;
        }

        .btn-small {
            padding: 6px 12px;
            font-size: 12px;
            margin: 2px;
            display: inline-block;
        }

        @media (max-width: 768px) {
            table {
                font-size: 12px;
            }

            .btn-small {
                display: block;
                margin: 5px 0;
                width: 100%;
            }
        }
    </style>

    <script>
        function filterReservas(status) {
            const rows = document.querySelectorAll('#reservasTable tbody tr');
            const buttons = document.querySelectorAll('.filter-btn');
            
            // Atualiza botões
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Filtra linhas
            rows.forEach(row => {
                if (status === 'todas') {
                    row.style.display = '';
                } else {
                    row.style.display = row.dataset.status === status ? '' : 'none';
                }
            });
        }
    </script>
</body>
</html>