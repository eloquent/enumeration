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
     * @param string $className The class of the supplied instance.
     * @param string $parentClass The concrete parent class.
     * @param Exception $previous The previous exception, if any.
     */
    public function __construct($className, $parentClass, Exception $previous = null)
    {
        $this->className = $className;
        $this->parentClass = $parentClass;

        parent::__construct(
            sprintf(
                "Class '%s' cannot extend concrete class '%s'.",
                $this->className(),
                $this->parentClass()
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
    public function parentClass()
    {
        return $this->parentClass;
    }

    private $className;
    private $parentClass;
}
