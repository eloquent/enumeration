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
   *
   * @return Enumeration
   */
  public static final function byName($name)
  {
    $class = get_called_class();
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
   * @param scalar $value
   *
   * @return Enumeration
   */
  public static final function byValue($value)
  {
    foreach (static::values() as $name => $thisValue)
    {
      if ($thisValue === $value)
      {
        return static::byName($name);
      }
    }

    throw new Exception\UndefinedEnumerationValueException(get_called_class(), $value);
  }

  /**
   * @return array
   */
  public static final function values()
  {
    $class = get_called_class();
    if (!array_key_exists($class, self::$values))
    {
      $reflector = new \ReflectionClass($class);
      self::$values[$class] = $reflector->getConstants();
    }

    return self::$values[$class];
  }

  /**
   * @param string $name
   * @param array $arguments
   *
   * @return Enumeration
   */
  public static final function __callStatic($name, array $arguments)
  {
    return static::byName($name);
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
   * @param string $name
   */
  protected function __construct($name)
  {
    $values = static::values();
    if (!array_key_exists($name, $values))
    {
      throw new Exception\UndefinedEnumerationException(get_called_class(), $name);
    }

    $this->name = $name;
    $this->value = $values[$name];
  }

  /**
   * @return string
   */
  public final function name()
  {
    return $this->name;
  }

  /**
   * @return scalar
   */
  public final function value()
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
