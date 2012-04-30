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

class ValidMultiton extends TestMultiton
{
  /**
   * @return string
   */
  public function _value()
  {
    return $this->_value;
  }

  protected static function _initialize()
  {
    parent::_initialize();

    new static('BAZ', 'zab');
  }

  /**
   * @param string $key
   * @param string $value
   */
  protected function __construct($key, $value)
  {
    parent::__construct($key);

    $this->_value = $value;
  }

  /**
   * @var array
   */
  protected static $_calls = array();

  /**
   * @var string
   */
  protected $_value;
}
