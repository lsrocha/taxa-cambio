<?php
require realpath(dirname(__DIR__).'/vendor/autoload.php');
require dirname(__DIR__).DIRECTORY_SEPARATOR.'config.php';

use CurrencyConverter\Util\CSVParser;
use CurrencyConverter\Util\RemoteFile;

$dir = dirname(__DIR__).DIRECTORY_SEPARATOR.'files';
$csv = date('Ymd').'.csv';

$parser = new CSVParser();
$file = new RemoteFile();

if (!file_exists($dir)) {
    if (!mkdir($dir, 0775)) {
        echo "{$dir} could not be created.\n";
        echo "Change its parent permissions or create it by yourself (0775)\n";
        die();
    }
} else {
    if (!is_writable($dir)) {
        echo "{$dir}: It must be writable. Check it out.";
        die();
    }
}

$downloaded = $file->download(
    'http://www4.bcb.gov.br/Download/fechamento/'.$csv,
    $dir.DIRECTORY_SEPARATOR.$csv
);

if ($downloaded) {
    $allRates = $parser->getExchangeRates($dir.DIRECTORY_SEPARATOR.$csv);

    try {
        $currencies = ORM::for_table('currencies')->find_many();

        foreach ($currencies as $currency) {
            $rates = &$allRates[$currency->code];
            $currency->buying_rate = str_replace(',', '.', $rates['buying']);
            $currency->selling_rate = str_replace(',', '.', $rates['selling']);
            $currency->save();
        }
    } catch (PDOException $e) {
        echo $e->getMessage()."\n";
    }
}

