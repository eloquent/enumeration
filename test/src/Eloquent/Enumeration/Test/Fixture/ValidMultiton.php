<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration\Test\Fixture;

class ValidMultiton extends TestMultiton
{
    public static function resetCalls()
    {
        static::$calls = array();
    }

    public static function calls()
    {
        return static::$calls;
    }

    public function value()
    {
        return $this->value;
    }

    protected static function initializeMembers()
    {
        parent::initializeMembers();

        new static('BAZ', 'zab');
    }

    protected function __construct($key, $value)
    {
        parent::__construct($key);

        $this->value = $value;
    }

    protected static $calls = array();
    protected $value;
}
