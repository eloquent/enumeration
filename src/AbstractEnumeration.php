<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2015 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration;

use ReflectionClass;

/**
 * Abstract base class for C++ style enumerations.
 *
 * @api
 */
abstract class AbstractEnumeration extends AbstractValueMultiton implements
    EnumerationInterface
{
    /**
     * Initializes the members of this enumeration based upon its class
     * constants.
     *
     * Each constant becomes a member with a string key equal to the constant's
     * name, and a value equal to that of the constant's value.
     */
    final protected static function initializeMembers()
    {
        $reflector = new ReflectionClass(get_called_class());

        foreach ($reflector->getConstants() as $key => $value) {
            new static($key, $value);
        }
    }
}
