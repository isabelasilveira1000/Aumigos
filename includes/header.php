<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SITE</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <?php if (isset($paginaCSS)): ?>
    <link rel="stylesheet" href="<?= $paginaCSS ?>">
  <?php endif; ?>
</head>

<body>

  <h1>AUmas gêmeas</h1>

<header>
    <div class="nav-links">
        <a href="inicio.php">Inicio</a>
        <a href="catalogo.php">AUmigos</a>
    </div>
    <div class="nav-right">
        <?php if (isset($_SESSION['logado'])): ?>
            <a href="perfil.php" class="btn-castrar">Perfil</a>
            <a href="sair.php" class="btn-entrar">Sair</a>
        <?php else: ?>
            <a href="cadastro.php" class="btn-castrar">Cadastrar</a>
            <a href="login.php" class="btn-entrar">Entrar</a>
        <?php endif; ?>
    </div>
</header>