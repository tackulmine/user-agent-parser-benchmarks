<?php

ini_set('max_execution_time', 0);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config.php';

$cacheDir = $config['cacheDir'];
$resultsFile = $cacheDir . '/output-get_browser.txt';
$agentListFile = $config['userAgentListFile'];

$testAgent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7) Gecko/20040803 Firefox/0.9.3';
if (get_browser($testAgent) === false) {
    echo 'Error: Can\'t use get_browser(). Please set browscap in php.ini.', PHP_EOL;
    echo 'browscap = ' . realpath($cacheDir . '/browscap.ini') . PHP_EOL;
    exit(1);
}

$agents = file($agentListFile);

$bench = new Ubench;
$bench->start();

$results = '';

foreach ($agents as $agentString) {
    $r = get_browser($agentString);
    $results .= json_encode(array($r->platform, $r->browser, $r->version)) . "\n";
}

$bench->end();

file_put_contents($resultsFile, $results);

echo $bench->getTime(true), ' secs ', PHP_EOL;
echo $bench->getMemoryPeak(true), ' bytes', PHP_EOL;
