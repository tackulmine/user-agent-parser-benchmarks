<?php

require __DIR__ . '/../config.php';

$url = $config['baseUrl'];
$output = __DIR__ . '/../cache/benchmark-results.json';

$parsers = array('crossjoin-browscap', 'get_browser', 'browscap-php', 'ua-parser', 'woothee');

foreach ($parsers as $parser) {
    echo 'Benchmarking ' . $parser . ' ...';
    $result = file_get_contents($url . '/benchmarks/' . $parser .'.php');
    $tmp = explode("\n", $result);
    $time = (float) trim($tmp[0], ' sec');
    $memory = (int) trim($tmp[1], ' bytes');
    echo "\t" . substr($time, 0, 9) . 'secs ' . "\t" . ($memory/1024)/1024 . 'MB' . PHP_EOL;
    
    $data[$parser] = array(
        'time' => $time,
        'memory' => $memory,
    );
}

file_put_contents($output, json_encode($data));
