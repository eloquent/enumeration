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

use Eloquent\Enumeration\Exception\ExtendsConcreteException;
use Eloquent\Enumeration\Exception\UndefinedInstanceException;
use Exception;

/**
 * Base class for Java style enumerations.
 */
abstract class Multiton
{
    /**
     * Returns an array of all member instancess in this multiton.
     *
     * @return array<string,Multiton> All member instancess in this multiton.
     */
    public static final function multitonInstances()
    {
        $class = get_called_class();
        if (!array_key_exists($class, self::$instances)) {
            self::$instances[$class] = array();
            static::initializeMultiton();
        }

        return self::$instances[$class];
    }

    /**
     * Returns a single member instance by string key.
     *
     * @param string $key The string key associated with the member instance.
     *
     * @return Multiton The member instance associated with the given string key.
     * @throws UndefinedInstanceException If no associated instance is found.
     */
    public static final function instanceByKey($key)
    {
        $instances = static::multitonInstances();
        if (array_key_exists($key, $instances)) {
            return $instances[$key];
        }

        throw static::createUndefinedInstanceException(get_called_class(), 'key', $key);
    }

    /**
     * Returns a single member instance by comparison with the result of an accessor method.
     *
     * @param string $property The name of the property (accessor method) to match.
     * @param mixed $value The value to match.
     *
     * @return Multiton The first member instance for which $instance->{$property}() === $value.
     * @throws UndefinedInstanceException If no associated instance is found.
     */
    public static final function instanceBy($property, $value) {
        foreach (static::multitonInstances() as $instance) {
            if ($instance->{$property}() === $value) {
                return $instance;
            }
        }

        throw static::createUndefinedInstanceException(get_called_class(), $property, $value);
    }

    /**
     * Returns a single member instance by predicate callback.
     *
     * @param callback $predicate The predicate applies to the multiton instance to find a match.
     *
     * @return Multiton The first member instance for which $predicate($instance) evaluates to boolean true.
     * @throws UndefinedInstanceException If no associated instance is found.
     */
    public static final function instanceByPredicate($predicate) {
        foreach (static::multitonInstances() as $instance) {
            if ($predicate($instance)) {
                return $instance;
            }
        }

        throw static::createUndefinedInstanceException(get_called_class(), '<callback>', '<callback>');
    }

    /**
     * Maps static method calls to member instances.
     *
     * @param string $key The string key associated with the member instance.
     * @param array $arguments Ignored.
     *
     * @return Multiton The member instance associated with the given string key.
     * @throws UndefinedInstanceException If no associated instance is found.
     */
    public static final function __callStatic($key, array $arguments)
    {
        return static::instanceByKey($key);
    }

    /**
     * Returns the string key of this member instance.
     *
     * @return string The associated string key of this member instance.
     */
    public final function key()
    {
        return $this->key;
    }

    /**
     * Check if this multiton instance is in the specified list of values.
     *
     * @param Multiton $a     The first multiton instance to check.
     * @param Multiton $b     The second multiton instance to check.
     * @param Multiton $c,... Additional multiton instances to check.
     *
     * @return boolean True if this multiton instance value is in the specified list of values.
     */
    public final function anyOf(Multiton $a, Multiton $b)
    {
        return $this->anyOfArray(func_get_args());
    }

    /**
     * Check if this multiton instance is in the specified list of values.
     *
     * @param array<Multiton> $values An array of multion values to search.
     *
     * @return boolean True if this multiton instance value is in the specified list of values.
     */
    public final function anyOfArray(array $values)
    {
        return in_array($this, $values, true);
    }

    /**
     * Returns a string representation of this member instance.
     *
     * Unless overridden, this is simply the string key.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->key();
    }

    /**
     * Override this method in child classes to implement one-time initialization
     * for a multiton class.
     *
     * This method is called the first time the members of a multiton are
     * accessed. It is called via late static binding, and hence can be
     * overridden in child classes.
     */
    protected static function initializeMultiton() {}

    /**
     * Override this method in child classes to implement custom undefined
     * instance exceptions for a multiton class.
     *
     * @param string $className
     * @param string $property
     * @param mixed $value
     * @param Exception|null $previous
     *
     * @return UndefinedInstanceExceptionInterface
     */
    protected static function createUndefinedInstanceException(
        $className,
        $property,
        $value,
        Exception $previous = null
    ) {
        return new UndefinedInstanceException($className, $property, $value, $previous);
    }

    /**
     * Construct and register a new multiton member instance.
     *
     * If you override the constructor in a child class, you MUST call the parent
     * constructor. Calling this constructor is the only way to set the string
     * key for this member instance, and to ensure that the instance is correctly
     * registered.
     *
     * @param string $key The string key to associate with this member instance.
     *
     * @throws ExtendsConcreteException If the constructed instance has an invalid inheritance hierarchy.
     */
    protected function __construct($key)
    {
        $this->key = $key;

        self::registerMultiton($this);
    }

    /**
     * Registers the supplied member instance.
     *
     * Do not attempt to call this method directly. Instead, ensure that
     * Multiton::__construct() is called from any child classes, as this will
     * also handle registration of the instance.
     *
     * @param Multiton $instance The instance to register.
     * @throws ExtendsConcreteException If the supplied instance has an invalid inheritance hierarchy.
     */
    private static function registerMultiton(self $instance)
    {
        $reflector = new \ReflectionObject($instance);
        $parentClass = $reflector->getParentClass();
        if (!$parentClass->isAbstract()) {
            throw new ExtendsConcreteException(
                get_class($instance)
                , $parentClass->getName()
            );
        }

        self::$instances[get_called_class()][$instance->key()] = $instance;
    }

    /**
     * Array of all member instances of all multiton and enumeration classes.
     *
     * Instances are keyed by class name and member key string.
     *
     * @var array<string,array<string,Multiton>>
     */
    private static $instances = array();

    /**
     * String key associated with this member instance.
     *
     * @var string
     */
    private $key;
}
