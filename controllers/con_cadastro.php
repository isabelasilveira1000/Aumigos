<?php
session_start();

$nome         = $_POST['nome'];
$email        = $_POST['email'];
$cpf          = $_POST['cpf'];
$telefone     = $_POST['telefone'];
$endereco     = $_POST['endereco'];
$senha        = $_POST['senha'];
$senha_confirm = $_POST['senha_confirm'];

// valida se as senhas coincidem
if ($senha !== $senha_confirm) {
    header("Location: ../cadastro.php?erro=senha");
    exit();
}

// criptografa a senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// caminho do arquivo json
$arquivo = '../data/users.json';

// lê os usuários existentes
if (file_exists($arquivo)) {
    $usuarios = json_decode(file_get_contents($arquivo), true);
} else {
    $usuarios = [];
}

// verifica se email já existe
foreach ($usuarios as $u) {
    if ($u['email'] === $email) {
        header("Location: ../cadastro.php?erro=email");
        exit();
    }
}

// adiciona o novo usuário
$usuarios[] = [
    'nome'     => $nome,
    'email'    => $email,
    'cpf'      => $cpf,
    'telefone' => $telefone,
    'endereco' => $endereco,
    'senha'    => $senha_hash
];

// salva no json
file_put_contents($arquivo, json_encode($usuarios, JSON_PRETTY_PRINT));

header("Location: ../login.php");
exit();
?>