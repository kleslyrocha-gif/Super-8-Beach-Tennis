<?php
$arquivo = "../data/participantes.json";
$participantes = [];

if (file_exists($arquivo)) {
    $conteudo = file_get_contents($arquivo);
    $participantes = json_decode($conteudo, true) ?: [];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Participantes</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="top-nav">
        <a href="javascript:history.back()" class="btn btn-nav">← Voltar</a>
        <a href="../index.php" class="btn btn-nav">🏠 Início</a>
    </div>

    <header>
        <h1>👥 Cadastro de Participantes</h1>
        <p class="bem-vindo" id="bem-vindo">Bem-vindo ao torneio</p>
    </header>

    <main>
        <section class="panel formulario">
            <div class="panel-header">
                <h2>Insira os 8 participantes</h2>
                <span><?= count($participantes) ?>/8</span>
            </div>

            <form action="salvar_participantes.php" method="POST">
                <?php for ($i = 1; $i <= 8; $i++): ?>
                <div class="linha">
                    <input type="text" name="nome[]" placeholder="Nome completo do jogador <?= $i ?>" required>
                    <input type="text" name="apelido[]" placeholder="Apelido (opcional)">
                </div>
                <?php endfor; ?>
                <button type="submit" class="btn btn-full">Salvar Participantes</button>
            </form>
        </section>

        <?php if (count($participantes) > 0): ?>
        <section class="panel lista">
            <div class="panel-header">
                <h2>Participantes cadastrados</h2>
            </div>
            <div class="lista-itens">
                <?php foreach ($participantes as $jogador): ?>
                    <div class="item">
                        <strong><?= htmlspecialchars($jogador['nome'] ?? '') ?></strong>
                        <?php if (!empty($jogador['apelido'])): ?>
                            <span class="tag"><?= htmlspecialchars($jogador['apelido']) ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
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