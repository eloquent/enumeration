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

/**
 * The supplied member instance extends an already concrete base class.
 *
 * This exception exists to prevent otherwise valid inheritance structures
 * that are not valid in the context of enumerations.
 */
final class ExtendsConcreteException extends LogicException
{
  /**
   * Construct a new ExtendsConcreteException instance.
   *
   * @param string $class The class of the supplied instance.
   * @param string $parentClass The concrete parent class.
   * @param \Exception $previous The previous exception, if any.
   */
  public function __construct($class, $parentClass, \Exception $previous = null)
  {
    parent::__construct("Class '".$class."' cannot extend concrete class '".$parentClass."'.", $previous);
  }
}
