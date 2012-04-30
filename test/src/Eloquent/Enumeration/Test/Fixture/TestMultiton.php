<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2011 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration\Test\Fixture;

use Eloquent\Enumeration\Multiton;

abstract class TestMultiton extends Multiton
{
  public static function _resetCalls()
  {
    static::$_calls = array();
  }

  /**
   * @return array
   */
  public static function _calls()
  {
    return static::$_calls;
  }

  protected static function _initialize()
  {
    parent::_initialize();

    static::$_calls[] = array(get_called_class().'::'.__FUNCTION__, func_get_args());

    new static('FOO', 'oof');
    new static('BAR', 'rab');
  }
}
