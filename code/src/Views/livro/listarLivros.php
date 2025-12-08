<?php
// src/Views/listarLivros.php
require_once __DIR__ . '/../../Controllers/AuthController.php';
require_once __DIR__ . '/../../Controllers/LivroController.php';

AuthController::verificarLogin();

$livroController = new LivroController();

// Verifica se há filtros de busca
$titulo = $_GET['titulo'] ?? '';
$autor = $_GET['autor'] ?? '';
$genero = $_GET['genero'] ?? '';
$isbn = $_GET['isbn'] ?? '';
$editora = $_GET['editora'] ?? '';

// Se houver algum filtro, usa o método de busca
if (!empty($titulo) || !empty($autor) || !empty($genero) || !empty($isbn) || !empty($editora)) {
    $livros = $livroController->buscarLivros($titulo, $autor, $genero, $isbn, $editora);
} else {
    $livros = $livroController->listarLivros();
}

// Filtra apenas livros ativos
$livros = array_filter($livros, function($livro) {
    return $livro['ativo'] == 1;
});
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Livros - Sistema de Biblioteca</title>
    <link rel="stylesheet" href="../../../public/style.css">
</head>
<body>
    <div class="container">
        <?php include '../partials/header.php'; ?>
        <br>
        <h2>Catálogo de Livros</h2>

        <?php
            if (isset($_GET['sucesso'])) {
                echo '<div class="alert alert-sucesso">';
                echo "Reserva criada com sucesso!";
                echo '</div>';
            }

            if (isset($_GET['erro'])) {
                echo '<div class="alert alert-erro">';
                switch($_GET['erro']) {
                    case 'reserva':
                        echo htmlspecialchars($_GET['mensagem'] ?? 'Erro ao criar reserva.');
                        break;
                }
                echo '</div>';
            }
        ?>

        <!-- Formulário de Busca -->
        <div class="search-form">
            <h3>Buscar Livros</h3>
            <form method="GET" action="listarLivros.php">
                <div class="form-row">
                    <div class="form-group">
                        <label for="titulo">Título:</label>
                        <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>">
                    </div>

                    <div class="form-group">
                        <label for="autor">Autor:</label>
                        <input type="text" id="autor" name="autor" value="<?php echo htmlspecialchars($autor); ?>">
                    </div>

                    <div class="form-group">
                        <label for="genero">Gênero:</label>
                        <input type="text" id="genero" name="genero" value="<?php echo htmlspecialchars($genero); ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="isbn">ISBN:</label>
                        <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>">
                    </div>

                    <div class="form-group">
                        <label for="editora">Editora:</label>
                        <input type="text" id="editora" name="editora" value="<?php echo htmlspecialchars($editora); ?>">
                    </div>

                    <div class="form-group form-actions">
                        <button type="submit" class="btn-novo">🔍 Buscar</button>
                        <a href="listarLivros.php" class="btn-cancelar">Limpar</a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Lista de Livros -->
        <?php if (empty($livros)): ?>
            <div class="empty-state">
                <p>Nenhum livro encontrado.</p>
            </div>
        <?php else: ?>
            <div class="livros-grid">
                <?php foreach($livros as $livro): ?>
                <div class="livro-card">
                    <?php if (!empty($livro['capa_url'])): ?>
                        <img src="<?php echo htmlspecialchars($livro['capa_url']); ?>" alt="Capa do livro" class="livro-capa">
                    <?php else: ?>
                        <div class="livro-capa-placeholder">📚</div>
                    <?php endif; ?>
                    
                    <div class="livro-info">
                        <h3><?php echo htmlspecialchars($livro['titulo']); ?></h3>
                        <p class="livro-autor"><strong>Autor:</strong> <?php echo htmlspecialchars($livro['autor']); ?></p>
                        <p class="livro-genero"><strong>Gênero:</strong> <?php echo htmlspecialchars($livro['genero']); ?></p>
                        <p class="livro-editora"><strong>Editora:</strong> <?php echo htmlspecialchars($livro['editora']); ?></p>
                        <p class="livro-ano"><strong>Ano:</strong> <?php echo htmlspecialchars($livro['ano_publicacao']); ?></p>
                        <p class="livro-isbn"><strong>ISBN:</strong> <?php echo htmlspecialchars($livro['isbn']); ?></p>
                        
                        <?php if (!empty($livro['resumo'])): ?>
                        <p class="livro-resumo"><?php echo htmlspecialchars(substr($livro['resumo'], 0, 150)); ?>...</p>
                        <?php endif; ?>
                        
                        <div class="livro-disponibilidade">
                            <strong>Disponível:</strong> 
                            <span class="<?php echo $livro['quantidade_disponivel'] > 0 ? 'disponivel' : 'indisponivel'; ?>">
                                <?php echo $livro['quantidade_disponivel']; ?> de <?php echo $livro['quantidade_total']; ?>
                            </span>
                        </div>

                        <?php if ($livro['quantidade_disponivel'] > 0): ?>
                            <a href="../reserva/processaCriarReserva.php?livro_id=<?php echo $livro['id']; ?>" 
                               class="btn-novo btn-reservar"
                               onclick="return confirm('Deseja reservar este livro?');">
                                📖 Reservar
                            </a>
                        <?php else: ?>
                            <button class="btn-indisponivel" disabled>Indisponível</button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <style>
        .search-form {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .search-form h3 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        .livros-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .livro-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .livro-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .livro-capa {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .livro-capa-placeholder {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
        }

        .livro-info {
            padding: 20px;
        }

        .livro-info h3 {
            margin-top: 0;
            margin-bottom: 15px;
            color: #333;
            font-size: 18px;
        }

        .livro-info p {
            margin: 8px 0;
            font-size: 14px;
            color: #666;
        }

        .livro-resumo {
            margin: 15px 0;
            font-style: italic;
        }

        .livro-disponibilidade {
            margin: 15px 0;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 4px;
        }

        .disponivel {
            color: #28a745;
            font-weight: bold;
        }

        .indisponivel {
            color: #dc3545;
            font-weight: bold;
        }

        .btn-reservar {
            width: 100%;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .btn-indisponivel {
            width: 100%;
            padding: 12px;
            background: #ccc;
            color: #666;
            border: none;
            border-radius: 5px;
            cursor: not-allowed;
            margin-top: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #f9f9f9;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
</body>
</html>