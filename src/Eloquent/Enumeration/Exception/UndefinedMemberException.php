<?php

/*
 * This file is part of the Enumeration package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Enumeration\Exception;

use Exception;
use LogicException;

/**
 * The requested member was not found.
 */
final class UndefinedMemberException extends LogicException implements
    UndefinedMemberExceptionInterface
{
    /**
     * Construct a new undefined member exception.
     *
     * @param string    $className The name of the class from which the member was requested.
     * @param string    $property  The name of the property used to search for the member.
     * @param mixed     $value     The value of the property used to search for the member.
     * @param Exception $previous  The cause, if available.
     */
    public function __construct($className, $property, $value, Exception $previous = null)
    {
        $this->className = $className;
        $this->property = $property;
        $this->value = $value;

        parent::__construct(
            sprintf(
                "No member with %s equal to %s defined in class '%s'.",
                $this->property(),
                var_export($this->value(), true),
                $this->className()
            ),
            0,
            $previous
        );
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
