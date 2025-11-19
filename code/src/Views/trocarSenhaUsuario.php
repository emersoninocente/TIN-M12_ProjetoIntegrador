<?php
// src/Views/trocarSenhaUsuario.php;

// Validar se temos o ID enviado corretamente
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    header('Location: listarUsuarios.php?erro=id_invalido');
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8'>
        <title>Troca Senha</title>
        <link rel="stylesheet" href="../../public/style.css">
    </head>
    <body>
      <div class='container'>
        <h2>Troca Senha do Usuário</h2>

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

        <form action='processaTrocarSenhaUsuario.php' method='POST'>
            <!-- Precimos enviar ID de forma oculta -->
            <input type='hidden' id='id' name='id' value="<?php echo $id; ?>">

            <div class='form-group'>
                <label for='password'>Senha:<span class="required">*</span></label>
                <input type='password' id='password_1' name='password_1' require>
            </div>

            <div class='form-group'>
                <label for='password'>Confirme a Senha:<span class="required">*</span></label>
                <input type='password' id='password_2' name='password_2' require>
            </div>

            <div class='form-group'>
                <button type='submit' class="btn-novo">Atualizar</button>
                <button type='button' onclick="window.location.href='listarUsuarios.php'" class="btn-cancelar">Cancelar</button>
            </div>
        </form>
      </div>
    </body>
</html>