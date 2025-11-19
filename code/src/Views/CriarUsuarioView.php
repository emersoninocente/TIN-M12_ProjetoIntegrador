<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Novo Usuário</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #f4f4f9; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 20px auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #444; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Importante para o padding não afetar a largura */
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        button:hover { background-color: #0056b3; }
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
            font-weight: bold;
        }
        .message.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .message.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastro de Usuário</h1>

        <?php if (!empty($mensagem)): ?>
            <div class="message <?php echo strpos(strtolower($mensagem), 'sucesso') !== false ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <form action="processaUsuario.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($dadosSubmetidos['nome'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($dadosSubmetidos['email'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>

            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" value="<?php echo htmlspecialchars($dadosSubmetidos['cpf'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" placeholder="+55 51 99999-9999" value="<?php echo htmlspecialchars($dadosSubmetidos['telefone'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="perfil">Perfil:</label>
                <select id="perfil" name="perfil" required>
                    <option value="usuario" <?php echo (isset($dadosSubmetidos['perfil']) && $dadosSubmetidos['perfil'] === 'usuario') ? 'selected' : ''; ?>>
                        Usuário
                    </option>
                    <option value="bibliotecario" <?php echo (isset($dadosSubmetidos['perfil']) && $dadosSubmetidos['perfil'] === 'bibliotecario') ? 'selected' : ''; ?>>
                        Bibliotecário
                    </option>
                    <option value="administrador" <?php echo (isset($dadosSubmetidos['perfil']) && $dadosSubmetidos['perfil'] === 'administrador') ? 'selected' : ''; ?>>
                        Administrador
                    </option>
                </select>
            </div>

            <button type="submit">Cadastrar Usuário</button>
        </form>
    </div>
</body>
</html>