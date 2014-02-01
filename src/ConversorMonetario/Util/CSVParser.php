<?php
namespace ConversorMonetario\Util;

class CSVParser
{
    public function getExchangeRates($csv)
    {
        $rates = array();
        $fp = fopen($csv, 'r');

        if ($fp !== false) {
            while (($data = fgetcsv($fp, 0, ';')) !== false) {
                if (count($data) <= 4) break;

                $rates[] = array(
                    'code' => $data[3],
                    'value' => $data[4]
                );
            }
        }

        return $rates;
    }
}

