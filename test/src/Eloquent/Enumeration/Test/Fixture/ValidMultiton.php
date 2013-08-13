<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration\Test\Fixture;

class ValidMultiton extends TestMultiton
{
    /**
     * @return string
     */
    public function value()
    {
        return $this->value;
    }

    protected static function initializeMembers()
    {
        parent::initializeMembers();

        new static('BAZ', 'zab');
    }

    /**
     * @param string $key
     * @param string $value
     */
    protected function __construct($key, $value)
    {
        parent::__construct($key);

        $this->value = $value;
    }

    /**
     * @var array
     */
    protected static $calls = array();

    /**
     * @var string
     */
    protected $value;
}
