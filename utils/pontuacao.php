<?php

function calcularClassificacao($participantes, $rodadas)
{
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$formato = $_SESSION['formato'] ?? 'rotativas';

if ($formato === 'fixas') {

    return calcularClassificacaoFixas(
        $participantes,
        $rodadas
    );
}
    $ranking = [];

    foreach ($participantes as $jogador) {
        $ranking[$jogador['id']] = [
            'nome' => $jogador['nome'],
            'jogos' => 0,
            'vitorias' => 0,
            'derrotas' => 0,
            'gamesPro' => 0,
            'gamesContra' => 0,
            'saldo' => 0,
            'pontos' => 0
        ];
    }

    foreach ($rodadas as $rodada) {

        foreach ($rodada['partidas'] as $partida) {

            if (
                $partida['placarA'] === null ||
                $partida['placarB'] === null
            ) {
                continue;
            }

            $a = (int)$partida['placarA'];
            $b = (int)$partida['placarB'];

            foreach ($partida['duplaA'] as $id) {

                $ranking[$id]['jogos']++;
                $ranking[$id]['gamesPro'] += $a;
                $ranking[$id]['gamesContra'] += $b;
                $ranking[$id]['pontos'] += $a;
            }

            foreach ($partida['duplaB'] as $id) {

                $ranking[$id]['jogos']++;
                $ranking[$id]['gamesPro'] += $b;
                $ranking[$id]['gamesContra'] += $a;
                $ranking[$id]['pontos'] += $b;
            }

            if ($a > $b) {

                foreach ($partida['duplaA'] as $id) {
                    $ranking[$id]['vitorias']++;
                    $ranking[$id]['pontos'] += 2;
                }

                foreach ($partida['duplaB'] as $id) {
                    $ranking[$id]['derrotas']++;
                }

            } elseif ($b > $a) {

                foreach ($partida['duplaB'] as $id) {
                    $ranking[$id]['vitorias']++;
                    $ranking[$id]['pontos'] += 2;
                }

                foreach ($partida['duplaA'] as $id) {
                    $ranking[$id]['derrotas']++;
                }
            }
        }
    }

    foreach ($ranking as &$j) {
        $j['saldo'] =
            $j['gamesPro'] -
            $j['gamesContra'];
    }

    usort($ranking, function ($a, $b) {

        if ($a['pontos'] == $b['pontos']) {

            if ($a['saldo'] == $b['saldo']) {
                return $b['vitorias'] <=> $a['vitorias'];
            }

            return $b['saldo'] <=> $a['saldo'];
        }

        return $b['pontos'] <=> $a['pontos'];
    });

    return $ranking;
}
function calcularClassificacaoFixas($participantes, $rodadas)
{
    $duplas = $_SESSION['duplas_fixas'] ?? [];

    $ranking = [];

    foreach ($duplas as $dupla) {

        $nome1 = '';
        $nome2 = '';

        foreach ($participantes as $p) {

            if ($p['id'] == $dupla[0]) {
                $nome1 = $p['nome'];
            }

            if ($p['id'] == $dupla[1]) {
                $nome2 = $p['nome'];
            }
        }

        $chave = $dupla[0] . '-' . $dupla[1];

        $ranking[$chave] = [

            'nome' => $nome1 . ' / ' . $nome2,

            'jogos' => 0,
            'vitorias' => 0,
            'derrotas' => 0,

            'gamesPro' => 0,
            'gamesContra' => 0,

            'saldo' => 0,
            'pontos' => 0
        ];
    }

    foreach ($rodadas as $rodada) {

        foreach ($rodada['partidas'] as $partida) {

            if (
                $partida['placarA'] === null ||
                $partida['placarB'] === null
            ) {
                continue;
            }

            $a = (int)$partida['placarA'];
            $b = (int)$partida['placarB'];

            $chaveA =
                $partida['duplaA'][0] .
                '-' .
                $partida['duplaA'][1];

            $chaveB =
                $partida['duplaB'][0] .
                '-' .
                $partida['duplaB'][1];

            $ranking[$chaveA]['jogos']++;
            $ranking[$chaveB]['jogos']++;

            $ranking[$chaveA]['gamesPro'] += $a;
            $ranking[$chaveA]['gamesContra'] += $b;

            $ranking[$chaveB]['gamesPro'] += $b;
            $ranking[$chaveB]['gamesContra'] += $a;

            $ranking[$chaveA]['pontos'] += $a;
            $ranking[$chaveB]['pontos'] += $b;

            if ($a > $b) {

                $ranking[$chaveA]['vitorias']++;
                $ranking[$chaveA]['pontos'] += 2;

                $ranking[$chaveB]['derrotas']++;

            } else {

                $ranking[$chaveB]['vitorias']++;
                $ranking[$chaveB]['pontos'] += 2;

                $ranking[$chaveA]['derrotas']++;
            }
        }
    }

    foreach ($ranking as &$dupla) {

        $dupla['saldo'] =
            $dupla['gamesPro']
            -
            $dupla['gamesContra'];
    }

    usort($ranking, function ($a, $b) {

        if ($a['pontos'] == $b['pontos']) {

            if ($a['saldo'] == $b['saldo']) {

                return
                    $b['vitorias']
                    <=>
                    $a['vitorias'];
            }

            return
                $b['saldo']
                <=>
                $a['saldo'];
        }

        return
            $b['pontos']
            <=>
            $a['pontos'];
    });

    return $ranking;
}