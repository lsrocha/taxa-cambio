<?php
namespace ConversorMonetario\Util;

class CSVParser
{
    public function getExchangeRates($csv)
    {
        $rates = array();
        $fp = fopen($csv, 'r');

        while (($data = fgetcsv($fp, 0, ';')) !== false) {
            $rates[] = array(
                'code' => $data[3],
                'value' => $data[4]
            );
        }

        return $rates;
    }
}

