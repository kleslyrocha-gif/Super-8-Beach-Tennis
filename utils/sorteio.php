<?php

function embaralharJogadores($participantes)
{
    shuffle($participantes);
    return $participantes;
}

function gerarRodadasRotativas($participantes)
{
    $ids = array_column($participantes, 'id');

    $rodadas = [];

    $combinacoes = [

        [[0,1],[2,3],[4,5],[6,7]],

        [[0,2],[1,3],[4,6],[5,7]],

        [[0,3],[1,2],[4,7],[5,6]],

        [[0,4],[1,5],[2,6],[3,7]],

        [[0,5],[1,4],[2,7],[3,6]],

        [[0,6],[1,7],[2,4],[3,5]],

        [[0,7],[1,6],[2,5],[3,4]]

    ];

    foreach ($combinacoes as $numero => $duplas) {

        $rodadas[] = [

            'numero' => $numero + 1,

            'partidas' => [

                [
                    'quadra' => 1,

                    'duplaA' => [
                        $ids[$duplas[0][0]],
                        $ids[$duplas[0][1]]
                    ],

                    'duplaB' => [
                        $ids[$duplas[1][0]],
                        $ids[$duplas[1][1]]
                    ],

                    'placarA' => null,
                    'placarB' => null
                ],

                [
                    'quadra' => 2,

                    'duplaA' => [
                        $ids[$duplas[2][0]],
                        $ids[$duplas[2][1]]
                    ],

                    'duplaB' => [
                        $ids[$duplas[3][0]],
                        $ids[$duplas[3][1]]
                    ],

                    'placarA' => null,
                    'placarB' => null
                ]
            ]
        ];
    }

    return $rodadas;
}
function gerarRodadasFixas($participantes)
{
   if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    $duplas = $_SESSION['duplas_fixas'] ?? [];

    if (count($duplas) !== 4) {
        die('As duplas fixas não foram configuradas.');
    }

    $d1 = $duplas[0];
    $d2 = $duplas[1];
    $d3 = $duplas[2];
    $d4 = $duplas[3];

    $confrontos = [

        [[$d1, $d2], [$d3, $d4]],
        [[$d1, $d3], [$d2, $d4]],
        [[$d1, $d4], [$d2, $d3]],
        [[$d2, $d1], [$d4, $d3]],
        [[$d3, $d1], [$d4, $d2]],
        [[$d4, $d1], [$d3, $d2]],
        [[$d1, $d2], [$d3, $d4]]

    ];

    $rodadas = [];

    foreach ($confrontos as $i => $rodada) {

        $rodadas[] = [

            'numero' => $i + 1,

            'partidas' => [

                [
                    'quadra' => 1,
                    'duplaA' => $rodada[0][0],
                    'duplaB' => $rodada[0][1],
                    'placarA' => null,
                    'placarB' => null
                ],

                [
                    'quadra' => 2,
                    'duplaA' => $rodada[1][0],
                    'duplaB' => $rodada[1][1],
                    'placarA' => null,
                    'placarB' => null
                ]
            ]
        ];
    }

    return $rodadas;
}