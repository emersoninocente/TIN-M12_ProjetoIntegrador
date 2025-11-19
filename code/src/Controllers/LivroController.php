<?php
// src/Controllers/LivroController.php
require_once __DIR__ . "/../Models/LivroModel.php";

class LivroController {
    private $livroModel;

    public function __construct() {
        $this->livroModel = new LivroModel();
    }

    public function tratarLivros($id,$titulo,$autor,$isbn,$genero,$editora,$resumo,$ano_publicacao,$edicao,$quantidade_paginas,$quantidade_total,$quantidade_disponivel,$capa_url,$ativo){
        // Tratar dados do form para model
        // Pode ser usada para criar ou editar, colocar if para campo ID
        empty($id) ? throw new InvalidArgumentException("Campo ID inválido!") : $id;
        empty($titulo) ? throw new InvalidArgumentException("Campo TÍTULO inválido!") : $titulo;
        empty($autor) ? throw new InvalidArgumentException("Campo AUTOR inválido!") : $titulo;
        empty($isbn) ? throw new InvalidArgumentException("Campo ISBN inválido!") : $isbn;
        empty($genero) ? throw new InvalidArgumentException("Campo GÊNERO inválido!") : $genero;
        empty($editora) ? throw new InvalidArgumentException("Campo EDITORA inválido!") : $editora;
        empty($ano_publicacao) ? throw new InvalidArgumentException("Campo ANO DE PUBLICAÇÃO inválido!") : $ano_publicacao;
        empty($edicao) ? throw new InvalidArgumentException("Campo EDIÇÃO inválido!") : $edicao;
        // Podemos seguir com as validacoes dos demais campos
        
        if ($id == 0) {
            return $this->livroModel->create($titulo,$autor,$isbn,$genero,$editora,$resumo,$ano_publicacao,$edicao,$quantidade_paginas,$quantidade_total,$quantidade_disponivel,$capa_url,$ativo);
        } else {
            return $this->livroModel->update($id,$titulo,$autor,$isbn,$genero,$editora,$resumo,$ano_publicacao,$edicao,$quantidade_paginas,$quantidade_total,$quantidade_disponivel,$capa_url,$ativo);
        }
    }
}