<?php

function embaralharJogadores($participantes)
{
    shuffle($participantes);
    return $participantes;
}

function gerarRodadasRotativas($participantes)
{
    $rodadas = [];

    for ($r = 1; $r <= 7; $r++) {

        $jogadores = $participantes;
        shuffle($jogadores);

        $rodadas[] = [
            "numero" => $r,
            "partidas" => [

                [
                    "quadra" => 1,

                    "duplaA" => [
                        $jogadores[0]["id"],
                        $jogadores[1]["id"]
                    ],

                    "duplaB" => [
                        $jogadores[2]["id"],
                        $jogadores[3]["id"]
                    ],

                    "placarA" => null,
                    "placarB" => null
                ],

                [
                    "quadra" => 2,

                    "duplaA" => [
                        $jogadores[4]["id"],
                        $jogadores[5]["id"]
                    ],

                    "duplaB" => [
                        $jogadores[6]["id"],
                        $jogadores[7]["id"]
                    ],

                    "placarA" => null,
                    "placarB" => null
                ]
            ]
        ];
    }

    return $rodadas;
}

function gerarRodadasFixas($participantes)
{
    shuffle($participantes);

    $d1 = [$participantes[0]['id'], $participantes[1]['id']];
    $d2 = [$participantes[2]['id'], $participantes[3]['id']];
    $d3 = [$participantes[4]['id'], $participantes[5]['id']];
    $d4 = [$participantes[6]['id'], $participantes[7]['id']];

    $confrontos = [

        [[$d1,$d2],[$d3,$d4]],
        [[$d1,$d3],[$d2,$d4]],
        [[$d1,$d4],[$d2,$d3]],
        [[$d2,$d1],[$d4,$d3]],
        [[$d3,$d1],[$d4,$d2]],
        [[$d4,$d1],[$d3,$d2]],
        [[$d1,$d2],[$d3,$d4]]

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