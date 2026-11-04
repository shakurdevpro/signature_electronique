<?php

namespace App\Support;

class StatCardsData
{
    public static function build(array $stat, string $prefix = 'chart_'): array
    {
        $cards = [
            ['id' => 'MF', 'title' => 'Mise <br/> en formation', 'key' => 'NBRE_MF', 'color' => '#F4A261'],
            ['id' => 'FF', 'title' => 'Fin <br/> de formation', 'key' => 'NBRE_FF', 'color' => '#2A9D8F'],
            ['id' => 'COMM', 'title' => "Communiqué <br/> d'admission", 'key' => 'NBRE_COMM', 'color' => '#E9C46A'],
            ['id' => 'ARR_ADM', 'title' => "Arrêté <br/> d'admission", 'key' => 'NBRE_ARR_ADM', 'color' => '#E76F51'],
            ['id' => 'COMM_OUVR', 'title' => "Communiqué <br/> d'ouverture", 'key' => 'NBRE_COMM_OUVR', 'color' => '#264653'],
            ['id' => 'ARR_OUVR', 'title' => "Arrêté <br/> d'ouverture", 'key' => 'NBRE_ARR_OUVR', 'color' => '#913D30'],
        ];

        $chartData = [];

        foreach ($cards as $i => $c) {
            $value = (int) ($stat[$c['key']] ?? 0);
            $serieKey = 'SERIE_' . $c['id'];

            if (isset($stat[$serieKey]) && count($stat[$serieKey]) >= 2) {
                $serie = array_values($stat[$serieKey]);
                $last = end($serie);
                $prev = prev($serie);
                $pct = $prev != 0 ? round((($last - $prev) / $prev) * 100, 2) : null;
            } else {
                $serie = array_fill(0, 7, $value);
                $pct = null;
            }

            $cards[$i]['value'] = $value;
            $cards[$i]['pct'] = $pct;

            $chartData[] = [
                'id' => $prefix . $c['id'],
                'title' => $c['title'],
                'color' => $c['color'],
                'data' => $serie,
            ];
        }

        $dfrcRoutes = ['MF' => 'mise_formation', 'FF' => 'fin_formation'];

        return [
            'cards' => $cards,
            'chartData' => $chartData,
            'chartLabels' => $stat['SERIE_LABELS'] ?? null,
            'dfrcRoutes' => $dfrcRoutes,
            'dfrcTitres' => ['MF' => 'Mise en formation', 'FF' => 'Fin de formation'],
            'dfrcCards' => array_values(array_filter($cards, fn($c) => isset($dfrcRoutes[$c['id']]))),
            'routesCards' => [
                'MF' => 'mise_formation',
                'FF' => 'fin_formation',
                'COMM' => 'communique',
                'ARR_ADM' => 'arrete',
                'COMM_OUVR' => 'comm_ouv',
                'ARR_OUVR' => 'arrete_ouv',
            ],
        ];
    }
}
