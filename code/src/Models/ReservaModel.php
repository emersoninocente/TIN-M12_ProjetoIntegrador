<?php
// src/Models/ReservaModel.php
require_once __DIR__ . '/Database.php';

/**
 * usuario_id, livro_id, data_reserva, data_retirada, data_prevista_devolucao, data_devolucao, status, observacoes, bibliotecario_retirada_id, bibliotecario_devolucao_id 
 *
 * $usuario_id, $livro_id, $data_reserva, $data_retirada, $data_prevista_devolucao, $data_devolucao, $status, $observacoes, $bibliotecario_retirada_id, $bibliotecario_devolucao_id
 */

class ReservaModel {
    private $db;
    private $table = 'reservas';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($usuario_id, $livro_id, $data_reserva, $data_retirada, $data_prevista_devolucao, $data_devolucao, $status, $observacoes, $bibliotecario_retirada_id, $bibliotecario_devolucao_id) {
        $query = "INSERT INTO $this->table (usuario_id, livro_id, data_reserva, data_retirada, data_prevista_devolucao, data_devolucao, status, observacoes, bibliotecario_retirada_id, bibliotecario_devolucao_id) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->db->prepare($query);

        try{
            return $stmt->execute([$usuario_id, $livro_id, $data_reserva, $data_retirada, $data_prevista_devolucao, $data_devolucao, $status, $observacoes, $bibliotecario_retirada_id, $bibliotecario_devolucao_id]);
        } catch (Exception $e) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table . " WHERE 1=1";
        $query .= " ORDER BY data_reserva DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $usuario_id, $livro_id, $data_reserva, $data_retirada, $data_prevista_devolucao, $data_devolucao, $status, $observacoes, $bibliotecario_retirada_id, $bibliotecario_devolucao_id) {
        $query = "UPDATE $this->table SET usuario_id=?, livro_id=?, data_reserva=?, data_retirada=?, data_prevista_devolucao=?, data_devolucao=?, status=?, observacoes=?, bibliotecario_retirada_id=?, bibliotecario_devolucao_id=? WHERE id=?";
        $stmt = $this->db->prepare($query);

        try {
            return $stmt->execute([$usuario_id, $livro_id, $data_reserva, $data_retirada, $data_prevista_devolucao, $data_devolucao, $status, $observacoes, $bibliotecario_retirada_id, $bibliotecario_devolucao_id, $id]);
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
     * Busca todas as reservas de um usuário específico.
     * Junta com a tabela de livros para obter o título.
     */
    public function readByUserId($usuario_id) {
        $query = "SELECT r.*, l.titulo as livro_titulo 
                  FROM " . $this->table . " r
                  JOIN livros l ON r.livro_id = l.id
                  WHERE r.usuario_id = ? 
                  ORDER BY r.data_reserva DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}