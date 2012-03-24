<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2011 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

error_reporting(E_ALL | E_STRICT | E_DEPRECATED);

// path constants
require __DIR__.'/paths.php';

// include Phake for improved mocking support
require 'Phake.php';
Phake::setClient(Phake::CLIENT_PHPUNIT);

// use Composer for autoloading
$autoloader = require LQNT_VENDOR_DIR.DIRECTORY_SEPARATOR.'.composer'.DIRECTORY_SEPARATOR.'autoload.php';
$autoloader->add('Eloquent', LQNT_TEST_SRC_DIR);
