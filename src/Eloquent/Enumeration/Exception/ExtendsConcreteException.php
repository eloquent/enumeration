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

final class ExtendsConcreteException extends LogicException
{
  /**
   * @param string $class
   * @param string $parentClass
   * @param \Exception $previous
   */
  public function __construct($class, $parentClass, \Exception $previous = null)
  {
    parent::__construct("Class '".$class."' cannot extend concrete class '".$parentClass."'.", $previous);
  }
}
