<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2015 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration\Exception;

use Exception;

/**
 * An abstract base class for implementing undefined member exceptions.
 */
abstract class AbstractUndefinedMemberException extends Exception implements
    UndefinedMemberExceptionInterface
{
    /**
     * Construct a new undefined member exception.
     *
     * @param string         $message   The exception message.
     * @param string         $className The name of the class from which the member was requested.
     * @param string         $property  The name of the property used to search for the member.
     * @param mixed          $value     The value of the property used to search for the member.
     * @param Exception|null $cause     The cause, if available.
     */
    public function __construct(
        $message,
        $className,
        $property,
        $value,
        Exception $cause = null
    ) {
        $this->className = $className;
        $this->property = $property;
        $this->value = $value;

        parent::__construct($message, 0, $cause);
    }

    /**
     * Get the class name.
     *
     * @return string The class name.
     */
    public function className()
    {
        return $this->className;
    }

    /**
     * Get the property name.
     *
     * @return string The property name.
     */
    public function property()
    {
        return $this->property;
    }

    /**
     * Get the value of the property used to search for the member.
     *
     * @return mixed The value.
     */
    public function value()
    {
        return $this->value;
    }

    private $className;
    private $property;
    private $value;
}
