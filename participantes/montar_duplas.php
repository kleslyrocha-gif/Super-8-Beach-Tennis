<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['formato'] = 'fixas';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Duplas Fixas</title>

<link rel="stylesheet" href="../css/style.css">

<style>

.dupla-box{
    background:#fff;
    border-radius:12px;
    padding:15px;
    margin-bottom:15px;
    box-shadow:0 2px 8px rgba(0,0,0,.1);
}

.dupla-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
}

.dupla-grid input{
    padding:10px;
    width:100%;
}

</style>

</head>
<body>

<div class="top-nav">
    <a href="../configuracao/configuracao.php" class="btn btn-nav">
        ← Voltar
    </a>

    <a href="../index.php" class="btn btn-nav">
        🏠 Início
    </a>
</div>

<header>
    <h1>🎾 Cadastro das Duplas Fixas</h1>
</header>

<main>

<section class="panel">

<form action="salvar_duplas.php" method="POST">

<div class="dupla-box">

<h3>Dupla 1</h3>

<div class="dupla-grid">
<input type="text" name="dupla1[]" placeholder="Jogador 1" required>
<input type="text" name="dupla1[]" placeholder="Jogador 2" required>
</div>

</div>

<div class="dupla-box">

<h3>Dupla 2</h3>

<div class="dupla-grid">
<input type="text" name="dupla2[]" placeholder="Jogador 3" required>
<input type="text" name="dupla2[]" placeholder="Jogador 4" required>
</div>

</div>

<div class="dupla-box">

<h3>Dupla 3</h3>

<div class="dupla-grid">
<input type="text" name="dupla3[]" placeholder="Jogador 5" required>
<input type="text" name="dupla3[]" placeholder="Jogador 6" required>
</div>

</div>

<div class="dupla-box">

<h3>Dupla 4</h3>

<div class="dupla-grid">
<input type="text" name="dupla4[]" placeholder="Jogador 7" required>
<input type="text" name="dupla4[]" placeholder="Jogador 8" required>
</div>

</div>

<button type="submit" class="btn btn-full">
🎾 Gerar Rodadas
</button>

</form>

</section>

</main>

</body>
</html>