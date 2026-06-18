<?php
$arquivo = '../data/rodadas.json';

if (!file_exists($arquivo)) {
    die('Nenhuma rodada foi gerada.');
}

$dados = json_decode(file_get_contents($arquivo), true) ?: [];
$participantes = json_decode(file_get_contents('../data/participantes.json'), true) ?: [];

function nomeJogador($id, $participantes) {
    foreach ($participantes as $p) {
        if ((int)$p['id'] === (int)$id) {
            return $p['nome'] ?? 'Jogador';
        }
    }
    return 'Jogador';
}

$rodadas = $dados['rodadas'] ?? [];
$rodadaAtual = 0;

foreach ($rodadas as $indice => $rodada) {

    $completa = true;

    foreach ($rodada['partidas'] as $partida) {

        if (
            $partida['placarA'] === null ||
            $partida['placarB'] === null
        ) {
            $completa = false;
            break;
        }
    }

    if (!$completa) {
        $rodadaAtual = $indice;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rodadas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="top-nav">
        <a href="javascript:history.back()" class="btn btn-nav">← Voltar</a>
        <a href="../index.php" class="btn btn-nav">🏠 Início</a>
    </div>

    <header>
        <h1>🎾 Rodadas do Torneio</h1>
        <p class="bem-vindo" id="bem-vindo">Bem-vindo ao torneio</p>
    </header>

    <main>
        <section class="panel">
            <div class="panel-header">
                <h2>Resultados por partida</h2>
                <a href="../classificacao/classificacao.php" class="btn btn-small">Ver classificação</a>
            </div>
            <p style="font-size:18px;font-weight:bold">
            🎾 Rodada Atual:
            <?= $rodadaAtual + 1 ?> de 7
            </p>

            <p>
            🕒  Faltam
            <?= 7 - ($rodadaAtual + 1) ?>
            rodadas.
            </p>
           <?php foreach ($rodadas as $indiceRodada => $rodada): ?>
                <div class="rodada">
                    <?php
                    $bloqueada = $indiceRodada > $rodadaAtual;
                    ?>

                    <h3>
                        Rodada <?= $rodada['numero'] ?>
                        <?php if ($indiceRodada == $rodadaAtual): ?>
                            🔥 Em andamento
                        <?php endif; ?>
                    </h3>
                    <?php foreach ($rodada['partidas'] ?? [] as $indice => $partida): ?>
                        <div class="partida">
                            <div class="partida-topo">
                                <h4>Quadra <?= $partida['quadra'] ?></h4>
                                <span class="status-partida <?= (!empty($partida['placarA']) && !empty($partida['placarB'])) ? 'concluida' : 'pendente' ?>">
                                    <?= (!empty($partida['placarA']) && !empty($partida['placarB'])) ? 'Concluída' : 'Pendente' ?>
                                </span>
                            </div>

                            <div class="dupla">
                                <strong><?= htmlspecialchars(nomeJogador($partida['duplaA'][0] ?? 0, $participantes)) ?></strong>
                                +
                                <strong><?= htmlspecialchars(nomeJogador($partida['duplaA'][1] ?? 0, $participantes)) ?></strong>
                            </div>
                            <div class="dupla">
                                <strong><?= htmlspecialchars(nomeJogador($partida['duplaB'][0] ?? 0, $participantes)) ?></strong>
                                +
                                <strong><?= htmlspecialchars(nomeJogador($partida['duplaB'][1] ?? 0, $participantes)) ?></strong>
                            </div>

                            <form action="salvar_placar.php" method="POST">
                                <input type="hidden" name="rodada" value="<?= $rodada['numero'] - 1 ?>">
                                <input type="hidden" name="partida" value="<?= $indice ?>">
                                <div class="placar">
                                    <input type="number" name="placarA" min="0" max="10" required value="<?= $partida['placarA'] ?? '' ?>">
                                    <span>X</span>
                                    <input type="number" name="placarB" min="0" max="10" required value="<?= $partida['placarB'] ?? '' ?>">
                                </div>
                                <button class="btn salvar"<?= $bloqueada ? 'disabled' : '' ?>>Salvar Resultado</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
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