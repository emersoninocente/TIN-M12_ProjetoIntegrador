<?php
// src/Controllers/ReservaController.php
require_once __DIR__ . "/../Models/ReservaModel.php";
require_once __DIR__ . "/../Models/LivroModel.php";

class ReservaController {
    private $reservaModel;
    private $livroModel;

    public function __construct() {
        $this->reservaModel = new ReservaModel();
        $this->livroModel = new LivroModel();
    }

    /**
     * Cria uma nova reserva
     */
    public function criarReserva($usuario_id, $livro_id) {
        if (empty($usuario_id) || empty($livro_id)) {
            throw new InvalidArgumentException("Dados inválidos para criar reserva!");
        }

        // Verifica se o livro existe e está disponível
        $livros = $this->livroModel->readAll();
        $livro = null;
        foreach ($livros as $l) {
            if ($l['id'] == $livro_id) {
                $livro = $l;
                break;
            }
        }

        if (!$livro) {
            throw new InvalidArgumentException("Livro não encontrado!");
        }

        if ($livro['quantidade_disponivel'] <= 0) {
            throw new InvalidArgumentException("Livro não disponível para reserva!");
        }

        // Cria a reserva
        $data_reserva = date('Y-m-d H:i:s');
        $status = 'pendente';
        
        $result = $this->reservaModel->create(
            $usuario_id,
            $livro_id,
            $data_reserva,
            null, // data_retirada
            null, // data_prevista_devolucao
            null, // data_devolucao
            $status,
            null, // observacoes
            null, // bibliotecario_retirada_id
            null  // bibliotecario_devolucao_id
        );

        return $result;
    }

    /**
     * Lista reservas de um usuário
     */
    public function listarReservasUsuario($usuario_id) {
        return $this->reservaModel->readByUserId($usuario_id);
    }

    /**
     * Lista todas as reservas (para bibliotecários e administradores)
     */
    public function listarTodasReservas() {
        return $this->reservaModel->readAll();
    }

    /**
     * Atualiza uma reserva
     */
    public function atualizarReserva($id, $usuario_id, $livro_id, $data_reserva, $data_retirada, $data_prevista_devolucao, $data_devolucao, $status, $observacoes, $bibliotecario_retirada_id, $bibliotecario_devolucao_id) {
        if (empty($id)) {
            throw new InvalidArgumentException("ID da reserva inválido!");
        }

        return $this->reservaModel->update(
            $id,
            $usuario_id,
            $livro_id,
            $data_reserva,
            $data_retirada,
            $data_prevista_devolucao,
            $data_devolucao,
            $status,
            $observacoes,
            $bibliotecario_retirada_id,
            $bibliotecario_devolucao_id
        );
    }

    /**
     * Processa retirada de livro (bibliotecário)
     */
    public function processarRetirada($reserva_id, $bibliotecario_id, $data_prevista_devolucao) {
        if (empty($reserva_id) || empty($bibliotecario_id) || empty($data_prevista_devolucao)) {
            throw new InvalidArgumentException("Dados inválidos!");
        }

        // Busca a reserva
        $reservas = $this->reservaModel->readAll();
        $reserva = null;
        foreach ($reservas as $r) {
            if ($r['id'] == $reserva_id) {
                $reserva = $r;
                break;
            }
        }

        if (!$reserva) {
            throw new InvalidArgumentException("Reserva não encontrada!");
        }

        $data_retirada = date('Y-m-d H:i:s');
        
        return $this->reservaModel->update(
            $reserva_id,
            $reserva['usuario_id'],
            $reserva['livro_id'],
            $reserva['data_reserva'],
            $data_retirada,
            $data_prevista_devolucao,
            null,
            'ativa',
            $reserva['observacoes'],
            $bibliotecario_id,
            null
        );
    }

    /**
     * Processa devolução de livro (bibliotecário)
     */
    public function processarDevolucao($reserva_id, $bibliotecario_id, $observacoes = null) {
        if (empty($reserva_id) || empty($bibliotecario_id)) {
            throw new InvalidArgumentException("Dados inválidos!");
        }

        // Busca a reserva
        $reservas = $this->reservaModel->readAll();
        $reserva = null;
        foreach ($reservas as $r) {
            if ($r['id'] == $reserva_id) {
                $reserva = $r;
                break;
            }
        }

        if (!$reserva) {
            throw new InvalidArgumentException("Reserva não encontrada!");
        }

        $data_devolucao = date('Y-m-d H:i:s');
        
        return $this->reservaModel->update(
            $reserva_id,
            $reserva['usuario_id'],
            $reserva['livro_id'],
            $reserva['data_reserva'],
            $reserva['data_retirada'],
            $reserva['data_prevista_devolucao'],
            $data_devolucao,
            'concluida',
            $observacoes ?? $reserva['observacoes'],
            $reserva['bibliotecario_retirada_id'],
            $bibliotecario_id
        );
    }

    /**
     * Cancela uma reserva
     */
    public function cancelarReserva($reserva_id, $usuario_id = null, $perfil = 'usuario') {
        if (empty($reserva_id)) {
            throw new InvalidArgumentException("ID da reserva inválido!");
        }

        // Busca a reserva
        $reservas = $this->reservaModel->readAll();
        $reserva = null;
        foreach ($reservas as $r) {
            if ($r['id'] == $reserva_id) {
                $reserva = $r;
                break;
            }
        }

        if (!$reserva) {
            throw new InvalidArgumentException("Reserva não encontrada!");
        }

        // Verifica permissão: usuário só pode cancelar suas próprias reservas pendentes
        if ($perfil === 'usuario') {
            if ($reserva['usuario_id'] != $usuario_id) {
                throw new InvalidArgumentException("Você não tem permissão para cancelar esta reserva!");
            }
            if ($reserva['status'] !== 'pendente') {
                throw new InvalidArgumentException("Apenas reservas pendentes podem ser canceladas pelo usuário!");
            }
        }

        return $this->reservaModel->delete($reserva_id);
    }
}
?>