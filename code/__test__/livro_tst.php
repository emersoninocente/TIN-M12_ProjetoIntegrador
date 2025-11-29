<?php
require_once __DIR__ . '/../src/Models/LivroModel.php';

$acao = $_GET['acao'] ?? 'readAll';
$livroModel = new LivroModel();

switch ($acao) {
    case 'readAll':
        $data = $livroModel->readAll();
        var_dump($data);
        break;
    case 'create':
        $result = $livroModel->create('Titulo Exemplo', 'Autor Exemplo', '1234567890123', 'Ficção', 'Editora Exemplo', 'Resumo do livro exemplo', 2023, 1, 300, 10, 10, 'http://exemplo.com/capa.jpg', 1);
        echo $result ? "Livro criado com sucesso." : "Falha ao criar livro.";
        break;
    default:
        echo "Ação inválida.";
        break;
}