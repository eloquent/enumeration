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
 * Base class for exceptions that arise from logic errors in code.
 */
abstract class LogicException extends \LogicException implements Exception
{
  /**
   * Construct a new LogicError instance.
   *
   * @param string $message The exception message.
   * @param \Exception $previous The previous exception, if any.
   */
  public function __construct($message, \Exception $previous = null)
  {
    parent::__construct((string)$message, 0, $previous);
  }
}
