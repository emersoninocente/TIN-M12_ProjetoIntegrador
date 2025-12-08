<?php
// src/Models/LivroModel.php
require_once __DIR__ . '/Database.php';

class LivroModel {
    private $db;
    private $table = 'livros';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($titulo, $autor, $isbn, $genero, $editora, $resumo, $ano_publicacao, $edicao, $quantidade_paginas, $quantidade_total, $quantidade_disponivel, $capa_url, $ativo) {
        $query = "INSERT INTO $this->table (titulo, autor, isbn, genero, editora, resumo, ano_publicacao, edicao, quantidade_paginas, quantidade_total, quantidade_disponivel, capa_url, ativo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->db->prepare($query);

        try{
            return $stmt->execute([$titulo, $autor, $isbn, $genero, $editora, $resumo, $ano_publicacao, $edicao, $quantidade_paginas, $quantidade_total, $quantidade_disponivel, $capa_url, $ativo]);
        } catch (Exception $e) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table . " WHERE 1=1";
        $query .= " ORDER BY titulo ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $titulo, $autor, $isbn, $genero, $editora, $resumo, $ano_publicacao, $edicao, $quantidade_paginas, $quantidade_total, $quantidade_disponivel, $capa_url, $ativo) {
        $query = "UPDATE $this->table SET titulo=?, autor=?, isbn=?, genero=?, editora=?, resumo=?, ano_publicacao=?, edicao=?, quantidade_paginas=?, quantidade_total=?, quantidade_disponivel=?, capa_url=?, ativo=? WHERE id=?";
        $stmt = $this->db->prepare($query);

        try {
            return $stmt->execute([$titulo, $autor, $isbn, $genero, $editora, $resumo, $ano_publicacao, $edicao, $quantidade_paginas, $quantidade_total, $quantidade_disponivel, $capa_url, $ativo, $id]);
        } catch (Exception $e) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE id = ?";
        $stmt = $this->db->prepare($query);

        try {
            return $stmt->execute([$id]);
        } catch(Exception $e) {
            throw new Exception("Error Processing Request", 1);
        }
    }

     /**
     * Busca livros com base em múltiplos critérios de filtro.
     */
    public function search($titulo, $autor, $genero, $isbn, $editora) {
        $query = "SELECT * FROM " . $this->table . " WHERE ativo = 1";
        $params = [];

        if (!empty($titulo)) {
            $query .= " AND titulo LIKE ?";
            $params[] = "%$titulo%";
        }
        if (!empty($autor)) {
            $query .= " AND autor LIKE ?";
            $params[] = "%$autor%";
        }
        if (!empty($genero)) {
            $query .= " AND genero LIKE ?";
            $params[] = "%$genero%";
        }
        if (!empty($isbn)) {
            $query .= " AND isbn LIKE ?";
            $params[] = "%$isbn%";
        }
        if (!empty($editora)) {
            $query .= " AND editora LIKE ?";
            $params[] = "%$editora%";
        }

        $query .= " ORDER BY titulo ASC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}