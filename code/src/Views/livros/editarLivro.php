<?php
// src/Views/livros/editarLivro.php
require_once __DIR__ . '/../../Models/LivroModel.php';

// Validar se temos o ID enviado corretamente
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    header('Location: listarLivros.php?erro=id_invalido');
    exit;
}

// Carregamos os metodos da Controller
$livroModel = new LivroModel();
$livro = $livroModel->readOne($id);

if (!$livro) {
    header('Location: listarUsuarios.php?erro=id_invalido');
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8'>
        <title>Cadastro de Livros no Sistema</title>
        <link rel="stylesheet" href="../../../public/style.css">
    </head>
    <body>
      <div class='container'>
        <h2>Edição de Livro</h2>

        <?php
            if (isset($_GET['erro'])) {
                echo '<div class="alert alert-erro">';
                switch ($_GET['erro']){
                    case 'validacao':
                        echo "Erro na validação dos dados informados!<br>";
                        echo $_GET['mensagem'];
                        break;
                }
                echo '</div>';
            }
        ?>

        <form action='processaEditarLivro.php' method='POST'>
            <div class='form-group'>
                <label for='id'>ID:<span class="required">*</span></label>
                <input type='text' id='id' name='id' value="<?php echo $id; ?>" disabled>
            </div>

            <div class='form-group'>
                <label for='titulo'>Título:<span class="required">*</span></label>
                <input type='text' id='titulo' name='titulo' value="<?php echo $livro['titulo']; ?>" require>
            </div>

            <div class='form-group'>
                <label for='author'>Autor:<span class="required">*</span></label>
                <input type='text' id='author' name='author' value="<?php echo $livro['autor']; ?>" require>
            </div>
            
            <div class='form-group'>
                <label for='isbn'>ISBN:<span class="required">*</span></label>
                <input type='text' id='isbn' name='isbn' value="<?php echo $livro['isbn']; ?>" disabled>
            </div>

            <div class='form-group'>
                <label for='genero'>Gênero:<span class="required">*</span></label>
                <input type='text' id='genero' name='genero' value="<?php echo $livro['genero']; ?>" require>
            </div>

            <div class='form-group'>
                <label for='editora'>Editora:<span class="required">*</span></label>
                <input type='text' id='editora' name='editora' value="<?php echo $livro['editora']; ?>" require>
            </div>

            <div class='form-group'>
                <label for='resumo'>Resumo:</label>
                <textarea id='resumo' name='resumo' rows=5 cols="100" placeholder="Digite aqui o resumo do livro"><?php echo htmlspecialchars($livro['resumo']); ?></textarea>
            </div>

            <div class='form-group'>
                <label for='ano_publicacao'>Ano de Publicação:<span class="required">*</span></label>
                <input type='text' id='ano_publicacao' name='ano_publicacao' placeholder="Digite o ano YYYY" maxlength="4" value="<?php echo $livro['ano_publicacao']; ?>" require>
            </div>

            <div class='form-group'>
                <label for='edicao'>Edição:<span class="required">*</span></label>
                <input type='text' id='edicao' name='edicao' value="<?php echo $livro['edicao']; ?>" require>
            </div>

            <div class='form-group'>
                <label for='quantidade_paginas'>Quantidade de Páginas:<span class="required">*</span></label>
                <input type='text' id='quantidade_paginas' name='quantidade_paginas' value="<?php echo $livro['quantidade_paginas']; ?>" require>
            </div>

            <div class='form-group'>
                <label for='quantidade_total'>Quantidade de Livros:<span class="required">*</span></label>
                <input type='text' id='quantidade_total' name='quantidade_total' value="<?php echo $livro['quantidade_total']; ?>">
            </div>
            
            <div class='form-group'>
                <label for='quantidade_disponivel'>Quantidade de Livros Disponível:<span class="required">*</span></label>
                <input type='text' id='quantidade_disponivel' name='quantidade_disponivel' value="<?php echo $livro['quantidade_disponivel']; ?>">
            </div>

            <div class='form-group'>
                <label for='capa_url'>URL para Capa do Livro:</label>
                <input type='text' id='capa_url' name='capa_url' value="<?php echo $livro['capa_url']; ?>">
            </div>

            <div class='form-group'>
                <label for='ativo'>Status:<span class="required">*</span></label>
                <select id='ativo' name='ativo' require>
                    <option value='1' <?php echo $livro['ativo'] == 1 ? 'selected':'' ?>>Ativo</option>
                    <option value='0' <?php echo $livro['ativo'] == 0 ? 'selected':'' ?>>Inativo</option>
                </select>
            </div>

            <div class='form-group'>
                <button type='submit' class="btn-novo">Atualizar</button>
                <button type='button' onclick="window.location.href='listarLivros.php'" class="btn-cancelar">Cancelar</button>
            </div>
        </form>
      </div>
    </body>
</html>