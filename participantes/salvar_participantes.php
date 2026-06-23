<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cadastro.php');
    exit;
}

$nomes = $_POST['nome'] ?? [];
$apelidos = $_POST['apelido'] ?? [];

$participantes = [];

for ($i = 0; $i < 8; $i++) {

    $nome = trim($nomes[$i] ?? '');

    if ($nome === '') {
        die('Todos os jogadores devem possuir nome.');
    }

    $participantes[] = [
        'id' => $i + 1,
        'nome' => $nome,
        'apelido' => trim($apelidos[$i] ?? '')
    ];
}

file_put_contents(
    '../data/participantes.json',
    json_encode(
        $participantes,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    )
);

if (($_SESSION['formato'] ?? 'rotativas') === 'fixas') {
    header('Location: ../participantes/montar_duplas.php');
} else {
    header('Location: ../configuracao/gerar_rodadas.php');
}
exit;