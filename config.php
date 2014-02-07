<?php
define('DB_HOST', '');
define('DB_NAME', '');
define('DB_USER', '');
define('DB_PASSWORD', '');

/* Idiorm configuration **/
ORM::configure('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8');
ORM::configure('username', DB_USER);
ORM::configure('password', DB_PASSWORD);
ORM::configure('id_column_overrides', array(
    'currencies' => 'code'
));

