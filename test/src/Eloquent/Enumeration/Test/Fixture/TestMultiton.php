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

use Eloquent\Enumeration\AbstractMultiton;

abstract class TestMultiton extends AbstractMultiton
{
    protected static function initializeMembers()
    {
        parent::initializeMembers();

        static::$calls[] = array(
            get_called_class() . '::' . __FUNCTION__,
            func_get_args()
        );

        new static('FOO', 'oof');
        new static('BAR', 'rab');
    }
}
