<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../utils/sorteio.php');

$formato = $_SESSION['formato'] ?? 'rotativas';

$arquivoParticipantes = '../data/participantes.json';

if (!file_exists($arquivoParticipantes)) {
    die('Cadastre os participantes primeiro.');
}

$participantes = json_decode(file_get_contents($arquivoParticipantes), true) ?: [];
if (count($participantes) !== 8) {
    die('É necessário ter exatamente 8 participantes.');
}

$rodadas = $formato === 'rotativas'
    ? gerarRodadasRotativas($participantes)
    : gerarRodadasFixas($participantes);

$dados = [
    'formato' => $formato,
    'rodadas' => $rodadas
];

file_put_contents(
    '../data/rodadas.json',
    json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Rodadas Geradas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="top-nav">
        <a href="javascript:history.back()" class="btn btn-nav">← Voltar</a>
        <a href="../index.php" class="btn btn-nav">🏠 Início</a>
    </div>

    <header>
        <h1>✅ Rodadas Geradas</h1>
        <p class="bem-vindo" id="bem-vindo">Bem-vindo ao torneio</p>
    </header>
    <main>
        <section class="panel success-panel">
            <h2>Torneio configurado com sucesso!</h2>
            <p>As <?= count($rodadas) ?> rodadas foram criadas.</p>
            <a class="btn btn-full" href="../rodadas/rodadas.php">Ir para Rodadas</a>
        </section>
    </main>
    <script src="../js/ui.js"></script>
    <script>
        const bemVindo = document.getElementById('bem-vindo');
        const nome = localStorage.getItem('nomeTorneio');
        if (bemVindo) {
            bemVindo.textContent = nome
                ? `Bem-vindo(a) ao ${nome}`
                : 'Bem-vindo(a) ao torneio';
        }
    </script>
</body>
</html>