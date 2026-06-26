<?php
$participantesPath = __DIR__ . "/data/participantes.json";
$rodadasPath = __DIR__ . "/data/rodadas.json";

$participantes = [];
if (file_exists($participantesPath)) {
    $conteudo = file_get_contents($participantesPath);
    $participantes = json_decode($conteudo, true) ?: [];
}

$dadosRodadas = [];
if (file_exists($rodadasPath)) {
    $conteudoRodadas = file_get_contents($rodadasPath);
    $dadosRodadas = json_decode($conteudoRodadas, true) ?: [];
}

$rodadas = $dadosRodadas['rodadas'] ?? [];
$totalParticipantes = count($participantes);
$totalRodadas = count($rodadas);

$partidasTotais = 0;
$partidasFinalizadas = 0;

foreach ($rodadas as $rodada) {
    foreach ($rodada['partidas'] ?? [] as $partida) {
        $partidasTotais++;
        if (
             $partida['placarA'] !== null &&
             $partida['placarB'] !== null
) {
             $partidasFinalizadas++;
}
    }
}

$porcentagem = $partidasTotais > 0
    ? round(($partidasFinalizadas / $partidasTotais) * 100)
    : 0;

require_once 'utils/pontuacao.php';

$lider = "---";

if (!empty($participantes) && !empty($rodadas)) {

    $ranking = calcularClassificacao(
        $participantes,
        $rodadas
    );

    if (!empty($ranking)) {
        $lider = $ranking[0]['nome'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super 8 Beach Tennis</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="top-nav">
        <a href="javascript:history.back()" class="btn btn-nav">← Voltar</a>
        <a href="index.php" class="btn btn-nav"> Início</a>
    </div>

    <header>
        <h1>Super 8 Beach Tennis</h1>
        <p>Sistema de gerenciamento do torneio</p>
    </header>

    <section class="torneio-config">
        <div class="torneio-config-card">
            <h2>Nome do torneio</h2>
            <div class="torneio-config-row">
                <input
                    type="text"
                    id="nome-torneio-input"
                    class="torneio-input"
                    placeholder="Digite o nome do torneio"
                    maxlength="60"
                >
                <button type="button" id="btn-salvar-torneio" class="btn">Salvar</button>
            </div>
            <p class="torneio-preview" id="torneio-preview">Ainda não definido</p>
        </div>
    </section>

    <main>
        <section class="dashboard">
            <div class="card">
                <h3>👥 Participantes</h3>
                <span><?= $totalParticipantes ?> / 8</span>
            </div>

            <div class="card">
                <h3>🎾 Rodadas</h3>
                <span><?= $totalRodadas ?> / 7</span>
            </div>

            <div class="card">
                <h3>🏆 Líder</h3>
                <span><?= htmlspecialchars($lider) ?></span>
            </div>

            <div class="card">
                <h3>📊 Partidas</h3>
                <span><?= $partidasFinalizadas ?> / <?= $partidasTotais ?></span>
            </div>
        </section>

        <section class="progresso">
            <div class="progresso-header">
                <h2>Progresso do Torneio</h2>
                <span><?= $porcentagem ?>%</span>
            </div>
            <div class="barra">
                <div class="preenchimento" style="width: <?= $porcentagem ?>%"></div>
            </div>
            <p><?= $partidasFinalizadas ?> de <?= $partidasTotais ?> partidas concluídas</p>
        </section>

        <section class="menu">
            <a href="configuracao/configuracao.php" class="btn">⚙️ Configurar Torneio</a>
            <a href="rodadas/rodadas.php" class="btn">🎾 Registrar Resultados</a>
            <a href="classificacao/classificacao.php" class="btn">🏆 Classificação</a>
            <a href="utils/reset_torneio.php" class="btn danger" onclick="return confirm('Deseja reiniciar todo o torneio?')">🔄 Reiniciar Torneio</a>
        </section>
    </main>

    <script src="js/ui.js"></script>
    <script>
        const inputNome = document.getElementById('nome-torneio-input');
        const preview = document.getElementById('torneio-preview');
        const btnSalvar = document.getElementById('btn-salvar-torneio');

        function atualizarPreview() {
            const valor = inputNome.value.trim();
            const texto = valor || 'Ainda não definido';
            preview.textContent = texto;
            localStorage.setItem('nomeTorneio', valor);
        }

        const nomeSalvo = localStorage.getItem('nomeTorneio') || '';
        if (nomeSalvo) {
            inputNome.value = nomeSalvo;
        }
        atualizarPreview();

        inputNome.addEventListener('input', atualizarPreview);
        btnSalvar.addEventListener('click', () => {
            atualizarPreview();
            preview.textContent = inputNome.value.trim() || 'Ainda não definido';
        });
    </script>
</body>
</html>