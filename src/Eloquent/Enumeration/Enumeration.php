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

abstract class Enumeration
{
  /**
   * @param string $name
   * @param array $arguments
   *
   * @return Enumeration
   */
  public static final function __callStatic($name, array $arguments)
  {
    return self::byName(get_called_class(), $name);
  }

  protected static function initialize() {}

  /**
   * @param string $name
   *
   * @return Enumeration
   */
  protected static function create($name)
  {
    return new static($name);
  }

  /**
   * @param string $class
   *
   * @return array
   */
  private static function valuesByClass($class)
  {
    if (!array_key_exists($class, self::$values))
    {
      $reflector = new \ReflectionClass($class);
      self::$values[$class] = $reflector->getConstants();
    }

    return self::$values[$class];
  }

  /**
   * @param string $class
   * @param string $name
   *
   * @return scalar
   */
  private static function valueByName($class, $name)
  {
    $values = self::valuesByClass($class);
    if (!array_key_exists($name, $values))
    {
      throw new Exception\UndefinedEnumerationException($class, $name);
    }

    return $values[$name];
  }

  /**
   * @param string $class
   * @param string $name
   *
   * @return Enumeration
   */
  private static function byName($class, $name)
  {
    if (!array_key_exists($class, self::$enumerations))
    {
      static::initialize();
      self::$enumerations[$class] = array();
    }
    if (!array_key_exists($name, self::$enumerations[$class]))
    {
      self::$enumerations[$class][$name] = static::create($name);
    }

    return self::$enumerations[$class][$name];
  }

  /**
   * @param string $name
   */
  protected function __construct($name)
  {
    $this->name = $name;
    $this->value = self::valueByName(get_called_class(), $name);
  }

  /**
   * @return string
   */
  public function name()
  {
    return $this->name;
  }

  /**
   * @return scalar
   */
  public function value()
  {
    return $this->value;
  }

  /**
   * @var array
   */
  private static $enumerations = array();

  /**
   * @var array
   */
  private static $values = array();

  /**
   * @var string
   */
  private $name;

  /**
   * @var scalar
   */
  private $value;
}
