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

use Eloquent\Enumeration\Enumeration;

class TestEnumeration extends Enumeration
{
  const FOO = 'oof';
  const BAR = 'rab';

  public static function resetCalls()
  {
    self::$initializeCalls = array();
    self::$createCalls = array();
  }

  /**
   * @return array
   */
  public static function initializeCalls()
  {
    return self::$initializeCalls;
  }

  /**
   * @return array
   */
  public static function createCalls()
  {
    return self::$createCalls;
  }

  protected static function initialize()
  {
    self::$initializeCalls[] = func_get_args();

    parent::initialize();
  }

  /**
   * @param string $name
   *
   * @return Enumeration
   */
  protected static function create($name)
  {
    self::$createCalls[] = func_get_args();

    return parent::create($name);
  }

  /**
   * @var array
   */
  protected static $initializeCalls = array();

  /**
   * @var array
   */
  protected static $createCalls = array();
}
