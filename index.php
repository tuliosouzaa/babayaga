<?php

error_reporting(0);

$ssl_options = array(
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
    ),
);

$players = [
    "Peter" => "181684601",
    "Cabas" => "427349008",
    "Itauna" => "860295392",
    "Bisnaga" => "155110917",
    "Ruan" => "156551818",
    "Samarosa" => "370427017",
    "Merendinha" => "331916123"
];

$dpk = array();
foreach ($players as $player => $id) {
    echo "------------------" . PHP_EOL;
    echo "Stats for player: $player" . PHP_EOL;
    $kills = 0;
    $damage = 0;
    $stats = json_decode(file_get_contents("https://api.opendota.com/api/players/{$id}/totals?game_mode=23&significant=0", false, stream_context_create($ssl_options)), true);
    foreach ($stats as $stat) {
        if ($stat['field'] == 'kills') {
            $kills = $stat['sum'] / $stat['n'];
            echo "Average kills: $kills" . PHP_EOL;
        }
        if ($stat['field'] == 'hero_damage') {
            $damage = $stat['sum'] / $stat['n'];
            echo "Average damage: $damage" . PHP_EOL;
        }
    }
    $damage_per_kill = $damage / $kills;
    $dpk[$player] = $damage_per_kill;
    echo "Average damage per kill: $damage_per_kill" . PHP_EOL;
    echo "------------------" . PHP_EOL;
}

var_dump($dpk);