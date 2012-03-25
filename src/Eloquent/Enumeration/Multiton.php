<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2011 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration;

abstract class Multiton
{
  /**
   * @return array
   */
  public static final function instances()
  {
    $class = get_called_class();
    if (!array_key_exists($class, self::$instances))
    {
      self::$instances[$class] = array();
      static::initialize();
    }

    return self::$instances[$class];
  }

  /**
   * @param string $key
   *
   * @return Multiton
   */
  public static final function get($key)
  {
    $instances = static::instances();
    if (array_key_exists($key, $instances))
    {
      return $instances[$key];
    }

    throw new Exception\UndefinedInstanceException(get_called_class(), $key);
  }

  /**
   * @param string $key
   * @param array $arguments
   *
   * @return Multiton
   */
  public static final function __callStatic($key, array $arguments)
  {
    return static::get($key);
  }

  /**
   * @return string
   */
  public final function key()
  {
    return $this->key;
  }

  protected static function initialize() {}

  /**
   * @param string $key
   */
  protected function __construct($key)
  {
    $this->key = $key;

    self::register($this);
  }

  private static function register(self $instance)
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
   * @var array
   */
  private static $instances = array();

  /**
   * @var string
   */
  private $key;
}
