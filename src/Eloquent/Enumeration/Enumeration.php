<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2012 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration;

/**
 * Base class for C++ style enumerations.
 */
abstract class Enumeration extends Multiton
{
    /**
     * Returns a single member instance by value.
     *
     * @param scalar $value The value associated with the member instance.
     *
     * @return Enumeration The first member instance with the supplied value.
     * @throws UndefinedInstanceException If no associated instance is found.
     */
    public static final function instanceByValue($value)
    {
        foreach (static::multitonInstances() as $instance) {
            if ($instance->value() === $value) {
                return $instance;
            }
        }

        throw new Exception\UndefinedInstanceException(get_called_class(), 'value', $value);
    }

    /**
     * Returns the value of this member instance.
     *
     * @return scalar The value of this member instance.
     */
    public final function value()
    {
        return $this->value;
    }

    /**
     * Initializes the member instances of this enumeration based upon its class
     * constants.
     *
     * Each constant becomes a member instance with a string key equal to the
     * constant's name, and a value equal to that of the constant's value.
     */
    protected static final function initializeMultiton()
    {
        $reflector = new \ReflectionClass(get_called_class());
        foreach ($reflector->getConstants() as $key => $value) {
            new static($key, $value);
        }
    }

    /**
     * Construct and register a new enumeration member instance.
     *
     * @param string $key The string key to associate with this member instance.
     * @param scalar $value The value of this member instance.
     *
     * @throws ExtendsConcreteException If the constructed instance has an invalid inheritance hierarchy.
     */
    protected function __construct($key, $value)
    {
        parent::__construct($key);

        $this->value = $value;
    }

    /**
     * The value of this member instance.
     *
     * @var scalar
     */
    private $value;
}
