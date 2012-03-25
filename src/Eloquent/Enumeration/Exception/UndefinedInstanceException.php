<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2011 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration\Exception;

final class UndefinedInstanceException extends LogicException
{
  /**
   * @param string $class
   * @param string $key
   * @param \Exception $previous
   */
  public function __construct($class, $key, \Exception $previous = null)
  {
    parent::__construct("No instance '".$key."' defined in class '".$class."'.", $previous);
  }
}
