<?php
// src/Views/listarLivrosGerenciar.php
require_once __DIR__ . '/../../Controllers/AuthController.php';
require_once __DIR__ . '/../../Controllers/LivroController.php';

AuthController::verificarPermissao(['bibliotecario', 'administrador']);

$livroController = new LivroController();
$livros = $livroController->listarLivros();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Livros - Sistema de Biblioteca</title>
    <link rel="stylesheet" href="../../../public/style.css">
</head>
<body>
    <div class="container">
        <?php include '../partials/header.php'; ?>
        <br>
        <h2>Gerenciar Livros</h2>

        <?php
            if (isset($_GET['sucesso'])) {
                echo '<div class="alert alert-sucesso">';
                switch($_GET['sucesso']) {
                    case 'livro_criado':
                        echo "Livro cadastrado com sucesso!";
                        break;
                    case 'livro_atualizado':
                        echo "Livro atualizado com sucesso!";
                        break;
                }
                echo '</div>';
            }

            if (isset($_GET['erro'])) {
                echo '<div class="alert alert-erro">';
                switch($_GET['erro']) {
                    case 'validacao':
                        echo "Erro na validação: " . htmlspecialchars($_GET['mensagem'] ?? '');
                        break;
                    case 'falha_criar':
                        echo "Erro ao criar livro!";
                        break;
                    case 'falha_atualizar':
                        echo "Erro ao atualizar livro!";
                        break;
                }
                echo '</div>';
            }
        ?>

        <a href="criarLivro.php" class="btn-novo">+ Novo Livro</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>ISBN</th>
                    <th>Gênero</th>
                    <th>Editora</th>
                    <th>Ano</th>
                    <th>Qtd Total</th>
                    <th>Qtd Disponível</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($livros as $livro): ?>
                <tr>
                    <td><?php echo htmlspecialchars($livro['id']); ?></td>
                    <td><?php echo htmlspecialchars($livro['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($livro['autor']); ?></td>
                    <td><?php echo htmlspecialchars($livro['isbn']); ?></td>
                    <td><?php echo htmlspecialchars($livro['genero']); ?></td>
                    <td><?php echo htmlspecialchars($livro['editora']); ?></td>
                    <td><?php echo htmlspecialchars($livro['ano_publicacao']); ?></td>
                    <td><?php echo htmlspecialchars($livro['quantidade_total']); ?></td>
                    <td><?php echo htmlspecialchars($livro['quantidade_disponivel']); ?></td>
                    <td>
                        <span class="status-badge <?php echo $livro['ativo'] ? 'status-ativo' : 'status-inativo'; ?>">
                            <?php echo $livro['ativo'] ? 'Ativo' : 'Inativo'; ?>
                        </span>
                    </td>
                    <td>
                        <a href="editarLivro.php?id=<?php echo $livro['id']; ?>" class="btn-editar">Editar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <style>
        .status-ativo {
            background: #d4edda;
            color: #155724;
        }

        .status-inativo {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</body>
</html>