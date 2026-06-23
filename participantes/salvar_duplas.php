<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$participantes = [];
$duplas = [];

$id = 1;

for ($i = 1; $i <= 4; $i++) {

    $j1 = trim($_POST["dupla{$i}"][0] ?? '');
    $j2 = trim($_POST["dupla{$i}"][1] ?? '');

    if ($j1 === '' || $j2 === '') {
        die('Todos os jogadores devem ser preenchidos.');
    }

    $id1 = $id++;
    $id2 = $id++;

    $participantes[] = [
        'id' => $id1,
        'nome' => $j1,
        'apelido' => ''
    ];

    $participantes[] = [
        'id' => $id2,
        'nome' => $j2,
        'apelido' => ''
    ];

    $duplas[] = [$id1, $id2];
}

file_put_contents(
    '../data/participantes.json',
    json_encode(
        $participantes,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    )
);

$_SESSION['duplas_fixas'] = $duplas;
$_SESSION['formato'] = 'fixas';

header('Location: ../configuracao/gerar_rodadas.php');
exit;