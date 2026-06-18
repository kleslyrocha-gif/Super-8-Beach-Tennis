<?php
$participantes = json_decode(file_get_contents('../data/participantes.json'), true) ?: [];
$dadosRodadas = json_decode(file_get_contents('../data/rodadas.json'), true) ?: [];
$rodadas = $dadosRodadas['rodadas'] ?? [];

$classificacao = [];
foreach ($participantes as $jogador) {
    $classificacao[$jogador['id']] = [
        'nome' => $jogador['nome'],
        'jogos' => 0,
        'vitorias' => 0,
        'derrotas' => 0,
        'gamesPro' => 0,
        'gamesContra' => 0,
        'saldo' => 0,
        'pontos' => 0
    ];
}

foreach ($rodadas as $rodada) {
    foreach ($rodada['partidas'] ?? [] as $partida) {
        if (is_null($partida['placarA'] ?? null) || is_null($partida['placarB'] ?? null)) {
            continue;
        }

        $placarA = (int)$partida['placarA'];
        $placarB = (int)$partida['placarB'];
        $a = $partida['duplaA'] ?? [];
        $b = $partida['duplaB'] ?? [];

        foreach ($a as $id) {
            if (!isset($classificacao[$id])) {
                continue;
            }
            $classificacao[$id]['jogos']++;
            $classificacao[$id]['gamesPro'] += $placarA;
            $classificacao[$id]['gamesContra'] += $placarB;
            $classificacao[$id]['pontos'] += $placarA;
        }

        foreach ($b as $id) {
            if (!isset($classificacao[$id])) {
                continue;
            }
            $classificacao[$id]['jogos']++;
            $classificacao[$id]['gamesPro'] += $placarB;
            $classificacao[$id]['gamesContra'] += $placarA;
            $classificacao[$id]['pontos'] += $placarB;
        }

        if ($placarA > $placarB) {
            foreach ($a as $id) {
                if (!isset($classificacao[$id])) {
                    continue;
                }
                $classificacao[$id]['vitorias']++;
                $classificacao[$id]['pontos'] += 2;
            }
            foreach ($b as $id) {
                if (!isset($classificacao[$id])) {
                    continue;
                }
                $classificacao[$id]['derrotas']++;
            }
        } elseif ($placarB > $placarA) {
            foreach ($b as $id) {
                if (!isset($classificacao[$id])) {
                    continue;
                }
                $classificacao[$id]['vitorias']++;
                $classificacao[$id]['pontos'] += 2;
            }
            foreach ($a as $id) {
                if (!isset($classificacao[$id])) {
                    continue;
                }
                $classificacao[$id]['derrotas']++;
            }
        }
    }
}

foreach ($classificacao as &$j) {
    $j['saldo'] = $j['gamesPro'] - $j['gamesContra'];
}

usort($classificacao, function ($a, $b) {
    if ($a['pontos'] === $b['pontos']) {
        if ($a['saldo'] === $b['saldo']) {
            return $b['vitorias'] <=> $a['vitorias'];
        }
        return $b['saldo'] <=> $a['saldo'];
    }
    return $b['pontos'] <=> $a['pontos'];
});
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
                        <th>Jogador</th>
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
