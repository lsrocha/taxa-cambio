<?php
require_once 'vendor/autoload.php';
require_once 'config.php';

use Slim\Slim;

$app = new Slim(array('debug' => SLIM_DEBUG));

$app->get('/currency', function () use ($app) {
    if (isset($_GET['code'])) {
        $code = filter_var($_GET['code'], FILTER_SANITIZE_STRING);
        $code = strtoupper($code);

        try {
            $currency = ORM::for_table('currencies')->find_one($code);

            if ($currency !== false) {
                $app->response->headers->set(
                    'Content-Type',
                    'application/json'
                );

                echo json_encode(array(
                    'currency' => $code,
                    'selling_rate' => $currency->selling_rate,
                    'buying_rate' => $currency->buying_rate,
                    'last_update' => $currency->last_update
                ));
            } else {
                $app->response->setStatus(404);
            }
        } catch (PDOException $e) {
            $app->response->setStatus(500);
        }
    } else {
        $app->response->setStatus(400);
    }
});

$app->get('/convert', function () use ($app) {
    if (isset($_GET['from'], $_GET['to'], $_GET['value'])) {
        $from = filter_var($_GET['from'], FILTER_SANITIZE_STRING);
        $from = strtoupper($from);

        $to = filter_var($_GET['to'], FILTER_SANITIZE_STRING);
        $to = strtoupper($to);

        $value = filter_var(
            $_GET['value'],
            FILTER_SANITIZE_NUMBER_FLOAT,
            FILTER_FLAG_ALLOW_FRACTION
        );

        if ($from !== 'BRL' xor $to !== 'BRL') {
            $response = array();
            $response['from'] = $from;
            $response['to'] = $to;

            try {
                $currency = ORM::for_table('currencies')->find_one(
                    $from === 'BRL' ? $to : $from
                );

                if ($currency !== false) {
                    if ($from === 'BRL') {
                        $response['rate'] = $currency->buying_rate;
                        $response['result'] = $value/$response['rate'];
                    } else {
                        $response['rate'] = $currency->selling_rate;
                        $response['result'] = $value * $response['rate'];
                    }

                    $app->response->headers->set(
                        'Content-Type',
                        'application/json'
                    );

                    echo json_encode($response);
                } else {
                    $app->response->setStatus(404);
                }
            } catch (PDOException $e) {
                $app->response->setSatus(500);
            } 
        } else {
            $app->response->setStatus(400);
        }
    } else {
        $app->response->setStatus(400);
    }
});

$app->run();

