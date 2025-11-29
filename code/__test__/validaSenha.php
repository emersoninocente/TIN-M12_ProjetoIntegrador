<?php
require_once __DIR__ . '/../src/Models/UsuarioModel.php';

$usuarioModel = new UsuarioModel();
$validar = $usuarioModel->updatePassword(2,"Password");

//$ret = password_verify("P@ssw0rd1",$validar[0]["senha"]);
//
//if ($ret) {
//    echo "Senha correta!";
//} else {
//    echo "Senha inválida!";
//}
?>