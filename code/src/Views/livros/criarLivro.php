<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8'>
        <title>Cadastro de Livros no Sistema</title>
        <link rel="stylesheet" href="../../../public/style.css">
    </head>
    <body>
      <div class='container'>
        <h2>Cadastrar Novo Livro</h2>

        <?php
            if (isset($_GET['erro'])) {
                echo '<div class="alert alert-erro">';
                switch ($_GET['erro']){
                    case 'validacao':
                        echo "Erro na validação dos dados informados!<br>";
                        echo $_GET['mensagem'];
                        break;
                    case 'criar':
                        echo 'Erro ao Criar o Livro!';
                        break;
                }
                echo '</div>';
            }
        ?>

        <form action='processaCriarLivro.php' method='POST'>
            <div class='form-group'>
                <label for='titulo'>Título:<span class="required">*</span></label>
                <input type='text' id='titulo' name='titulo' require>
            </div>

            <div class='form-group'>
                <label for='author'>Autor:<span class="required">*</span></label>
                <input type='text' id='author' name='author' require>
            </div>
            
            <div class='form-group'>
                <label for='isbn'>ISBN:<span class="required">*</span></label>
                <input type='password' id='isbn' name='isbn' require>
            </div>

            <div class='form-group'>
                <label for='genero'>Gênero:<span class="required">*</span></label>
                <input type='text' id='genero' name='genero' require>
            </div>

            <div class='form-group'>
                <label for='editora'>Editora:<span class="required">*</span></label>
                <input type='text' id='editora' name='editora' require>
            </div>

            <div class='form-group'>
                <label for='resumo'>Resumo:</label>
                <textarea id='resumo' name='resumo' rows=5 cols="100" placeholder="Digite aqui o resumo do livro"></textarea>
            </div>

            <div class='form-group'>
                <label for='ano_publicacao'>Ano de Publicação:<span class="required">*</span></label>
                <input type='date' id='ano_publicacao' name='ano_publicacao' require>
            </div>

            <div class='form-group'>
                <label for='edicao'>Edição:<span class="required">*</span></label>
                <input type='text' id='edicao' name='edicao' require>
            </div>

            <div class='form-group'>
                <label for='quantidade_paginas'>Quantidade de Páginas:<span class="required">*</span></label>
                <input type='text' id='quantidade_paginas' name='quantidade_paginas' require>
            </div>

            <div class='form-group'>
                <label for='quantidade_total'>Quantidade de Livros:<span class="required">*</span></label>
                <input type='text' id='quantidade_total' name='quantidade_total'>
            </div>
            
            <div class='form-group'>
                <label for='quantidade_disponivel'>Quantidade de Livros Disponível:<span class="required">*</span></label>
                <input type='text' id='quantidade_disponivel' name='quantidade_disponivel'>
            </div>

            <div class='form-group'>
                <label for='capa_url'>URL para Capa do Livro:</label>
                <input type='text' id='capa_url' name='capa_url'>
            </div>

            <div class='form-group'>
                <label for='ativo'>Status:<span class="required">*</span></label>
                <select id='ativo' name='ativo' require>
                    <option value='1' selected>Ativo</option>
                    <option value='0'>Inativo</option>
                </select>
            </div>

            <div class='form-group'>
                <button type='submit' class="btn-novo">Cadastrar</button>
                <button type='button' onclick="window.location.href='listarLivros.php'" class="btn-cancelar">Cancelar</button>
            </div>
        </form>
      </div>
    </body>
</html>