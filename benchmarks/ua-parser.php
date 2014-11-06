<?php

require __DIR__ . '/../vendor/autoload.php';

$cacheDir = __DIR__ . '/../cache';
$resultsFile = $cacheDir . '/output-ua-parser.txt';
$agentListFile = __DIR__ . '/../data/ua-list.txt';

$agents = file($agentListFile);

$bench = new Ubench;
$bench->start();

$parser = UAParser\Parser::create();
$results = '';

foreach ($agents as $agentString) {
    $r = $parser->parse($agentString);
    $results .= json_encode(array($r->os->family, $r->ua->family, $r->ua->toVersion())) . "\n";
    break;  // remove if you want to check all the list
}

$bench->end();

file_put_contents($resultsFile, $results);

echo $bench->getTime(true), ' secs ', PHP_EOL;
echo $bench->getMemoryPeak(true), ' bytes', PHP_EOL;
