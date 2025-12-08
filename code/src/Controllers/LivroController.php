<?php
// src/Controllers/LivroController.php
require_once __DIR__ . "/../Models/LivroModel.php";

class LivroController {
    private $livroModel;

    public function __construct() {
        $this->livroModel = new LivroModel();
    }

    /**
     * Cria um novo livro
     */
    public function criarLivro($titulo, $autor, $isbn, $genero, $editora, $resumo, $ano_publicacao, $edicao, $quantidade_paginas, $quantidade_total, $capa_url = null) {
        // Validações
        if (empty($titulo)) {
            throw new InvalidArgumentException("Título é obrigatório!");
        }

        if (empty($autor)) {
            throw new InvalidArgumentException("Autor é obrigatório!");
        }

        if (empty($isbn)) {
            throw new InvalidArgumentException("ISBN é obrigatório!");
        }

        if (!$this->validarISBN($isbn)) {
            throw new InvalidArgumentException("ISBN inválido!");
        }

        if (empty($genero)) {
            throw new InvalidArgumentException("Gênero é obrigatório!");
        }

        if (empty($editora)) {
            throw new InvalidArgumentException("Editora é obrigatória!");
        }

        if (empty($ano_publicacao) || !is_numeric($ano_publicacao)) {
            throw new InvalidArgumentException("Ano de publicação inválido!");
        }

        if ($quantidade_total < 0) {
            throw new InvalidArgumentException("Quantidade total não pode ser negativa!");
        }

        $quantidade_disponivel = $quantidade_total;
        $ativo = 1;

        return $this->livroModel->create(
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
    }

    /**
     * Lista todos os livros
     */
    public function listarLivros() {
        return $this->livroModel->readAll();
    }

    /**
     * Busca livros com filtros
     */
    public function buscarLivros($titulo = '', $autor = '', $genero = '', $isbn = '', $editora = '') {
        return $this->livroModel->search($titulo, $autor, $genero, $isbn, $editora);
    }

    /**
     * Atualiza um livro (ISBN não pode ser alterado)
     */
    public function atualizarLivro($id, $titulo, $autor, $isbn, $genero, $editora, $resumo, $ano_publicacao, $edicao, $quantidade_paginas, $quantidade_total, $quantidade_disponivel, $capa_url, $ativo) {
        if (empty($id)) {
            throw new InvalidArgumentException("ID do livro inválido!");
        }

        if (empty($titulo)) {
            throw new InvalidArgumentException("Título é obrigatório!");
        }

        if (empty($autor)) {
            throw new InvalidArgumentException("Autor é obrigatório!");
        }

        if (empty($genero)) {
            throw new InvalidArgumentException("Gênero é obrigatório!");
        }

        if (empty($editora)) {
            throw new InvalidArgumentException("Editora é obrigatória!");
        }

        return $this->livroModel->update(
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
    }

    /**
     * Valida ISBN (ISBN-10 ou ISBN-13)
     */
    private function validarISBN($isbn) {
        // Remove hífens e espaços
        $isbn = preg_replace('/[^0-9X]/i', '', $isbn);
        
        $length = strlen($isbn);
        
        // ISBN-10
        if ($length == 10) {
            $sum = 0;
            for ($i = 0; $i < 9; $i++) {
                $sum += (int)$isbn[$i] * (10 - $i);
            }
            $lastChar = $isbn[9];
            $sum += ($lastChar == 'X' || $lastChar == 'x') ? 10 : (int)$lastChar;
            return ($sum % 11 == 0);
        }
        
        // ISBN-13
        if ($length == 13) {
            $sum = 0;
            for ($i = 0; $i < 12; $i++) {
                $sum += (int)$isbn[$i] * (($i % 2 == 0) ? 1 : 3);
            }
            $checkDigit = (10 - ($sum % 10)) % 10;
            return ($checkDigit == (int)$isbn[12]);
        }
        
        return false;
    }
}
?>