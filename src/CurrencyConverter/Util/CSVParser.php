<?php
namespace CurrencyConverter\Util;

class CSVParser
{
    public function getExchangeRates($csv)
    {
        $rates = array();
        $fp = fopen($csv, 'r');

        if ($fp !== false) {
            while (($data = fgetcsv($fp, 0, ';')) !== false) {
                if (count($data) <= 4) break;
                $rates[$data[3]] = array(
                    'buying' => $data[4],
                    'selling' => $data[5]
                );
            }
        }

        return $rates;
    }
}

