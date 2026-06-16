<?php
session_start();

$usuario = $_POST['usuario'];
$senha   = $_POST['senha'];

$arquivo = '../data/users.json';

if (!file_exists($arquivo)) {
    header("Location: ../login.php?erro=1");
    exit();
}

$usuarios = json_decode(file_get_contents($arquivo), true);

$encontrado = false;

foreach ($usuarios as $u) {
    if ($u['email'] === $usuario && password_verify($senha, $u['senha'])) {
        $_SESSION['logado'] = true;
        $_SESSION['usuario'] = $u['email'];
        $encontrado = true;
        break;
    }
}

if ($encontrado) {
    header("Location: ../perfil.php");
} else {
    header("Location: ../login.php?erro=1");
}
?>