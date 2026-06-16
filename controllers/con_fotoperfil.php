<?php
session_start();

$arquivo = '../users.json';
$usuarios = json_decode(file_get_contents($arquivo), true);

foreach ($usuarios as $i => $u) {
    if ($u['email'] === $_SESSION['usuario']) {

        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nomeArquivo = 'assets/img/perfil_' . md5($u['email']) . '.' . $extensao;

        move_uploaded_file($_FILES['foto']['tmp_name'], '../' . $nomeArquivo);

        $usuarios[$i]['foto'] = $nomeArquivo;
        break;
    }
}

file_put_contents($arquivo, json_encode($usuarios, JSON_PRETTY_PRINT));

header("Location: ../perfil.php");
exit();
?>