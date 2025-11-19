<?php
// src/Views/editarUsuario.php
require_once __DIR__ . '/../Controllers/UsuarioController.php';

// Validar se temos o ID enviado corretamente
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    header('Location: listarUsuarios.php?erro=id_invalido');
    exit;
}

// Carregamos os metodos da Controller
$usuarioController = new UsuarioController();
$usuarios = $usuarioController->buscaTodosUsuarios();
$usuario = null;

foreach ($usuarios as $u) {
    if ($u['id'] == $id) {
        $usuario = $u;
        break;
    }
}

if (!$usuario) {
    header('Location: listarUsuarios.php?erro=id_invalido');
    exit;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8'>
        <title>Edita um usuário no sistema</title>
        <link rel="stylesheet" href="../../public/style.css">
    </head>
    <body>
      <div class='container'>
        <h2>Editar Usários</h2>

        <?php
            if (isset($_GET['erro'])) {
                echo '<div class="alert alert-erro">';
                switch ($_GET['erro']){
                    case 'validacao':
                        echo "Erro na validação dos dados informados!<br>";
                        echo $_GET['mensagem'];
                        break;
                }
                echo '</div>';
            }
        ?>

        <form action='processaEditarUsuario.php' method='POST'>
            <!-- Precimos enviar ID de forma oculta -->
            <input type='hidden' id='id' name='id' value="<?php echo $id; ?>">
            <div class='form-group'>
                <label for='nome'>Nome:<span class="required">*</span></label>
                <input type='text' id='nome' name='nome' value="<?php echo $usuario['nome']; ?>" require>
            </div>

            <div class='form-group'>
                <label for='email'>E-mail:<span class="required">*</span></label>
                <input type='text' id='email' name='email' value="<?php echo $usuario['email']; ?>" require>
            </div>
            
            <div class='form-group'>
                <label for='cpf'>CPF:<span class="required">*</span></label>
                <input type='text' id='cpf' name='cpf' value="<?php echo $usuario['cpf']; ?>" require>
            </div>

            <div class='form-group'>
                <label for='telefone'>Telefone:<span class="required">*</span></label>
                <input type='text' id='telefone' name='telefone' value="<?php echo $usuario['telefone']; ?>" require>
            </div>

            <div class='form-group'>
                <label for='perfil'>Perfil:<span class="required">*</span></label>
                <select id='perfil' name='perfil' require>
                    <option value='usuario' <?php echo $usuario['perfil'] == 'usuario' ? 'selected':'' ?>>Usuário</option>
                    <option value='bibliotecario' <?php echo $usuario['perfil'] == 'bibliotecario' ? 'selected':'' ?>>Bibliotecário</option>
                    <option value='administrador' <?php echo $usuario['perfil'] == 'administrador' ? 'selected':'' ?>>Administrador</option>
                </select>
            </div>
            
            <div class='form-group'>
                <label for='ativo'>Status:<span class="required">*</span></label>
                <select id='ativo' name='ativo' require>
                    <option value='1' <?php echo $usuario['ativo'] == 1 ? 'selected':'' ?>>Ativo</option>
                    <option value='0' <?php echo $usuario['ativo'] == 0 ? 'selected':'' ?>>Inativo</option>
                </select>
            </div>

            <div class='form-group'>
                <button type='submit' class="btn-novo">Atualizar</button>
                <button type='button' onclick="window.location.href='listarUsuarios.php'" class="btn-cancelar">Cancelar</button>
            </div>
        </form>
      </div>
    </body>
</html>