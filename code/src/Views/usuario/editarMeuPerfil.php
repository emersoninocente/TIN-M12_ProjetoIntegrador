<?php
// src/Views/usuario/editarMeuPerfil.php
require_once __DIR__ . '/../../Controllers/AuthController.php';
require_once __DIR__ . '/../../Models/UsuarioModel.php';

AuthController::verificarLogin();
$usuarioLogado = AuthController::getUsuarioLogado();

$usuarioModel = new UsuarioModel();
$usuario = $usuarioModel->findById($usuarioLogado['id']);

if (!$usuario) {
    header('Location: ../dashboard.php?erro=usuario_nao_encontrado');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - Sistema de Biblioteca</title>
    <link rel="stylesheet" href="../../../public/style.css">
</head>
<body>
    <div class="container">
        <?php include '../partials/header.php'; ?>
        <br>
        <h2>Meu Perfil</h2>

        <?php
            if (isset($_GET['sucesso'])) {
                echo '<div class="alert alert-sucesso">';
                switch($_GET['sucesso']) {
                    case 'perfil_atualizado':
                        echo "Perfil atualizado com sucesso!";
                        break;
                    case 'senha_alterada':
                        echo "Senha alterada com sucesso!";
                        break;
                }
                echo '</div>';
            }

            if (isset($_GET['erro'])) {
                echo '<div class="alert alert-erro">';
                switch($_GET['erro']) {
                    case 'validacao':
                        echo "Erro na validação dos dados: " . htmlspecialchars($_GET['mensagem'] ?? '');
                        break;
                    case 'falha_atualizar':
                        echo "Erro ao atualizar perfil!";
                        break;
                }
                echo '</div>';
            }
        ?>

        <div class="perfil-tabs">
            <button class="tab-btn active" onclick="showTab('dados')">Meus Dados</button>
            <button class="tab-btn" onclick="showTab('senha')">Alterar Senha</button>
        </div>

        <!-- Tab: Meus Dados -->
        <div id="tab-dados" class="tab-content active">
            <form action="processaEditarMeuPerfil.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

                <div class="form-group">
                    <label for="nome">Nome:<span class="required">*</span></label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail:<span class="required">*</span></label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="cpf">CPF:<span class="required">*</span></label>
                    <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($usuario['cpf']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone:<span class="required">*</span></label>
                    <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($usuario['telefone']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Perfil:</label>
                    <input type="text" value="<?php echo htmlspecialchars(ucfirst($usuario['perfil'])); ?>" disabled>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-novo">Atualizar Dados</button>
                    <button type="button" onclick="window.location.href='../dashboard.php'" class="btn-cancelar">Voltar</button>
                </div>
            </form>
        </div>

        <!-- Tab: Alterar Senha -->
        <div id="tab-senha" class="tab-content">
            <form action="processaAlterarMinhaSenha.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

                <div class="form-group">
                    <label for="senha_atual">Senha Atual:<span class="required">*</span></label>
                    <input type="password" id="senha_atual" name="senha_atual" required>
                </div>

                <div class="form-group">
                    <label for="senha_nova">Nova Senha:<span class="required">*</span></label>
                    <input type="password" id="senha_nova" name="senha_nova" required>
                    <small>Mínimo 6 caracteres, uma maiúscula, uma minúscula, um número e um caractere especial</small>
                </div>

                <div class="form-group">
                    <label for="senha_confirma">Confirme a Nova Senha:<span class="required">*</span></label>
                    <input type="password" id="senha_confirma" name="senha_confirma" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-novo">Alterar Senha</button>
                    <button type="button" onclick="window.location.href='../dashboard.php'" class="btn-cancelar">Voltar</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .perfil-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
        }

        .tab-btn {
            padding: 12px 24px;
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            cursor: pointer;
            font-size: 16px;
            color: #666;
            transition: all 0.3s;
        }

        .tab-btn:hover {
            color: #333;
            background: #f5f5f5;
        }

        .tab-btn.active {
            color: #667eea;
            border-bottom-color: #667eea;
            font-weight: bold;
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.3s;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        small {
            display: block;
            margin-top: 5px;
            color: #666;
            font-size: 12px;
        }
    </style>

    <script>
        function showTab(tabName) {
            // Esconde todas as tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Mostra a tab selecionada
            document.getElementById('tab-' + tabName).classList.add('active');
            event.target.classList.add('active');
        }
    </script>
</body>
</html>