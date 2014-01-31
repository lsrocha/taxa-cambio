<?php
require('src/ConversorMonetario/Util/CSVParser.php');

use ConversorMonetario\Util\CSVParser;

$parser = new CSVParser();
$parser->getExchangeRates('20140131.csv');

//$ch = curl_init('http://www4.bcb.gov.br/Download/fechamento/20140131.csv');
//$fp = fopen(date('Ymd').'.csv', 'w');
//
//curl_setopt($ch, CURLOPT_FILE, $fp);
//curl_setopt($ch, CURLOPT_HEADER, 0);
//
//curl_exec($ch);
//curl_close($ch);
//fclose($fp);

