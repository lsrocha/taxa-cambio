<?php
require_once 'vendor/autoload.php';
require_once 'config.php';

use Slim\Slim;

$app = new Slim();

$app->get('/rates', function () {
    $from = filter_var($_GET['from'], FILTER_SANITIZE_STRING);
    $from = strtoupper($from);

    try {
        $currency = ORM::for_table('currencies')->find_one($from);

        echo json_encode(array(
            'currency' => $from,
            'value' => $currency->value
        ));
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
});

$app->get('/convert', function () {
    $from = filter_var($_GET['from'], FILTER_SANITIZE_STRING);
    $from = strtoupper($from);

    $to = filter_var($_GET['to'], FILTER_SANITIZE_STRING);
    $to = strtoupper($to);

    $value = filter_var(
        $_GET['value'],
        FILTER_SANITIZE_NUMBER_FLOAT,
        FILTER_FLAG_ALLOW_FRACTION
    );

    $response = array();
    $response['from'] = $from;
    $response['to'] = $to;

    try {
        $currency = ORM::for_table('currencies')->find_one(
            $from === 'BRL' ? $to : $from
        );

        if ($from === 'BRL') {
            $response['value'] = $value/$currency->value;
        } else {
            $response['value'] = $value * $currency->value;
        }

        echo json_encode($response);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
});

$app->run();

