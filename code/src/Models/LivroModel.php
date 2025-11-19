<?php
// src/Models/LivroModel.php
require_once __DIR__ . '/Database.php';

class LivroModel {
    private $db;
    private $table = 'livros';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function readAll() {
        // Busca todos os livros
        $query = "SELECT id,titulo,autor,isbn,genero,editora,resumo,ano_publicacao,edicao,quantidade_paginas,quantidade_total,quantidade_disponivel,capa_url,ativo
                  FROM " . $this->table . " WHERE 1=1";
        $query .= " ORDER BY titulo ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readOne(int $id) {
        // Busca apenas um livro
        $query = "SELECT titulo,autor,isbn,genero,editora,resumo,ano_publicacao,edicao,quantidade_paginas,quantidade_total,quantidade_disponivel,capa_url,ativo
                  FROM " . $this->table . " WHERE id=?";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($titulo,$autor,$isbn,$genero,$editora,$resumo,$ano_publicacao,$edicao,$quantidade_paginas,$quantidade_total,$quantidade_disponivel,$capa_url,$ativo) {
        // Cria um novo livro
        $query = "INSERT INTO $this->table (titulo,autor,isbn,genero,editora,resumo,ano_publicacao,edicao,quantidade_paginas,quantidade_total,quantidade_disponivel,capa_url,ativo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->db->prepare($query);

        try{
            return $stmt->execute([$titulo,$autor,$isbn,$genero,$editora,$resumo,$ano_publicacao,$edicao,$quantidade_paginas,$quantidade_total,$quantidade_disponivel,$capa_url,$ativo]);
        } catch (Exception $e) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function update($id,$titulo,$autor,$isbn,$genero,$editora,$resumo,$ano_publicacao,$edicao,$quantidade_paginas,$quantidade_total,$quantidade_disponivel,$capa_url,$ativo) {
        // Atualiza um livro existente
            $query = "UPDATE $this->table SET titulo=?,autor=?,isbn=?,genero=?,editora=?,resumo=?,ano_publicacao=?,edicao=?,quantidade_paginas=?,quantidade_total=?,quantidade_disponivel=?,capa_url=?,ativo=? WHERE id=?";
        $stmt = $this->db->prepare($query);

        try {
            return $stmt->execute([$titulo,$autor,$isbn,$genero,$editora,$resumo,$ano_publicacao,$edicao,$quantidade_paginas,$quantidade_total,$quantidade_disponivel,$capa_url,$ativo,$id]);
        } catch (Exception $e) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function search() {
        // Procura livros por parâmetros
    }

}