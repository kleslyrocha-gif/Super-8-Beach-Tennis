<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuração do Torneio</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="top-nav">
        <a href="javascript:history.back()" class="btn btn-nav">← Voltar</a>
        <a href="../index.php" class="btn btn-nav">🏠 Início</a>
    </div>

    <header>
        <h1>⚙️ Configurar Torneio</h1>
        <p class="bem-vindo" id="bem-vindo">Bem-vindo ao torneio</p>
    </header>

    <main>
        <section class="panel configuracao">
           <form id="formatoForm" method="POST">
                <h2>Escolha o formato das duplas</h2>
                <div class="opcoes">
                    <label class="opcao">
                        <input type="radio" name="formato" value="rotativas" checked>
                        <span>Duplas Rotativas</span>
                    </label>
                    <label class="opcao">
                        <input type="radio" name="formato" value="fixas">
                        <span>Duplas Fixas</span>
                    </label>
                </div>
                <button class="btn btn-full">Gerar 7 Rodadas</button>
            </form>
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
    <script>
document.getElementById('formatoForm').addEventListener('submit', function(e){

    const formato =
        document.querySelector('input[name="formato"]:checked').value;

    if(formato === 'fixas'){
        this.action = '../participantes/montar_duplas.php';
    }else{
        this.action = '../participantes/cadastro.php';
    }

});
</script>
</body>
</html>