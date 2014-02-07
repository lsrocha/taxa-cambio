<?php
require_once 'vendor/autoload.php';
require_once 'config.php';

use ConversorMonetario\Util\CSVParser;
use ConversorMonetario\Util\RemoteFile;

$csv = date('Ymd').'.csv';
$parser = new CSVParser();
$file = new RemoteFile();

$downloaded = $file->download(
    'http://www4.bcb.gov.br/Download/fechamento/'.$csv,
    'files/'.$csv
);

if ($downloaded) {
    $rates = $parser->getExchangeRates('files/'.$csv);

    try {
        $currencies = ORM::for_table('currencies')->find_many();

        foreach ($currencies as $currency) {
            $rate = str_replace(',', '.', $rates[$currency->code]); 
            $currency->value = str_replace(',', '.', $rate);
            $currency->save();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

