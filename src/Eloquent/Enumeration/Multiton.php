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
    if (!array_key_exists($class, self::$instances))
    {
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
    if (array_key_exists($key, $instances))
    {
      return $instances[$key];
    }

    throw new Exception\UndefinedInstanceException(get_called_class(), 'key', $key);
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
    if (!$parentClass->isAbstract())
    {
      throw new Exception\ExtendsConcreteException(
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
