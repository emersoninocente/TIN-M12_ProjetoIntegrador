<?php
// src/View/livros/listarLivros.php
require_once __DIR__ . '/../../Models/LivroModel.php';
$livroModel = new LivroModel();
$livros = $livroModel->readAll();
?>
<!DOCTYPE html>
<html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <title>Lista livros</title>
        <link rel="stylesheet" href="../../../public/style.css">
    </head>
    <body>
      <div class='container'>
        <h2>Lista de Livros</h2>

        <?php
            if (isset($_GET['sucesso'])) {
                echo '<div class="alert alert-sucesso">';
                switch($_GET['sucesso']) {
                    case 'criado':
                        echo "Livro Criado com Sucesso!";
                        break;
                    case 'atualizado':
                        echo "Livro Atualizado com Sucesso!";
                        break;
                }
                echo '</div>';
            }

            if (isset($_GET['erro'])) {
                echo '<div class="alert alert-error">';
                switch($_GET['erro']) {
                    case 'falha_atualizar':
                        echo "Erro ao Atualizar o Livro!";
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
                    <th>Resumo</th>
                    <th>Ano de Publicação</th>
                    <th>Edição</th>
                    <th>Quantidade de Páginas</th>
                    <th>Qtd de Livros</th>
                    <th>Qtd de Livros Disponível</th>
                    <th>Capa do Livro</th>
                    <th>Status</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($livros as $livro): ?>
                <tr>
                    <td><?php echo $livro['id']; ?></td>
                    <td><?php echo $livro['titulo']; ?></td>
                    <td><?php echo $livro['autor']; ?></td>
                    <td><?php echo $livro['isbn']; ?></td>
                    <td><?php echo $livro['genero']; ?></td>
                    <td><?php echo $livro['editora']; ?></td>
                    <td><?php echo $livro['resumo']; ?></td>
                    <td><?php echo $livro['ano_publicacao']; ?></td>
                    <td><?php echo $livro['edicao']; ?></td>
                    <td><?php echo $livro['quantidade_paginas']; ?></td>
                    <td><?php echo $livro['quantidade_total']; ?></td>
                    <td><?php echo $livro['quantidade_disponivel']; ?></td>
                    <td><?php echo $livro['capa_url']; ?></td>
                    <td><?php echo $livro['ativo'] ? 'Ativo': 'Inativo'; ?></td>
                    <td>
                        <a href="editarLivro.php?id=<?php echo $livro['id'];?>" class="btn-editar">Editar</a>
                        <a href="processaReservarLivro.php?id=<?php echo $livro['id'];?>" class="btn-deletar">Reservar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
      </div>
    </body>
</html>