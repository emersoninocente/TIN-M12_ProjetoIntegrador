<?php
// index.php - Página de Login (raiz do projeto)
session_start();

// Se já estiver logado, redireciona para o dashboard
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: src/Views/dashboard.php');
    exit;
}

/**
 * Retorna a URL completa da requisição atual
 *
 * @return string
 */
function getCurrentUrl(): string {
    // Detecta protocolo (http ou https)
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' 
                 || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443))
                ? "https://" : "http://";

    // Host (domínio + porta se não padrão)
    $host = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? 'localhost');

    // Caminho e query string
    $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
    // Remove index.php da URI
    $requestUri = preg_replace('#index\.php#', '', $requestUri);

    return $protocol . $host . $requestUri;
}
$_SESSION["urlroot"] = getCurrentUrl();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Biblioteca</title>
    <link rel="stylesheet" href="public/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>📚 Sistema de Biblioteca</h1>
            <h2>Login</h2>

            <?php
                if (isset($_GET['erro'])) {
                    echo '<div class="alert alert-erro">';
                    switch ($_GET['erro']) {
                        case 'credenciais':
                            echo htmlspecialchars($_GET['mensagem'] ?? 'E-mail ou senha incorretos!');
                            break;
                        case 'sessao_expirada':
                            echo "Sessão expirada. Faça login novamente.";
                            break;
                        case 'acesso_negado':
                            echo "Acesso negado. Faça login para continuar.";
                            break;
                        case 'sistema':
                            echo "Erro no sistema. Tente novamente mais tarde.";
                            break;
                        default:
                            echo "Erro ao fazer login. Tente novamente.";
                    }
                    echo '</div>';
                }

                if (isset($_GET['sucesso'])) {
                    echo '<div class="alert alert-sucesso">';
                    switch ($_GET['sucesso']) {
                        case 'logout':
                            echo "Logout realizado com sucesso!";
                            break;
                    }
                    echo '</div>';
                }
            ?>

            <form action="src/Views/processaLogin.php" method="POST">
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required autofocus placeholder="seu@email.com">
                </div>

                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required placeholder="••••••••">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-novo btn-full">Entrar</button>
                </div>
            </form>

            <div class="login-info">
                <p><small>Credenciais de teste:</small></p>
                <p><small><strong>Admin:</strong> admin@biblioteca.com / Admin@123</small></p>
                <p><small><strong>Bibliotecário:</strong> bibliotecario@biblioteca.com / Biblio@123</small></p>
                <p><small><strong>Usuário:</strong> usuario@biblioteca.com / User@123</small></p>
            </div>
        </div>
    </div>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
        }

        .login-box h1 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .login-box h2 {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 20px;
            font-weight: normal;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn-novo {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-novo:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-full {
            width: 100%;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-erro {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-sucesso {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .login-info {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
        }

        .login-info p {
            margin: 5px 0;
            color: #666;
        }

        .login-info small {
            font-size: 12px;
        }

        @media (max-width: 500px) {
            .login-box {
                padding: 30px 20px;
            }

            .login-box h1 {
                font-size: 24px;
            }

            .login-box h2 {
                font-size: 18px;
            }
        }
    </style>
</body>
</html>