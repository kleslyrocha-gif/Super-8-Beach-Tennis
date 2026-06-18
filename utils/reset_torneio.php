<?php

file_put_contents(
    '../data/participantes.json',
    '[]'
);

file_put_contents(
    '../data/rodadas.json',
    '{"rodadas":[]}'
);

header('Location: ../index.php');
exit;