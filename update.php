<?php
require('src/ConversorMonetario/Util/CSVParser.php');
require('src/ConversorMonetario/Util/RemoteFile.php');

use ConversorMonetario\Util\CSVParser;
use ConversorMonetario\Util\RemoteFile;

$csv = date('Ymd').'.csv';
$parser = new CSVParser();
$file = new RemoteFile();

$file->download('http://www4.bcb.gov.br/Download/fechamento/'.$csv, $csv);
$rates = $parser->getExchangeRates($csv);
var_dump($rates);

