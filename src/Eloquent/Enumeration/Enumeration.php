<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration;

use ReflectionClass;

/**
 * Abstract base class for C++ style enumerations.
 */
abstract class Enumeration extends Multiton
{
    /**
     * Returns a single member by value.
     *
     * @param scalar       $value           The value associated with the member.
     * @param boolean|null $isCaseSensitive True if the search should be case sensitive.
     *
     * @return Enumeration                        The first member with the supplied value.
     * @throws Exception\UndefinedMemberException If no associated member is found.
     */
    final public static function memberByValue($value, $isCaseSensitive = null)
    {
        return static::memberBy('value', $value, $isCaseSensitive);
    }

    /**
     * Returns a single member by value. Additionally returns a default if no
     * associated member is found.
     *
     * @param scalar        $value           The value associated with the member.
     * @param Multiton|null $default         The default value to return.
     * @param boolean|null  $isCaseSensitive True if the search should be case sensitive.
     *
     * @return Enumeration The first member with the supplied value, or the default value.
     */
    final public static function memberByValueWithDefault(
        $value,
        Multiton $default = null,
        $isCaseSensitive = null
    ) {
        return static::memberByWithDefault(
            'value',
            $value,
            $default,
            $isCaseSensitive
        );
    }

    /**
     * Returns the value of this member.
     *
     * @return scalar The value of this member.
     */
    final public function value()
    {
        return $this->value;
    }

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

    /**
     * Construct and register a new enumeration member.
     *
     * @param string $key   The string key to associate with this member.
     * @param scalar $value The value of this member.
     *
     * @throws Exception\ExtendsConcreteException If the constructed member has an invalid inheritance hierarchy.
     */
    protected function __construct($key, $value)
    {
        parent::__construct($key);

        $this->value = $value;
    }

    /**
     * The value of this member.
     *
     * @var scalar
     */
    private $value;
}
