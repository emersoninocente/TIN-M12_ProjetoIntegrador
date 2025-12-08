<?php
// src/Views/criarLivro.php
require_once __DIR__ . '/../../Controllers/AuthController.php';

AuthController::verificarPermissao(['bibliotecario', 'administrador']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Livro - Sistema de Biblioteca</title>
    <link rel="stylesheet" href="../../../public/style.css">
</head>
<body>
    <?php include '../partials/header.php'; ?>

    <div class="container">
        <h2>Cadastrar Novo Livro</h2>

        <?php
            if (isset($_GET['erro'])) {
                echo '<div class="alert alert-erro">';
                switch ($_GET['erro']) {
                    case 'validacao':
                        echo "Erro na validação dos dados: ";
                        echo htmlspecialchars($_GET['mensagem'] ?? '');
                        break;
                    case 'falha_criar':
                        echo "Erro ao cadastrar livro!";
                        break;
                }
                echo '</div>';
            }
        ?>

        <form action="processaCriarLivro.php" method="POST">
            <div class="form-row">
                <div class="form-group form-col-2">
                    <label for="titulo">Título:<span class="required">*</span></label>
                    <input type="text" id="titulo" name="titulo" required>
                </div>

                <div class="form-group form-col-2">
                    <label for="autor">Autor:<span class="required">*</span></label>
                    <input type="text" id="autor" name="autor" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="isbn">ISBN:<span class="required">*</span></label>
                    <input type="text" id="isbn" name="isbn" required placeholder="978-3-16-148410-0">
                    <small>ISBN-10 ou ISBN-13 (ex: 978-3-16-148410-0)</small>
                </div>

                <div class="form-group">
                    <label for="genero">Gênero:<span class="required">*</span></label>
                    <input type="text" id="genero" name="genero" required placeholder="Romance, Ficção, etc.">
                </div>

                <div class="form-group">
                    <label for="editora">Editora:<span class="required">*</span></label>
                    <input type="text" id="editora" name="editora" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="ano_publicacao">Ano de Publicação:<span class="required">*</span></label>
                    <input type="number" id="ano_publicacao" name="ano_publicacao" min="1000" max="<?php echo date('Y'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="edicao">Edição:</label>
                    <input type="text" id="edicao" name="edicao" placeholder="1ª, 2ª, etc.">
                </div>

                <div class="form-group">
                    <label for="quantidade_paginas">Quantidade de Páginas:</label>
                    <input type="number" id="quantidade_paginas" name="quantidade_paginas" min="1">
                </div>

                <div class="form-group">
                    <label for="quantidade_total">Quantidade Total:<span class="required">*</span></label>
                    <input type="number" id="quantidade_total" name="quantidade_total" min="1" value="1" required>
                </div>
            </div>

            <div class="form-group">
                <label for="capa_url">URL da Capa:</label>
                <input type="url" id="capa_url" name="capa_url" placeholder="https://exemplo.com/capa.jpg">
                <small>Opcional: Link para imagem da capa do livro</small>
            </div>

            <div class="form-group">
                <label for="resumo">Resumo:</label>
                <textarea id="resumo" name="resumo" rows="5" placeholder="Breve resumo do livro..."></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-novo">Cadastrar Livro</button>
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

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .form-col-2 {
                grid-column: span 1;
            }
        }
    </style>
</body>
</html>