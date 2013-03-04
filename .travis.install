#!/usr/bin/env php
<?php
/**
 * This script is executed before composer dependencies are installed,
 * and as such must be included in each project as part of the skeleton.
 */
if ($token = getenv('ARCHER_TOKEN')) {
    $config = array(
        'config' => array(
            'github-oauth' => array('github.com' => $token)
        )
    );

    $file = '~/.composer/config.json';
    $dir  = dirname($file);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    file_put_contents($file, json_encode($config));

    $composerFlags = '--prefer-dist';
} else {
    $composerFlags = '--prefer-source';
}

passthru('composer install --dev --no-progress --no-interaction --ansi ' . $composerFlags);
