<?php
// src/Controllers/AuthController.php
require_once __DIR__ . "/../Models/UsuarioModel.php";

class AuthController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    /**
     * Processa o login do usuário
     */
    public function login($email, $senha) {
        // Validações básicas
        if (empty($email) || empty($senha)) {
            throw new InvalidArgumentException("E-mail e senha são obrigatórios!");
        }

        $emailTratado = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($emailTratado === false) {
            throw new InvalidArgumentException("E-mail inválido!");
        }

        // Busca usuário pelo e-mail
        $usuario = $this->usuarioModel->findByEmail($emailTratado);

        if (!$usuario) {
            throw new InvalidArgumentException("E-mail ou senha incorretos!");
        }

        // Verifica se usuário está ativo
        if ($usuario['ativo'] != 1) {
            throw new InvalidArgumentException("Usuário inativo! Entre em contato com o administrador.");
        }

        // Verifica a senha
        if (!password_verify($senha, $usuario['senha'])) {
            throw new InvalidArgumentException("E-mail ou senha incorretos!");
        }

        // Login bem-sucedido - inicia a sessão
        $this->iniciarSessao($usuario);
        return true;
    }

    /**
     * Inicia a sessão do usuário
     */
    private function iniciarSessao($usuario) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_perfil'] = $usuario['perfil'];
        $_SESSION['logged_in'] = true;
    }

    /**
     * Verifica se usuário está logado
     */
    public static function verificarLogin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: ../../../index.php');
            exit;
        }
    }

    /**
     * Verifica se usuário tem permissão para acessar recurso
     */
    public static function verificarPermissao($perfisPermitidos = []) {
        self::verificarLogin();

        if (!empty($perfisPermitidos)) {
            $perfilUsuario = $_SESSION['usuario_perfil'];
            if (!in_array($perfilUsuario, $perfisPermitidos)) {
                header('Location: dashboard.php?erro=sem_permissao');
                exit;
            }
        }
    }

    /**
     * Faz logout do usuário
     */
    public static function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();
        header('Location: ../../index.php');
        exit;
    }

    /**
     * Retorna dados do usuário logado
     */
    public static function getUsuarioLogado() {
        self::verificarLogin();
        
        return [
            'id' => $_SESSION['usuario_id'],
            'nome' => $_SESSION['usuario_nome'],
            'email' => $_SESSION['usuario_email'],
            'perfil' => $_SESSION['usuario_perfil']
        ];
    }
}
?>