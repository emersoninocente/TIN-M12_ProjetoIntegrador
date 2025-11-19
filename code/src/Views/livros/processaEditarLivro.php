<?php
require_once __DIR__ . "/../../Controllers/LivroController.php";

// Valida se método enviado é o que estamos esperando
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header('Location: listarLivros.php');
    exit;
}

// Capturar os dados recebidos
isset($_POST['id']) ? header('Location: listarLivros.php?erro=SemID') : $id = $_POST['id'];
$titulo = $_POST['titulo'];
$autor = $_POST['author'];
$isbn = $_POST['isbn'];
$genero = $_POST['genero'];
$editora = $_POST['editora'];
$resumo = $_POST['resumo'];
$ano_publicacao = $_POST['ano_publicacao'];
$edicao = $_POST['edicao'];
$quantidade_paginas = $_POST['quantidade_paginas'];
$quantidade_total = $_POST['quantidade_total'];
$quantidade_disponivel = $_POST['quantidade_disponivel'];
$capa_url = $_POST['capa_url'];
$ativo = $_POST['ativo'];

var_dump($id);
exit;

try {
    $livroController = new LivroController();
    $result = $livroController->tratarLivros($id,$titulo,$autor,$isbn,$genero,$editora,$resumo,$ano_publicacao,$edicao,$quantidade_paginas,$quantidade_total,$quantidade_disponivel,$capa_url,$ativo);

    if ($result) {
        header('Location: listarLivros.php?sucesso=atualizado');
        exit;
    } else {
        header('Location: listarLivros.php?erro=falha_atualizar');
        exit;
    }

} catch (InvalidArgumentException $e){
    header('Location: listarLivros.php?erro=validacao&mensagem=' . urlencode($e->getMessage()));
    exit;
}
?>