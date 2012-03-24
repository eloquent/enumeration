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

abstract class LogicException extends \LogicException implements Exception
{
  /**
   * @param string $message
   * @param \Exception $previous
   */
  public function __construct($message, \Exception $previous = null)
  {
    parent::__construct((string)$message, 0, $previous);
  }
}
