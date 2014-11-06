<?php

ini_set('memory_limit', -1);

require __DIR__ . '/../vendor/autoload.php';

$cacheDir = __DIR__ . '/../cache';
$resultsFile = $cacheDir . '/output-browscap-php.txt';
$agentListFile = __DIR__ . '/../data/ua-list.txt';

$agents = file($agentListFile);

$bench = new Ubench;
$bench->start();

$browscap = new phpbrowscap\Browscap($cacheDir);
$browscap->doAutoUpdate = false;
$results = '';

foreach ($agents as $agentString) {
    $r = $browscap->getBrowser($agentString);
    $results .= json_encode(array($r->Platform, $r->Browser, $r->Version)) . "\n";
    break;  // remove if you want to check all the list
}

$bench->end();

file_put_contents($resultsFile, $results);

echo $bench->getTime(true), ' secs ', PHP_EOL;
echo $bench->getMemoryPeak(true), ' bytes', PHP_EOL;
