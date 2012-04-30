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
  public static final function _instances()
  {
    $class = get_called_class();
    if (!array_key_exists($class, self::$_instances))
    {
      self::$_instances[$class] = array();
      static::_initialize();
    }

    return self::$_instances[$class];
  }

  /**
   * @param string $key
   *
   * @return Multiton
   */
  public static final function _get($key)
  {
    $instances = static::_instances();
    if (array_key_exists($key, $instances))
    {
      return $instances[$key];
    }

    throw new Exception\UndefinedInstanceException(get_called_class(), 'key', $key);
  }

  /**
   * @param string $key
   * @param array $arguments
   *
   * @return Multiton
   */
  public static final function __callStatic($key, array $arguments)
  {
    return static::_get($key);
  }

  /**
   * @return string
   */
  public final function _key()
  {
    return $this->_key;
  }

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->_key();
  }

  protected static function _initialize() {}

  /**
   * @param string $key
   */
  protected function __construct($key)
  {
    $this->_key = $key;

    self::_register($this);
  }

  private static function _register(self $instance)
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

    self::$_instances[get_called_class()][$instance->_key()] = $instance;
  }

  /**
   * @var array
   */
  private static $_instances = array();

  /**
   * @var string
   */
  private $_key;
}
