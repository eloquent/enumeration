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

abstract class Enumeration extends Multiton
{
  /**
   * @param scalar $value
   *
   * @return Enumeration
   */
  public static final function _byValue($value)
  {
    foreach (static::_instances() as $instance)
    {
      if ($instance->_value() === $value)
      {
        return $instance;
      }
    }

    throw new Exception\UndefinedInstanceException(get_called_class(), 'value', $value);
  }

  /**
   * @return scalar
   */
  public final function _value()
  {
    return $this->_value;
  }

  protected static final function _initialize()
  {
    $reflector = new \ReflectionClass(get_called_class());
    foreach ($reflector->getConstants() as $key => $value)
    {
      new static($key, $value);
    }
  }

  /**
   * @param string $key
   * @param scalar $value
   */
  protected function __construct($key, $value)
  {
    parent::__construct($key);

    $this->_value = $value;
  }

  /**
   * @var scalar
   */
  private $_value;
}
