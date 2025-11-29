<?php
// src/Views/livro/editarLivro.php
require_once __DIR__ . '/../../Controllers/AuthController.php';
require_once __DIR__ . '/../../Controllers/LivroController.php';

AuthController::verificarPermissao(['bibliotecario', 'administrador']);

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: listarLivrosGerenciar.php?erro=id_invalido');
    exit;
}

$livroController = new LivroController();
$livros = $livroController->listarLivros();
$livro = null;

foreach ($livros as $l) {
    if ($l['id'] == $id) {
        $livro = $l;
        break;
    }
}

if (!$livro) {
    header('Location: listarLivrosGerenciar.php?erro=livro_nao_encontrado');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro - Sistema de Biblioteca</title>
    <link rel="stylesheet" href="../../../public/style.css">
</head>
<body>
    <?php include '../partials/header.php'; ?>

    <div class="container">
        <h2>Editar Livro</h2>

        <?php
            if (isset($_GET['erro'])) {
                echo '<div class="alert alert-erro">';
                switch ($_GET['erro']) {
                    case 'validacao':
                        echo "Erro na validação: " . htmlspecialchars($_GET['mensagem'] ?? '');
                        break;
                    case 'falha_atualizar':
                        echo "Erro ao atualizar livro!";
                        break;
                }
                echo '</div>';
            }
        ?>

        <form action="processaEditarLivro.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($livro['id']); ?>">

            <div class="form-row">
                <div class="form-group form-col-2">
                    <label for="titulo">Título:<span class="required">*</span></label>
                    <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($livro['titulo']); ?>" required>
                </div>

                <div class="form-group form-col-2">
                    <label for="autor">Autor:<span class="required">*</span></label>
                    <input type="text" id="autor" name="autor" value="<?php echo htmlspecialchars($livro['autor']); ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="isbn">ISBN:<span class="required">*</span></label>
                    <input type="text" 
                           id="isbn" 
                           name="isbn" 
                           value="<?php echo htmlspecialchars($livro['isbn']); ?>" 
                           readonly 
                           style="background-color: #f0f0f0; cursor: not-allowed;">
                    <small><strong>⚠️ Nota:</strong> O ISBN não pode ser alterado por segurança e integridade dos dados</small>
                </div>

                <div class="form-group">
                    <label for="genero">Gênero:<span class="required">*</span></label>
                    <input type="text" id="genero" name="genero" value="<?php echo htmlspecialchars($livro['genero']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="editora">Editora:<span class="required">*</span></label>
                    <input type="text" id="editora" name="editora" value="<?php echo htmlspecialchars($livro['editora']); ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="ano_publicacao">Ano de Publicação:<span class="required">*</span></label>
                    <input type="number" 
                           id="ano_publicacao" 
                           name="ano_publicacao" 
                           value="<?php echo htmlspecialchars($livro['ano_publicacao']); ?>" 
                           min="1000" 
                           max="<?php echo date('Y'); ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="edicao">Edição:</label>
                    <input type="text" id="edicao" name="edicao" value="<?php echo htmlspecialchars($livro['edicao']); ?>" placeholder="1ª, 2ª, etc.">
                </div>

                <div class="form-group">
                    <label for="quantidade_paginas">Quantidade de Páginas:</label>
                    <input type="number" 
                           id="quantidade_paginas" 
                           name="quantidade_paginas" 
                           value="<?php echo htmlspecialchars($livro['quantidade_paginas']); ?>" 
                           min="1">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="quantidade_total">Quantidade Total:<span class="required">*</span></label>
                    <input type="number" 
                           id="quantidade_total" 
                           name="quantidade_total" 
                           value="<?php echo htmlspecialchars($livro['quantidade_total']); ?>" 
                           min="0" 
                           required>
                    <small>Total de exemplares no acervo</small>
                </div>

                <div class="form-group">
                    <label for="quantidade_disponivel">Quantidade Disponível:<span class="required">*</span></label>
                    <input type="number" 
                           id="quantidade_disponivel" 
                           name="quantidade_disponivel" 
                           value="<?php echo htmlspecialchars($livro['quantidade_disponivel']); ?>" 
                           min="0" 
                           max="<?php echo htmlspecialchars($livro['quantidade_total']); ?>"
                           required>
                    <small>Exemplares disponíveis para empréstimo</small>
                </div>

                <div class="form-group">
                    <label for="ativo">Status:<span class="required">*</span></label>
                    <select id="ativo" name="ativo" required>
                        <option value="1" <?php echo $livro['ativo'] == 1 ? 'selected' : ''; ?>>Ativo</option>
                        <option value="0" <?php echo $livro['ativo'] == 0 ? 'selected' : ''; ?>>Inativo</option>
                    </select>
                    <small>Livros inativos não aparecem para os usuários</small>
                </div>
            </div>

            <div class="form-group">
                <label for="capa_url">URL da Capa:</label>
                <input type="url" 
                       id="capa_url" 
                       name="capa_url" 
                       value="<?php echo htmlspecialchars($livro['capa_url']); ?>" 
                       placeholder="https://exemplo.com/capa.jpg">
                <small>Opcional: Link para imagem da capa do livro</small>
            </div>

            <div class="form-group">
                <label for="resumo">Resumo:</label>
                <textarea id="resumo" name="resumo" rows="5" placeholder="Breve resumo do livro..."><?php echo htmlspecialchars($livro['resumo']); ?></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-novo">💾 Atualizar Livro</button>
                <button type="button" onclick="window.location.href='listarLivrosGerenciar.php'" class="btn-cancelar">Cancelar</button>
            </div>
        </form>
    </div>

    <style>
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-col-2 {
            grid-column: span 2;
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

        .required {
            color: #dc3545;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .form-col-2 {
                grid-column: span 1;
            }
        }
    </style>

    <script>
        // Ajusta o max do campo quantidade_disponivel quando quantidade_total muda
        document.getElementById('quantidade_total').addEventListener('input', function() {
            const qtdDisponivel = document.getElementById('quantidade_disponivel');
            qtdDisponivel.max = this.value;
            
            // Se quantidade disponível for maior que o novo total, ajusta
            if (parseInt(qtdDisponivel.value) > parseInt(this.value)) {
                qtdDisponivel.value = this.value;
            }
        });
    </script>
</body>
</html>