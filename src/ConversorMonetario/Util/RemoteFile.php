<?php
namespace ConversorMonetario\Util;

class RemoteFile
{
    public function download($url, $fileName)
    {
        $ch = curl_init($url);
        $fp = fopen($fileName, 'w');

        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }
}

