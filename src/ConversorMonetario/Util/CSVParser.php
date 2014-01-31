<?php
namespace ConversorMonetario\Util;

class CSVParser
{
    public function getExchangeRates($csv)
    {
        $fp = fopen($csv, 'r');

        while (($data = fgetcsv($fp, 0, ';')) !== false) {
            echo $data[3].' '.$data[4]."\n";
        }
    }
}

