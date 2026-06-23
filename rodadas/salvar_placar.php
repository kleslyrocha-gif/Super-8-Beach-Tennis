<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: rodadas.php');
    exit;
}

$rodada = $_POST['rodada'] ?? null;
$partida = $_POST['partida'] ?? null;
$placarA = (int)($_POST['placarA'] ?? -1);
$placarB = (int)($_POST['placarB'] ?? -1);
if ($placarA === $placarB) {

    echo "
    <script>
        alert('Empates não são permitidos neste torneio.');
        history.back();
    </script>
    ";

    exit;
}

if ($rodada === null || $partida === null || $placarA < 0 || $placarB < 0) {
    die('Dados inválidos para salvar o placar.');
}

$arquivo = '../data/rodadas.json';
$dados = json_decode(file_get_contents($arquivo), true) ?: [];

if (!isset($dados['rodadas'][$rodada]['partidas'][$partida])) {
    die('Partida não encontrada.');
}

$dados['rodadas'][$rodada]['partidas'][$partida]['placarA'] = $placarA;
$dados['rodadas'][$rodada]['partidas'][$partida]['placarB'] = $placarB;

file_put_contents(
    $arquivo,
    json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);

header('Location: rodadas.php');
exit;