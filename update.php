<?php
require_once 'vendor/autoload.php';
//require('src/ConversorMonetario/Util/CSVParser.php');
//require('src/ConversorMonetario/Util/RemoteFile.php');

use ConversorMonetario\Util\CSVParser;
use ConversorMonetario\Util\RemoteFile;

//$csv = date('Ymd').'.csv';
$csv = '20140131.csv';
$parser = new CSVParser();
$file = new RemoteFile();

$file->download(
    'http://www4.bcb.gov.br/Download/fechamento/'.$csv,
    'files/'.$csv
);
$rates = $parser->getExchangeRates('files/'.$csv);
var_dump($rates);

