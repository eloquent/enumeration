<?php

// include fixtures than cannot be autoloaded
$documentationFixturePath =
    __DIR__.'/src/Eloquent/Enumeration/Test/Fixture/Documentation'
;
require $documentationFixturePath.'/HTTPRequestMethod.php';
require $documentationFixturePath.'/Planet.php';
