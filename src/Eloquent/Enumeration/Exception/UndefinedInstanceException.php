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
 * The requested member instance was not found.
 */
final class UndefinedInstanceException extends LogicException implements UndefinedInstanceExceptionInterface
{
    /**
     * Construct a new UndefinedInstanceException instance.
     *
     * @param string $className The class from which the member was requested.
     * @param string $property The name of the property used to search for the member.
     * @param mixed $value The value of the property used to search for the member.
     * @param Exception $previous The previous exception, if any.
     */
    public function __construct($className, $property, $value, Exception $previous = null)
    {
        $this->className = $className;
        $this->property = $property;
        $this->value = $value;

        parent::__construct(
            sprintf(
                "No instance with %s equal to %s defined in class '%s'.",
                $this->property(),
                var_export($this->value(), true),
                $this->className()
            ),
            0,
            $previous
        );
    }

    /**
     * @return string
     */
    public function className()
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function property()
    {
        return $this->property;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    private $className;
    private $property;
    private $value;
}
