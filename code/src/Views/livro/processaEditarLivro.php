<?php
// src/Views/livro/processaEditarLivro.php
require_once __DIR__ . '/../../Controllers/AuthController.php';
require_once __DIR__ . '/../../Controllers/LivroController.php';

AuthController::verificarPermissao(['bibliotecario', 'administrador']);

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header('Location: listarLivrosGerenciar.php');
    exit;
}

// Captura os dados do formulário
$id = $_POST['id'] ?? null;
$titulo = trim($_POST['titulo'] ?? '');
$autor = trim($_POST['autor'] ?? '');
$isbn = trim($_POST['isbn'] ?? ''); // Não pode ser alterado, mas é enviado
$genero = trim($_POST['genero'] ?? '');
$editora = trim($_POST['editora'] ?? '');
$ano_publicacao = $_POST['ano_publicacao'] ?? '';
$edicao = trim($_POST['edicao'] ?? '') ?: null;
$quantidade_paginas = $_POST['quantidade_paginas'] ?? null;
$quantidade_total = $_POST['quantidade_total'] ?? 0;
$quantidade_disponivel = $_POST['quantidade_disponivel'] ?? 0;
$capa_url = trim($_POST['capa_url'] ?? '') ?: null;
$resumo = trim($_POST['resumo'] ?? '') ?: null;
$ativo = $_POST['ativo'] ?? 1;

// Validação de ID
if (!$id) {
    header('Location: listarLivrosGerenciar.php?erro=id_invalido');
    exit;
}

// Validação adicional de quantidades
if ($quantidade_total < 0) {
    header('Location: editarLivro.php?id=' . $id . '&erro=validacao&mensagem=' . urlencode('Quantidade total não pode ser negativa'));
    exit;
}

if ($quantidade_disponivel < 0) {
    header('Location: editarLivro.php?id=' . $id . '&erro=validacao&mensagem=' . urlencode('Quantidade disponível não pode ser negativa'));
    exit;
}

if ($quantidade_disponivel > $quantidade_total) {
    header('Location: editarLivro.php?id=' . $id . '&erro=validacao&mensagem=' . urlencode('Quantidade disponível não pode ser maior que a quantidade total'));
    exit;
}

// Validação adicional de quantidade de páginas
if (!empty($quantidade_paginas) && $quantidade_paginas < 1) {
    header('Location: editarLivro.php?id=' . $id . '&erro=validacao&mensagem=' . urlencode('Quantidade de páginas deve ser maior que zero'));
    exit;
}

try {
    $livroController = new LivroController();
    $result = $livroController->atualizarLivro(
        $id,
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
        $quantidade_disponivel,
        $capa_url,
        $ativo
    );

    if ($result) {
        header('Location: listarLivrosGerenciar.php?sucesso=livro_atualizado');
        exit;
    } else {
        header('Location: editarLivro.php?id=' . $id . '&erro=falha_atualizar');
        exit;
    }
} catch (InvalidArgumentException $e) {
    header('Location: editarLivro.php?id=' . $id . '&erro=validacao&mensagem=' . urlencode($e->getMessage()));
    exit;
} catch (PDOException $e) {
    header('Location: editarLivro.php?id=' . $id . '&erro=validacao&mensagem=' . urlencode('Erro ao atualizar livro no banco de dados'));
    exit;
} catch (Exception $e) {
    header('Location: editarLivro.php?id=' . $id . '&erro=validacao&mensagem=' . urlencode('Erro inesperado ao atualizar livro'));
    exit;
}
?>