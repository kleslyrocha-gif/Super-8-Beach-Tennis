<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cadastro.php');
    exit;
}

$nomes = $_POST['nome'] ?? [];
$apelidos = $_POST['apelido'] ?? [];

if (count($nomes) < 8 || count($apelidos) < 8) {
    die('Erro ao salvar: todos os campos precisam ser preenchidos.');
}

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

$arquivo = '../data/participantes.json';
file_put_contents(
    $arquivo,
    json_encode(
        $participantes,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    )
);

header('Location: cadastro.php');
exit;