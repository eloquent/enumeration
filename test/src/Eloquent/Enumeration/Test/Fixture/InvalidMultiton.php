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

class InvalidMultiton extends ValidMultiton
{
    protected static function initializeMembers()
    {
        parent::initializeMembers();

        new static('QUX', 'xuq');
    }

    /**
     * @var array
     */
    protected static $calls = array();
}
