<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2012 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration\Exception;

/**
 * The requested member instance was not found.
 */
final class UndefinedInstanceException extends LogicException
{
    /**
     * Construct a new UndefinedInstanceException instance.
     *
     * @param string $class The class from which the member was requested.
     * @param string $property The name of the property used to search for the member.
     * @param string $value The value of the property used to search for the member.
     * @param \Exception $previous The previous exception, if any.
     */
    public function __construct($class, $property, $value, \Exception $previous = null)
    {
        $message =
            "No instance with ".
            $property.
            " equal to ".
            var_export($value, true).
            " defined in class '".
            $class.
            "'."
        ;

      parent::__construct($message, $previous);
    }
}
