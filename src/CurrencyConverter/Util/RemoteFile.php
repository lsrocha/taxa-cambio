<?php
namespace CurrencyConverter\Util;

class RemoteFile
{
    public function download($url, $fileName)
    {
        $ch = curl_init($url);
        $fp = fopen($fileName, 'w');

        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        fclose($fp);

        return ($httpCode == 200);
    }
}

