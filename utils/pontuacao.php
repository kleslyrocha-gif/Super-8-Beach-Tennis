<?php

function calcularClassificacao($participantes, $rodadas)
{
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