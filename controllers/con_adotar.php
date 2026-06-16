<?php
session_start();

if (!isset($_SESSION['logado'])) {
    header("Location: ../login.php");
    exit();
}

$id          = intval($_POST['id'] ?? 0);
$motivo      = trim($_POST['motivo'] ?? '');
$pessoas     = $_POST['pessoas'] ?? '';
$animais     = $_POST['outros_animais'] ?? '';
$quintal     = $_POST['quintal'] ?? '';
$experiencia = $_POST['experiencia'] ?? '';

// Valida campos
if (!$id || !$motivo || !$pessoas || !$animais || !$quintal || !$experiencia) {
    header("Location: ../adotar.php?id=$id&erro=campos");
    exit();
}

$arq_caes  = __DIR__ . '/../data/caes.json';
$arq_users = __DIR__ . '/../data/users.json';

// Marca cão como indisponível
$caes       = json_decode(file_get_contents($arq_caes), true);
$encontrado = false;

foreach ($caes as &$cao) {
    if ($cao['id'] === $id && $cao['disponivel']) {
        $cao['disponivel']  = false;
        $cao['adotado_por'] = $_SESSION['usuario'];
        $encontrado = true;
        break;
    }
}
unset($cao);

if (!$encontrado) {
    header("Location: ../catalogo.php?erro=indisponivel");
    exit();
}

file_put_contents($arq_caes, json_encode($caes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// Salva adoção no perfil do usuário
$users = json_decode(file_get_contents($arq_users), true);
foreach ($users as &$u) {
    if ($u['email'] === $_SESSION['usuario']) {
        if (!isset($u['adocoes'])) $u['adocoes'] = [];
        $u['adocoes'][] = [
            'id_cao'      => $id,
            'motivo'      => $motivo,
            'pessoas'     => $pessoas,
            'animais'     => $animais,
            'quintal'     => $quintal,
            'experiencia' => $experiencia,
            'data'        => date('d/m/Y')
        ];
        break;
    }
}
unset($u);

file_put_contents($arq_users, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

header("Location: ../perfil.php?adocao=ok");
exit();