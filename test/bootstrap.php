<?php

$autoloader = require __DIR__.'/../vendor/autoload.php';
$autoloader->add('Eloquent', __DIR__.'/src');

Phake::setClient(Phake::CLIENT_PHPUNIT);

// include fixtures than cannot be autoloaded
$documentationFixturePath =
    __DIR__.'/src/Eloquent/Enumeration/Test/Fixture/Documentation'
;
require $documentationFixturePath.'/HTTPRequestMethod.php';
require $documentationFixturePath.'/Planet.php';
