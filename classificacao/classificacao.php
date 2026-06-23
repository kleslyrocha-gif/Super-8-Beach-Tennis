<?php
$participantes = json_decode(file_get_contents('../data/participantes.json'), true) ?: [];
$dadosRodadas = json_decode(file_get_contents('../data/rodadas.json'), true) ?: [];
$rodadas = $dadosRodadas['rodadas'] ?? [];

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../utils/pontuacao.php';

$formato = $_SESSION['formato'] ?? 'rotativas';

$classificacao = calcularClassificacao(
    $participantes,
    $rodadas
);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classificação</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="top-nav">
        <a href="javascript:history.back()" class="btn btn-nav">← Voltar</a>
        <a href="../index.php" class="btn btn-nav">🏠 Início</a>
    </div>

    <header>
        <h1>🏆 Classificação Geral</h1>
        <p class="bem-vindo" id="bem-vindo">Bem-vindo ao torneio</p>
    </header>
    <main>
        <section class="panel">
            <div class="panel-header topo">
                <h2>Ranking Atual</h2>
                <button class="btn btn-small imprimir" onclick="window.print()">🖨️ Imprimir</button>
            </div>
            <table class="tabela">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?= $formato === 'fixas' ? 'Dupla' : 'Jogador' ?></th>
                        <th>Jogos</th>
                        <th>Vitórias</th>
                        <th>Derrotas</th>
                        <th>GP</th>
                        <th>GC</th>
                        <th>Saldo</th>
                        <th>Pontos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $posicao = 1; foreach ($classificacao as $j): ?>
                    <tr class="<?= $posicao == 1 ? 'gold' : ($posicao == 2 ? 'silver' : ($posicao == 3 ? 'bronze' : '')) ?>">
                        <td><?= $posicao == 1 ? '🥇' : ($posicao == 2 ? '🥈' : ($posicao == 3 ? '🥉' : $posicao)) ?></td>
                        <td><?= htmlspecialchars($j['nome']) ?></td>
                        <td><?= $j['jogos'] ?></td>
                        <td><?= $j['vitorias'] ?></td>
                        <td><?= $j['derrotas'] ?></td>
                        <td><?= $j['gamesPro'] ?></td>
                        <td><?= $j['gamesContra'] ?></td>
                        <td><?= $j['saldo'] ?></td>
                        <td><strong><?= $j['pontos'] ?></strong></td>
                    </tr>
                    <?php $posicao++; endforeach; ?>
                </tbody>
            </table>
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
