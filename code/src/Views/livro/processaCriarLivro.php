<?php
// src/Views/livro/processaCriarLivro.php
require_once __DIR__ . '/../../Controllers/AuthController.php';
require_once __DIR__ . '/../../Controllers/LivroController.php';

AuthController::verificarPermissao(['bibliotecario', 'administrador']);

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header('Location: criarLivro.php');
    exit;
}

$titulo = $_POST['titulo'] ?? '';
$autor = $_POST['autor'] ?? '';
$isbn = $_POST['isbn'] ?? '';
$genero = $_POST['genero'] ?? '';
$editora = $_POST['editora'] ?? '';
$ano_publicacao = $_POST['ano_publicacao'] ?? '';
$edicao = $_POST['edicao'] ?? null;
$quantidade_paginas = $_POST['quantidade_paginas'] ?? null;
$quantidade_total = $_POST['quantidade_total'] ?? 1;
$capa_url = $_POST['capa_url'] ?? null;
$resumo = $_POST['resumo'] ?? null;

try {
    $livroController = new LivroController();
    $result = $livroController->criarLivro(
        $titulo,
        $autor,
        $isbn,
        $genero,
        $editora,
        $resumo,
        $ano_publicacao,
        $edicao,
        $quantidade_paginas,
        $quantidade_total,
        $capa_url
    );

    if ($result) {
        header('Location: listarLivrosGerenciar.php?sucesso=livro_criado');
        exit;
    } else {
        header('Location: criarLivro.php?erro=falha_criar');
        exit;
    }
} catch (InvalidArgumentException $e) {
    header('Location: criarLivro.php?erro=validacao&mensagem=' . urlencode($e->getMessage()));
    exit;
} catch (Exception $e) {
    header('Location: criarLivro.php?erro=validacao&mensagem=' . urlencode('Erro ao cadastrar livro'));
    exit;
}
?>